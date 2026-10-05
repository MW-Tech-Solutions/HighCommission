<?php
require_once __DIR__ . '/../src/autoload.php';
use App\Core\Database;

$db = Database::getConnection();

$db->exec("
    CREATE TABLE IF NOT EXISTS `newsletter_subscriptions` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `email` VARCHAR(255) NOT NULL UNIQUE,
        `full_name` VARCHAR(255) NULL,
        `status` ENUM('subscribed', 'unsubscribed') DEFAULT 'subscribed',
        `source` VARCHAR(100) DEFAULT 'website_footer',
        `token` VARCHAR(64) NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

echo "newsletter_subscriptions table verified/created successfully!\n";
