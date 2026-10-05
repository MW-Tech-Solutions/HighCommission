<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Verification {
    public static function findByCode(string $code): ?array {
        $db = Database::getConnection();
        $code = trim($code);
        $stmt = $db->prepare("SELECT * FROM verifications WHERE UPPER(verification_code) = UPPER(:code) OR UPPER(passport_or_ref) = UPPER(:code) OR UPPER(qr_hash) = UPPER(:code) LIMIT 1");
        $stmt->execute([':code' => $code]);
        $record = $stmt->fetch();
        return $record ?: null;
    }

    public static function getAll(): array {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM verifications ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public static function create(array $data): string {
        $db = Database::getConnection();
        $code = $data['verification_code'] ?? ('NHCK-' . date('Y') . '-' . rand(1000, 9999));
        $hash = 'HASH' . rand(1000, 9999) . 'VERIFIED';

        $stmt = $db->prepare("INSERT INTO verifications (verification_code, document_type, holder_name, passport_or_ref, issue_date, expiry_date, status, issued_by_officer, remarks, qr_hash) VALUES (:code, :doc_type, :holder, :ref, :issue, :expiry, :status, :officer, :remarks, :hash)");
        $stmt->execute([
            ':code' => $code,
            ':doc_type' => $data['document_type'],
            ':holder' => $data['holder_name'],
            ':ref' => $data['passport_or_ref'],
            ':issue' => $data['issue_date'] ?? date('Y-m-d'),
            ':expiry' => $data['expiry_date'] ?? null,
            ':status' => $data['status'] ?? 'valid',
            ':officer' => $data['issued_by_officer'] ?? 'Nigeria High Commission Nairobi',
            ':remarks' => $data['remarks'] ?? null,
            ':hash' => $hash
        ]);
        return $code;
    }
}
