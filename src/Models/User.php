<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class User {
    public static function findById(int $id): ?array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT id, full_name, email, phone, role, status, nin_number, passport_number, created_at FROM users WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public static function findByEmail(string $email): ?array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public static function create(array $data): int {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO users (full_name, email, phone, password_hash, role, status, nin_number, passport_number) VALUES (:full_name, :email, :phone, :password_hash, :role, 'active', :nin_number, :passport_number)");
        $stmt->execute([
            ':full_name' => $data['full_name'],
            ':email' => $data['email'],
            ':phone' => $data['phone'] ?? null,
            ':password_hash' => password_hash($data['password'], PASSWORD_BCRYPT),
            ':role' => $data['role'] ?? 'citizen',
            ':nin_number' => $data['nin_number'] ?? null,
            ':passport_number' => $data['passport_number'] ?? null
        ]);
        return (int)$db->lastInsertId();
    }
}
