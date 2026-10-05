<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class DiasporaCitizen {
    public static function create(array $data): string {
        $db = Database::getConnection();
        $regNum = 'NHC-REG-' . date('Y') . '-' . sprintf('%03d', rand(1, 999));
        
        $stmt = $db->prepare("INSERT INTO diaspora_citizens (user_id, registration_number, full_name, gender, dob, passport_number, nin, kenya_address, kenya_county, occupation, employer_institution, emergency_contact_kenya, emergency_phone_kenya, emergency_contact_nigeria, emergency_phone_nigeria, state_of_origin, lga, status) VALUES (:user_id, :reg_num, :name, :gender, :dob, :passport, :nin, :address, :county, :occupation, :employer, :em_kenya_name, :em_kenya_phone, :em_nig_name, :em_nig_phone, :state, :lga, 'submitted')");
        $stmt->execute([
            ':user_id' => $data['user_id'] ?? null,
            ':reg_num' => $regNum,
            ':name' => $data['full_name'],
            ':gender' => $data['gender'],
            ':dob' => $data['dob'] ?? null,
            ':passport' => $data['passport_number'],
            ':nin' => $data['nin'] ?? null,
            ':address' => $data['kenya_address'],
            ':county' => $data['kenya_county'],
            ':occupation' => $data['occupation'],
            ':employer' => $data['employer_institution'] ?? null,
            ':em_kenya_name' => $data['emergency_contact_kenya'],
            ':em_kenya_phone' => $data['emergency_phone_kenya'],
            ':em_nig_name' => $data['emergency_contact_nigeria'],
            ':em_nig_phone' => $data['emergency_phone_nigeria'],
            ':state' => $data['state_of_origin'],
            ':lga' => $data['lga'] ?? null
        ]);
        return $regNum;
    }

    public static function findByUserId(int $userId): ?array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM diaspora_citizens WHERE user_id = :userId LIMIT 1");
        $stmt->execute([':userId' => $userId]);
        $record = $stmt->fetch();
        return $record ?: null;
    }

    public static function getAll(): array {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM diaspora_citizens ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public static function updateStatus(int $id, string $status, ?int $officerId = null): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE diaspora_citizens SET status = :status, verified_at = CURRENT_TIMESTAMP, verified_by = :officer WHERE id = :id");
        return $stmt->execute([':id' => $id, ':status' => $status, ':officer' => $officerId]);
    }
}
