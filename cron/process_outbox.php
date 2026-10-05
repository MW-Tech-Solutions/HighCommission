<?php
/**
 * Nigeria High Commission Nairobi - Cron Outbox Processor
 * Compatible with standard PHP shared hosting (cPanel, Plesk) & CLI cron jobs.
 * Usage: php cron/process_outbox.php
 */

require_once __DIR__ . '/../src/autoload.php';

use App\Services\NotificationService;

$results = NotificationService::processOutbox(50);

echo "[" . date('Y-m-d H:i:s') . "] Notification Outbox Processor Execution Completed.\n";
echo " - Processed Items: {$results['processed']}\n";
echo " - Delivered:       {$results['delivered']}\n";
echo " - Failed:          {$results['failed']}\n";
