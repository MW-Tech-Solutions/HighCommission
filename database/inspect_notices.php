<?php
require_once __DIR__ . '/../src/autoload.php';
use App\Core\Database;

$db = Database::getConnection();
$rows = $db->query("SELECT id, title, category, featured_image, published_at FROM notices")->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $r) {
    echo "#{$r['id']} | {$r['title']} | {$r['category']} | IMG: " . var_export($r['featured_image'], true) . " | {$r['published_at']}\n";
}
