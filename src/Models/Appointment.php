<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Appointment {
    public static function create(array $data): string {
        $db = Database::getConnection();
        
        // Prevent double booking on exact same date and time slot for same category
        $checkStmt = $db->prepare("SELECT COUNT(*) FROM appointments WHERE appointment_date = :date AND time_slot = :slot AND status = 'confirmed'");
        $checkStmt->execute([
            ':date' => $data['appointment_date'],
            ':slot' => $data['time_slot']
        ]);
        if ($checkStmt->fetchColumn() >= 5) { // max 5 applicants per slot
            throw new \Exception("The selected time slot ({$data['time_slot']}) on {$data['appointment_date']} is fully booked. Please select another slot.");
        }

        $voucher = 'APT-' . date('Y') . '-' . rand(1000, 9999);
        $stmt = $db->prepare("INSERT INTO appointments (voucher_number, user_id, applicant_name, applicant_email, applicant_phone, service_category, appointment_date, time_slot, status, notes) VALUES (:voucher, :user_id, :name, :email, :phone, :category, :date, :slot, 'confirmed', :notes)");
        $stmt->execute([
            ':voucher' => $voucher,
            ':user_id' => $data['user_id'] ?? null,
            ':name' => $data['applicant_name'],
            ':email' => $data['applicant_email'],
            ':phone' => $data['applicant_phone'],
            ':category' => $data['service_category'],
            ':date' => $data['appointment_date'],
            ':slot' => $data['time_slot'],
            ':notes' => $data['notes'] ?? null
        ]);
        return $voucher;
    }

    public static function findByVoucher(string $voucher): ?array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM appointments WHERE voucher_number = :voucher LIMIT 1");
        $stmt->execute([':voucher' => $voucher]);
        $apt = $stmt->fetch();
        return $apt ?: null;
    }

    public static function findByUserId(int $userId): array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM appointments WHERE user_id = :userId ORDER BY appointment_date DESC");
        $stmt->execute([':userId' => $userId]);
        return $stmt->fetchAll();
    }

    public static function getAll(): array {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM appointments ORDER BY appointment_date DESC, time_slot ASC");
        return $stmt->fetchAll();
    }

    public static function updateStatus(int $id, string $status): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE appointments SET status = :status WHERE id = :id");
        return $stmt->execute([':id' => $id, ':status' => $status]);
    }
}
