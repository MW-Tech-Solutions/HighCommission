<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class AuditLog {
    public static function log(?int $userId, ?string $userEmail, string $action, string $details): void {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO audit_logs (user_id, user_email, action, details, ip_address) VALUES (:uid, :email, :action, :details, :ip)");
        $stmt->execute([
            ':uid' => $userId,
            ':email' => $userEmail,
            ':action' => $action,
            ':details' => $details,
            ':ip' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'
        ]);
    }

    public static function getAll(int $limit = 100): array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM audit_logs ORDER BY created_at DESC LIMIT :limit");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
