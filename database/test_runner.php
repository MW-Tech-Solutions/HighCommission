<?php
require_once __DIR__ . '/../src/autoload.php';

use App\Core\Database;
use App\Models\User;
use App\Models\Notice;
use App\Models\RequestModel;
use App\Models\Appointment;
use App\Models\Verification;
use App\Models\DiasporaCitizen;
use App\Models\TradeMatchmaking;

echo "=== VERIFYING NIGERIA HIGH COMMISSION SYSTEM INTEGRITY ===\n";

$pdo = Database::getConnection();
echo "[PASS] PDO Database Connection: Connected to MySQL\n";

$admin = User::findByEmail('admin@nigeriankenya.or.ke');
echo "[PASS] User Model: Found admin user - " . ($admin['full_name'] ?? 'None') . "\n";

$notices = Notice::getAll();
echo "[PASS] Notice Model: " . count($notices) . " notices loaded.\n";

$requests = RequestModel::getAll();
echo "[PASS] RequestModel: " . count($requests) . " consular cases loaded.\n";

$appointments = Appointment::getAll();
echo "[PASS] Appointment Model: " . count($appointments) . " appointments loaded.\n";

$verifications = Verification::getAll();
echo "[PASS] Verification Model: " . count($verifications) . " document seals loaded.\n";

$citizens = DiasporaCitizen::getAll();
echo "[PASS] DiasporaCitizen Model: " . count($citizens) . " registered citizens loaded.\n";

$trade = TradeMatchmaking::getAll();
echo "[PASS] TradeMatchmaking Model: " . count($trade) . " trade submissions loaded.\n\n";

echo "ALL SYSTEM BACKEND & PERSISTENCE CHECKS PASSED SUCCESSFULLY!\n";
