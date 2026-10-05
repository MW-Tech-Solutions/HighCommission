<?php
require_once __DIR__ . '/../src/autoload.php';
use App\Core\Database;

$db = Database::getConnection();
$rows = $db->query("SELECT setting_key, setting_value FROM system_settings")->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $r) {
    echo $r['setting_key'] . " => " . var_export($r['setting_value'], true) . "\n";
}
