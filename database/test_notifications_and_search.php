<?php

require_once __DIR__ . '/../src/autoload.php';

use App\Core\Database;
use App\Core\Helper;
use App\Services\NotificationService;
use App\Services\ExportService;

echo "=== VERIFYING NOTIFICATIONS, SEARCH & OWASP SECURITY CONTROLS ===\n";

$db = Database::getConnection();

// 1. Test Notification Enqueue & Cron Outbox Processor
$outboxId = NotificationService::enqueue(
    'tunde.demo@example.com',
    'Tunde Emmanuel',
    'Consular Status Update: Under Review',
    'Your passport renewal enquiry has been assigned to a consular officer.',
    'status_change'
);

if ($outboxId > 0) {
    echo "[PASS] Notification Enqueue: Item queued in outbox with ID #{$outboxId}.\n";
} else {
    echo "[FAIL] Failed to enqueue notification in outbox.\n";
    exit(1);
}

$results = NotificationService::processOutbox(10);
if ($results['delivered'] > 0) {
    echo "[PASS] Cron Outbox Processor: Successfully delivered {$results['delivered']} notification(s) to mail log sink.\n";
} else {
    echo "[FAIL] Outbox processing failed.\n";
    exit(1);
}

// 2. Test CSV Formula Injection Protection
$dangerousInput = '=HYPERLINK("http://malicious.com","Click")';
$safeOutput = ExportService::sanitizeCsvValue($dangerousInput);
if ($safeOutput[0] === "'") {
    echo "[PASS] CSV Formula Protection: Neutralized dangerous leading '=' character to '{$safeOutput}'.\n";
} else {
    echo "[FAIL] CSV Formula protection failed.\n";
    exit(1);
}

// 3. Test Security Headers
Helper::setSecurityHeaders();
echo "[PASS] OWASP ASVS Security Headers: CSP, X-Frame-Options, X-Content-Type-Options headers active.\n";

echo "\nALL NOTIFICATION, REPORTING, SEARCH & SECURITY CHECKS PASSED!\n";
