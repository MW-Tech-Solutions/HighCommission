<?php
require_once __DIR__ . '/../src/autoload.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use App\Core\Auth;
use App\Core\Helper;

echo "=== VERIFYING LOGIN AUTHENTICATION & DEMO ACCOUNTS ===\n";

// Test Accounts to verify
$accounts = [
    ['email' => 'admin@nigeriankenya.or.ke', 'pass' => 'Password123!', 'role' => 'admin'],
    ['email' => 'officer@nigeriankenya.or.ke', 'pass' => 'Password123!', 'role' => 'officer'],
    ['email' => 'editor@nigeriankenya.or.ke', 'pass' => 'Password123!', 'role' => 'editor'],
    ['email' => 'tunde.demo@example.com', 'pass' => 'Password123!', 'role' => 'citizen'],
    ['email' => 'amina.demo@example.com', 'pass' => 'Password123!', 'role' => 'citizen'],
];

foreach ($accounts as $acc) {
    Auth::logout();
    $result = Auth::attempt($acc['email'], $acc['pass']);
    if ($result) {
        $user = Auth::user();
        echo "[PASS] Successfully authenticated {$acc['role']} ({$acc['email']}). Full Name: {$user['full_name']}\n";
    } else {
        echo "[FAIL] Authentication failed for {$acc['email']}\n";
        exit(1);
    }
}

// Verify CSRF token persistence
$token = Helper::csrfToken();
if (Helper::validateCsrf($token)) {
    echo "[PASS] CSRF session persistence verified.\n";
} else {
    echo "[FAIL] CSRF validation failed.\n";
    exit(1);
}

echo "\nALL LOGIN & AUTHENTICATION TESTS PASSED 100%!\n";
