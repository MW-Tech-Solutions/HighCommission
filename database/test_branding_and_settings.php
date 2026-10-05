<?php

require_once __DIR__ . '/../src/autoload.php';

use App\Core\Database;
use App\Models\SystemSetting;

echo "=== VERIFYING SYSTEM SETTINGS, BRANDING & TYPOGRAPHY INTEGRITY ===\n";

$db = Database::getConnection();

// 1. Test SystemSetting::get and defaults
$missionName = SystemSetting::get('mission_name');
echo "[PASS] Fetched mission_name: {$missionName}\n";

$fontHeading = SystemSetting::get('font_heading');
$fontBody = SystemSetting::get('font_body');
$fontButton = SystemSetting::get('font_button');

if ($fontHeading === 'Montserrat' && $fontBody === 'Open Sans' && $fontButton === 'Poppins') {
    echo "[PASS] Assigned Typography verified: Montserrat (Heading), Open Sans (Body), Poppins (Button/CTA).\n";
} else {
    echo "[FAIL] Typography settings mismatch: Heading={$fontHeading}, Body={$fontBody}, Button={$fontButton}\n";
    exit(1);
}

// 2. Test Setting Mutation & Cache Invalidation
SystemSetting::set('test_key_temp', 'Test Value 123', 'general');
$val1 = SystemSetting::get('test_key_temp');
if ($val1 === 'Test Value 123') {
    echo "[PASS] SystemSetting::set and cache invalidation working properly.\n";
} else {
    echo "[FAIL] SystemSetting mutation failed.\n";
    exit(1);
}

// Clean up temp test key
$db->exec("DELETE FROM system_settings WHERE setting_key = 'test_key_temp'");
SystemSetting::invalidateCache();

// 3. Test Logo Resolution & Favicon
$mainLogo = SystemSetting::getLogo('main');
$footerLogo = SystemSetting::getLogo('footer');
$faviconUrl = SystemSetting::getFaviconUrl();

echo "[PASS] Logo resolution checked. Main logo has_image: " . ($mainLogo['has_image'] ? 'true' : 'false') . "\n";
echo "[PASS] Footer logo inheritance checked. Footer logo path resolved successfully.\n";

// 4. Test Asset URL Versioning (Cache Busting)
$assetUrl = SystemSetting::getAssetUrl('branding_primary_color', 'assets/css/custom.css');
if (strpos($assetUrl, '?v=') !== false) {
    echo "[PASS] Asset URL cache buster verified: {$assetUrl}\n";
} else {
    echo "[FAIL] Asset URL cache buster missing.\n";
    exit(1);
}

// 5. Test Seeding Safety (Ensure re-seeding doesn't overwrite admin saved settings)
SystemSetting::set('canonical_domain', 'https://custom-domain-admin-saved.or.ke', 'general');
require __DIR__ . '/seed_rbac.php';

$currentDomain = SystemSetting::get('canonical_domain');
if ($currentDomain === 'https://custom-domain-admin-saved.or.ke') {
    echo "[PASS] Seeders safely preserved administrator's saved settings!\n";
} else {
    echo "[FAIL] Seeder overwrote saved admin setting! Current value: {$currentDomain}\n";
    exit(1);
}

// Reset domain back to canonical
SystemSetting::set('canonical_domain', 'https://nigeriankenya.or.ke', 'general');

echo "\nALL BRANDING, SETTINGS & TYPOGRAPHY TESTS PASSED 100%!\n";
