<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class RequestModel {
    public static function create(array $data): string {
        $db = Database::getConnection();
        $ref = 'REQ-' . date('Y') . '-' . rand(1000, 9999);
        $stmt = $db->prepare("INSERT INTO requests (reference_number, user_id, applicant_name, applicant_email, applicant_phone, service_type, subject, details, attached_document, status, priority) VALUES (:ref, :user_id, :name, :email, :phone, :service_type, :subject, :details, :attached_document, :status, :priority)");
        $stmt->execute([
            ':ref' => $ref,
            ':user_id' => $data['user_id'] ?? null,
            ':name' => $data['applicant_name'],
            ':email' => $data['applicant_email'],
            ':phone' => $data['applicant_phone'],
            ':service_type' => $data['service_type'],
            ':subject' => $data['subject'],
            ':details' => $data['details'],
            ':attached_document' => $data['attached_document'] ?? null,
            ':status' => 'received',
            ':priority' => $data['priority'] ?? 'normal'
        ]);
        return $ref;
    }

    public static function findByReference(string $ref): ?array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT r.*, u.full_name as officer_name FROM requests r LEFT JOIN users u ON r.assigned_officer_id = u.id WHERE r.reference_number = :ref LIMIT 1");
        $stmt->execute([':ref' => $ref]);
        $req = $stmt->fetch();
        return $req ?: null;
    }

    public static function findByUserId(int $userId): array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM requests WHERE user_id = :userId ORDER BY created_at DESC");
        $stmt->execute([':userId' => $userId]);
        return $stmt->fetchAll();
    }

    public static function getAll(): array {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT r.*, u.full_name as officer_name FROM requests r LEFT JOIN users u ON r.assigned_officer_id = u.id ORDER BY r.created_at DESC");
        return $stmt->fetchAll();
    }

    public static function getMessages(int $requestId): array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT m.*, u.full_name as sender_name FROM request_messages m LEFT JOIN users u ON m.sender_id = u.id WHERE m.request_id = :reqId ORDER BY m.created_at ASC");
        $stmt->execute([':reqId' => $requestId]);
        return $stmt->fetchAll();
    }

    public static function addMessage(int $requestId, int $senderId, string $senderType, string $message): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO request_messages (request_id, sender_id, sender_type, message) VALUES (:reqId, :senderId, :senderType, :message)");
        return $stmt->execute([
            ':reqId' => $requestId,
            ':senderId' => $senderId,
            ':senderType' => $senderType,
            ':message' => $message
        ]);
    }

    public static function updateStatus(int $id, string $status, ?int $officerId = null, ?string $internalNotes = null): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE requests SET status = :status, assigned_officer_id = COALESCE(:officerId, assigned_officer_id), internal_notes = COALESCE(:notes, internal_notes) WHERE id = :id");
        return $stmt->execute([
            ':id' => $id,
            ':status' => $status,
            ':officerId' => $officerId,
            ':notes' => $internalNotes
        ]);
    }
}
