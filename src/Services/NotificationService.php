<?php

namespace App\Services;

use App\Core\Database;
use PDO;

class NotificationService {
    /**
     * Enqueue a notification into the database-backed outbox
     */
    public static function enqueue(string $recipientEmail, string $recipientName, string $subject, string $bodyText, string $eventType): int {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            INSERT INTO notification_outbox 
            (recipient_email, recipient_name, subject, body_text, event_type, status, attempts_count, created_at)
            VALUES (:email, :name, :subject, :body, :event, 'queued', 0, NOW())
        ");
        $stmt->execute([
            ':email' => $recipientEmail,
            ':name' => $recipientName,
            ':subject' => $subject,
            ':body' => $bodyText,
            ':event' => $eventType
        ]);

        return (int)$db->lastInsertId();
    }

    /**
     * Process pending queued items in outbox with retry logic & idempotency
     * Callable via CLI/cron on standard PHP hosting.
     */
    public static function processOutbox(int $batchSize = 25): array {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT * FROM notification_outbox 
            WHERE status IN ('queued', 'failed') AND attempts_count < 3 
            ORDER BY created_at ASC LIMIT :limit
        ");
        $stmt->bindValue(':limit', $batchSize, PDO::PARAM_INT);
        $stmt->execute();
        $pending = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $results = [
            'processed' => count($pending),
            'delivered' => 0,
            'failed' => 0
        ];

        $logDir = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR;
        if (!file_exists($logDir)) {
            mkdir($logDir, 0755, true);
        }
        $logFile = $logDir . 'mail_outbox.log';

        foreach ($pending as $item) {
            $attemptNum = $item['attempts_count'] + 1;
            
            // Development / Demo Mail Sink Transport Mode:
            // Safely records mail payload to local outbox log without sending live emails to external demo addresses
            $mailContent = "[" . date('Y-m-d H:i:s') . "] OUTBOX ID #{$item['id']} [{$item['event_type']}]\n" .
                           "To: {$item['recipient_name']} <{$item['recipient_email']}>\n" .
                           "Subject: {$item['subject']}\n" .
                           "Body:\n{$item['body_text']}\n" .
                           "--------------------------------------------------\n";

            $success = (file_put_contents($logFile, $mailContent, FILE_APPEND) !== false);

            if ($success) {
                // Update status to delivered
                $upStmt = $db->prepare("UPDATE notification_outbox SET status = 'delivered', attempts_count = :ac, last_attempt_at = NOW() WHERE id = :id");
                $upStmt->execute([':ac' => $attemptNum, ':id' => $item['id']]);

                // Record delivery attempt log
                $attStmt = $db->prepare("INSERT INTO delivery_attempts (outbox_id, attempt_number, status, response_log) VALUES (:oid, :an, 'success', 'Mail logged to local test sink successfully.')");
                $attStmt->execute([':oid' => $item['id'], ':an' => $attemptNum]);

                $results['delivered']++;
            } else {
                // Mark failed
                $upStmt = $db->prepare("UPDATE notification_outbox SET status = 'failed', attempts_count = :ac, last_attempt_at = NOW() WHERE id = :id");
                $upStmt->execute([':ac' => $attemptNum, ':id' => $item['id']]);

                $attStmt = $db->prepare("INSERT INTO delivery_attempts (outbox_id, attempt_number, status, response_log) VALUES (:oid, :an, 'failed', 'Mail sink write failed.')");
                $attStmt->execute([':oid' => $item['id'], ':an' => $attemptNum]);

                $results['failed']++;
            }
        }

        return $results;
    }
}
