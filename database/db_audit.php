<?php
require_once __DIR__ . '/../src/autoload.php';
$db = \App\Core\Database::getConnection();

// Tables
echo "=== TABLES ===\n";
$tables = $db->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
foreach ($tables as $t) {
    $count = $db->query("SELECT COUNT(*) FROM `{$t}`")->fetchColumn();
    echo "{$t}: {$count} rows\n";
}

// Check password_recovery_tokens
echo "\n=== password_recovery_tokens state ===\n";
try {
    $r = $db->query("SELECT COUNT(*) FROM password_recovery_tokens")->fetchColumn();
    echo "password_recovery_tokens exists, rows: $r\n";
} catch(Exception $e) {
    echo "MISSING: " . $e->getMessage() . "\n";
}

// Check newsletter_subscriptions
echo "\n=== newsletter_subscriptions state ===\n";
try {
    $r = $db->query("SELECT COUNT(*) FROM newsletter_subscriptions")->fetchColumn();
    echo "newsletter_subscriptions exists, rows: $r\n";
} catch(Exception $e) {
    echo "MISSING: " . $e->getMessage() . "\n";
}

// Check users table structure
echo "\n=== users columns ===\n";
$cols = $db->query("DESCRIBE users")->fetchAll(PDO::FETCH_ASSOC);
foreach ($cols as $c) {
    echo $c['Field'] . " | " . $c['Type'] . " | Null:" . $c['Null'] . " | Key:" . $c['Key'] . "\n";
}

// Check RBAC tables data
echo "\n=== RBAC tables ===\n";
$rbac = ['roles', 'permissions', 'role_permissions', 'user_roles', 'user_permissions'];
foreach ($rbac as $t) {
    try {
        $cnt = $db->query("SELECT COUNT(*) FROM `{$t}`")->fetchColumn();
        echo "{$t}: {$cnt} rows\n";
    } catch(Exception $e) {
        echo "{$t}: MISSING - " . $e->getMessage() . "\n";
    }
}

// Check indexes on requests
echo "\n=== requests indexes ===\n";
$idx = $db->query("SHOW INDEX FROM requests")->fetchAll(PDO::FETCH_ASSOC);
foreach ($idx as $i) {
    echo $i['Key_name'] . " -> " . $i['Column_name'] . "\n";
}

echo "\nDone.\n";
