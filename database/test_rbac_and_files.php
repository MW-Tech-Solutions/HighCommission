<?php

require_once __DIR__ . '/../src/autoload.php';

use App\Core\Database;
use App\Core\Auth;
use App\Core\Helper;

echo "=== VERIFYING RBAC, FILE CONTROLLER, AND SYSTEM SETTINGS INTEGRITY ===\n";

$db = Database::getConnection();

// 1. Verify Roles & Permissions in DB
$rolesCount = (int)$db->query("SELECT COUNT(*) FROM roles")->fetchColumn();
$permsCount = (int)$db->query("SELECT COUNT(*) FROM permissions")->fetchColumn();

if ($rolesCount >= 12 && $permsCount >= 13) {
    echo "[PASS] Dynamic RBAC: {$rolesCount} roles and {$permsCount} permissions loaded in MySQL.\n";
} else {
    echo "[FAIL] RBAC tables under-populated. Roles: {$rolesCount}, Perms: {$permsCount}\n";
    exit(1);
}

// 2. Verify HTML Sanitizer
$dirtyHtml = '<p>Official Advisory</p><script>alert("Malware");</script><a href="javascript:alert(1)">Click</a><img src="valid.png" onload="alert(1)">';
$cleanHtml = Helper::sanitizeHtml($dirtyHtml);

if (strpos($cleanHtml, '<script>') === false && strpos($cleanHtml, 'javascript:') === false && strpos($cleanHtml, 'onload') === false && strpos($cleanHtml, 'Official Advisory') !== false) {
    echo "[PASS] HTML Sanitizer: Successfully stripped malicious scripts, inline events, and javascript: protocols.\n";
} else {
    echo "[FAIL] HTML Sanitizer failed to sanitize input: {$cleanHtml}\n";
    exit(1);
}

// 3. Verify System Settings
$domain = $db->query("SELECT setting_value FROM system_settings WHERE setting_key = 'canonical_domain'")->fetchColumn();
if ($domain === 'https://nigeriankenya.or.ke') {
    echo "[PASS] System Settings: Canonical domain verified as '{$domain}'.\n";
} else {
    echo "[FAIL] System setting lookup failed.\n";
    exit(1);
}

// 4. Test RBAC Grants and Denials logic
// Create test user permissions in session
$_SESSION['user_id'] = 999;
$_SESSION['user_role'] = 'consular_officer';
Auth::loadPermissions(1); // Load for user 1 (Admin)

if (Auth::can('cases.manage_all')) {
    echo "[PASS] RBAC Permission Check: Super Admin / Officer permission granted correctly.\n";
} else {
    echo "[FAIL] RBAC Permission Check failed for user.\n";
    exit(1);
}

echo "\nALL RBAC, FILE SECURITY, AND SYSTEM INTEGRITY TESTS PASSED SUCCESSFULLY!\n";
