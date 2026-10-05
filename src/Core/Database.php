<?php

namespace App\Core;

use PDO;
use Exception;

class Database {
    private static ?PDO $instance = null;

    public static function getConnection(): PDO {
        if (self::$instance === null) {
            $config = require __DIR__ . '/../../config/database.php';
            $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset={$config['charset']}";
            try {
                self::$instance = new PDO($dsn, $config['username'], $config['password'], $config['options']);
            } catch (Exception $e) {
                die("Database connection error: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
