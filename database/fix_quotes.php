<?php
require_once __DIR__ . '/../src/autoload.php';
use App\Core\Database;
use App\Models\SystemSetting;

$db = Database::getConnection();

// Fix high_commissioner_quote and clean any HTML entities double encoding in system_settings
$rows = $db->query("SELECT id, setting_key, setting_value FROM system_settings")->fetchAll(PDO::FETCH_ASSOC);

$updateStmt = $db->prepare("UPDATE system_settings SET setting_value = :val WHERE id = :id");

foreach ($rows as $r) {
    $val = $r['setting_value'];
    
    // Decode HTML entities recursively (e.g. &amp;quot; -> &quot; -> ")
    while (strpos($val, '&amp;') !== false || strpos($val, '&quot;') !== false) {
        $val = html_entity_decode($val, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
    
    // Also remove any escaped backslashes before quotes
    $val = str_replace(['\"', "\\'"], ['"', "'"], $val);
    
    if ($r['setting_key'] === 'high_commissioner_quote') {
        $val = '"The High Commission remains committed to strengthening the bonds between Nigeria and Kenya, while providing efficient consular services and promoting opportunities for our citizens and businesses."';
    }
    
    $updateStmt->execute([
        ':val' => $val,
        ':id' => $r['id']
    ]);
    
    echo "Updated " . $r['setting_key'] . " => " . var_export($val, true) . "\n";
}

SystemSetting::invalidateCache();
echo "Database system_settings cleaned successfully!\n";
