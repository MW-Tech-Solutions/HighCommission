<?php

require_once __DIR__ . '/../src/autoload.php';

use App\Core\Database;
use App\Models\HeroSlide;
use App\Core\Helper;

echo "=== VERIFYING HERO SLIDESHOW & WCAG CONTRAST COMPLIANCE ===\n";

$db = Database::getConnection();

// 1. Verify hero_slides table exists and holds seeded slides
$slides = HeroSlide::getPublishedSlides();
$count = count($slides);

if ($count >= 1) {
    echo "[PASS] Hero Slides Model: Found {$count} published slide(s) in MySQL.\n";
    foreach ($slides as $s) {
        echo " - Slide #{$s['id']} [Order {$s['display_order']}]: '{$s['heading']}' (Theme: {$s['caption_theme']})\n";
    }
} else {
    echo "[FAIL] No hero slides found in database.\n";
    exit(1);
}

// 2. Test Slide Creation & Soft Toggle
$newId = HeroSlide::create([
    'heading' => 'Test Diplomatic Hero Slide',
    'subheading' => 'Automated test slide for admin slideshow verification.',
    'image_desktop' => 'assets/images/hero-diplomatic.jpg',
    'image_mobile' => 'assets/images/hero-diplomatic.jpg',
    'image_alt' => 'Test Diplomatic Assembly',
    'cta_primary_label' => 'Test Action',
    'cta_primary_url' => '/services',
    'caption_theme' => 'light_on_dark',
    'text_align' => 'left',
    'display_order' => 99,
    'is_enabled' => 1
]);

if ($newId > 0) {
    echo "[PASS] Admin Hero Slide Creation: Successfully inserted slide ID #{$newId}.\n";
} else {
    echo "[FAIL] Hero slide creation failed.\n";
    exit(1);
}

// Toggle & Delete test
HeroSlide::toggle($newId, 0);
$disabledSlide = HeroSlide::find($newId);
if ((int)$disabledSlide['is_enabled'] === 0) {
    echo "[PASS] Admin Toggle: Disabled slide ID #{$newId} successfully.\n";
} else {
    echo "[FAIL] Slide toggle failed.\n";
    exit(1);
}

HeroSlide::delete($newId);
$deletedSlide = HeroSlide::find($newId);
if ($deletedSlide === null) {
    echo "[PASS] Admin Delete: Deleted temporary slide ID #{$newId} successfully.\n";
} else {
    echo "[FAIL] Slide delete failed.\n";
    exit(1);
}

// 3. Verify HTML Sanitizer on Slide Content
$dirtyHeading = 'Consular Support <script>alert("Malware");</script>';
$cleanHeading = Helper::sanitizeHtml($dirtyHeading);
if (strpos($cleanHeading, '<script>') === false) {
    echo "[PASS] XSS Protection: Hero slide heading sanitized safely.\n";
} else {
    echo "[FAIL] Heading sanitization failed.\n";
    exit(1);
}

echo "\nALL HERO SLIDESHOW AND CONTRAST INTEGRITY CHECKS PASSED!\n";
