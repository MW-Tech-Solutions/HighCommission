<?php
require_once __DIR__ . '/../src/autoload.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use App\Core\Auth;
use App\Core\Request;
use App\Controllers\AdminController;

echo "=== VERIFYING ALL ADMIN CONTROLLER METHODS & ROUTES ===\n";

// Authenticate as Super Admin
Auth::attempt('admin@nigeriankenya.or.ke', 'Password123!');

$controller = new AdminController();
$methods = [
    'dashboard',
    'requests',
    'appointments',
    'citizens',
    'notices',
    'verification',
    'trade',
    'reports',
    'users',
    'settings',
    'audit',
    'hero'
];

foreach ($methods as $m) {
    try {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/admin/' . $m;
        $req = new Request();
        
        // Use output buffering so HTML output is captured
        ob_start();
        $controller->$m($req);
        $output = ob_get_clean();
        
        echo "[PASS] Method AdminController::{$m}() executed successfully (" . strlen($output) . " bytes HTML rendered).\n";
    } catch (\Throwable $e) {
        if (ob_get_level() > 0) ob_end_clean();
        echo "[FAIL] Method AdminController::{$m}() threw Error: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . "\n";
        exit(1);
    }
}

echo "\nALL ADMIN CONTROLLER METHODS PASSED 100% WITHOUT ERRORS!\n";
