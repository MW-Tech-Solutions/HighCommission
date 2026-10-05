<?php

require_once __DIR__ . '/../src/autoload.php';

use App\Core\Database;

$db = Database::getConnection();

// Update existing hero slides with authentic downloaded HD images from live site
$db->exec("UPDATE hero_slides SET image_desktop = 'assets/images/hero/IMG-20260816-WA0006.jpg' WHERE id = 1");
$db->exec("UPDATE hero_slides SET image_desktop = 'assets/images/hero/IMG-20260901-WA0012.jpg' WHERE id = 2");
$db->exec("UPDATE hero_slides SET image_desktop = 'assets/images/hero/IMG-20260816-WA00031.jpg' WHERE id = 3");

// Add a 4th slide featuring the High Commissioner & Bilateral Relations
$checkStmt = $db->prepare("SELECT COUNT(*) FROM hero_slides WHERE heading = 'Diplomatic Excellence & Bilateral Relations'");
$checkStmt->execute();
if ($checkStmt->fetchColumn() == 0) {
    $stmt = $db->prepare("INSERT INTO hero_slides (heading, subheading, image_desktop, image_alt, cta_primary_label, cta_primary_url, cta_secondary_label, cta_secondary_url, caption_theme, display_order, is_enabled) VALUES (:h, :s, :i, :a, :cp, :cpu, :cs, :csu, :t, :d, 1)");
    $stmt->execute([
        ':h' => 'Diplomatic Excellence & Bilateral Relations',
        ':s' => 'Fostering trade, cultural exchanges, and sovereign cooperation between Nigeria and Kenya.',
        ':i' => 'assets/images/hero/IMG-20260901-WA0014.jpg',
        ':a' => 'High Commission Bilateral Meeting with Kenyan Officials',
        ':cp' => 'Discover Bilateral Relations',
        ':cpu' => 'mission',
        ':cs' => 'Trade Opportunities',
        ':csu' => 'trade',
        ':t' => 'light_on_dark',
        ':d' => 4
    ]);
}

// Also update main logo if coat of arms downloaded
$logoPath = 'assets/images/hero/coat-of-arms-of-nigeria-01-01-scaled-161x48.png';
if (file_exists(__DIR__ . '/../public/' . $logoPath)) {
    $db->exec("INSERT INTO system_settings (setting_key, setting_value, group_name) VALUES ('logo_main', '{$logoPath}', 'branding') ON DUPLICATE KEY UPDATE setting_value = '{$logoPath}'");
}

echo "[PASS] Hero slides updated with authentic HD live images from nigeriankenya.or.ke!\n";
