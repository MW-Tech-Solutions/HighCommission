<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class TradeMatchmaking {
    public static function create(array $data): string {
        $db = Database::getConnection();
        $ref = 'TRD-' . date('Y') . '-' . rand(100, 999);
        $stmt = $db->prepare("INSERT INTO trade_matchmaking (reference_code, company_name, contact_person, email, phone, country_origin, sector, business_description, investment_size, status) VALUES (:ref, :company, :person, :email, :phone, :country, :sector, :desc, :size, 'pending')");
        $stmt->execute([
            ':ref' => $ref,
            ':company' => $data['company_name'],
            ':person' => $data['contact_person'],
            ':email' => $data['email'],
            ':phone' => $data['phone'],
            ':country' => $data['country_origin'],
            ':sector' => $data['sector'],
            ':desc' => $data['business_description'],
            ':size' => $data['investment_size'] ?? null
        ]);
        return $ref;
    }

    public static function getAll(): array {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM trade_matchmaking ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }
}
