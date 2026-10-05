<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Database;
use PDO;

class HealthController extends Controller {
    /**
     * Operational health check endpoint for uptime monitoring
     * Returns JSON status without exposing secrets or personal data.
     */
    public function index(Request $request): void {
        header('Content-Type: application/json; charset=UTF-8');
        header('Cache-Control: no-cache, no-store, must-revalidate');

        $health = [
            'status' => 'OK',
            'timestamp' => date('c'),
            'checks' => []
        ];

        // 1. Database Connectivity Check
        try {
            $db = Database::getConnection();
            $stmt = $db->query("SELECT 1");
            if ($stmt && $stmt->fetchColumn() == 1) {
                $health['checks']['database'] = ['status' => 'PASS', 'message' => 'MySQL database responsive.'];
            } else {
                $health['status'] = 'WARNING';
                $health['checks']['database'] = ['status' => 'FAIL', 'message' => 'Query execution failed.'];
            }
        } catch (\Exception $e) {
            $health['status'] = 'FAIL';
            $health['checks']['database'] = ['status' => 'FAIL', 'message' => 'Database connection offline.'];
        }

        // 2. Storage Write Access Check
        $storageDir = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR;
        if (is_writable($storageDir)) {
            $health['checks']['storage'] = ['status' => 'PASS', 'message' => 'Private storage directory writable.'];
        } else {
            $health['status'] = 'WARNING';
            $health['checks']['storage'] = ['status' => 'FAIL', 'message' => 'Private storage directory unwritable.'];
        }

        // 3. Notification Outbox Queue Metrics
        try {
            $db = Database::getConnection();
            $pendingCount = (int)$db->query("SELECT COUNT(*) FROM notification_outbox WHERE status = 'queued'")->fetchColumn();
            $failedCount = (int)$db->query("SELECT COUNT(*) FROM notification_outbox WHERE status = 'failed'")->fetchColumn();

            $health['checks']['outbox_queue'] = [
                'status' => 'PASS',
                'pending_queued' => $pendingCount,
                'failed_delivery' => $failedCount
            ];
        } catch (\Exception $e) {
            $health['checks']['outbox_queue'] = ['status' => 'UNKNOWN'];
        }

        // Output JSON
        http_response_code($health['status'] === 'FAIL' ? 503 : 200);
        echo json_encode($health, JSON_PRETTY_PRINT);
        exit();
    }
}
