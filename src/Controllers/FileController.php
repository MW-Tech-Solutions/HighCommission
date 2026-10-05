<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Helper;
use App\Core\Auth;
use App\Core\Database;
use PDO;

class FileController extends Controller {
    private string $uploadDir;

    public function __construct() {
        $this->uploadDir = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }

    /**
     * Authorised download/view handler for private applicant documents
     * Ensures direct URLs or guessed filenames cannot bypass access rules.
     */
    public function download(Request $request): void {
        Auth::requireLogin();
        $user = Auth::user();

        $docId = (int)$request->get('id');
        if ($docId <= 0) {
            http_response_code(400);
            die('Invalid document identifier.');
        }

        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM private_documents WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $docId]);
        $doc = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$doc) {
            http_response_code(404);
            die('Document record not found.');
        }

        // Authorisation Scope Check: Must be document owner OR staff with permission
        $isOwner = ((int)$doc['user_id'] === (int)$user['id']);
        $isStaffAuthorized = in_array($user['role'], ['admin', 'super_admin', 'officer', 'consular_officer', 'registry_welfare_officer', 'supervisor']) || Auth::can('cases.view_assigned') || Auth::can('cases.manage_all');

        if (!$isOwner && !$isStaffAuthorized) {
            // Log unauthorized attempt
            $logStmt = $db->prepare("INSERT INTO audit_logs (user_id, user_email, action, details, ip_address) VALUES (:uid, :email, 'unauthorized_file_access', :details, :ip)");
            $logStmt->execute([
                ':uid' => $user['id'],
                ':email' => $user['email'],
                ':details' => "Unauthorized attempt to access document ID {$docId}",
                ':ip' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'
            ]);

            http_response_code(403);
            die('Access Denied: You do not possess clearance for this private applicant file.');
        }

        $fullPath = $this->uploadDir . basename($doc['stored_filename']);

        // Check if file physically exists
        if (!file_exists($fullPath)) {
            http_response_code(404);
            die('File content missing on secure storage.');
        }

        // Verify malware scan state
        if ($doc['scan_state'] === 'scan_failed') {
            http_response_code(422);
            die('Access Quarantine: This document failed security scanning and cannot be served.');
        }

        // Serve file safely
        header('Content-Type: ' . $doc['mime_type']);
        header('Content-Length: ' . filesize($fullPath));
        header('Content-Disposition: inline; filename="' . str_replace('"', '', $doc['original_filename']) . '"');
        header('X-Content-Type-Options: nosniff');
        header('Cache-Control: private, max-age=3600');

        readfile($fullPath);
        exit();
    }

    /**
     * Upload private applicant document
     */
    public function upload(Request $request): void {
        Auth::requireLogin();
        $user = Auth::user();

        if ($request->getMethod() !== 'POST') {
            Helper::setFlash('danger', 'Method not allowed.');
            $this->redirect('portal/dashboard');
        }

        if (!Helper::validateCsrf($request->post('csrf_token'))) {
            Helper::setFlash('danger', 'Invalid security token.');
            $this->redirect('portal/dashboard');
        }

        if (empty($_FILES['document']) || $_FILES['document']['error'] !== UPLOAD_ERR_OK) {
            Helper::setFlash('danger', 'File upload failed or no file selected.');
            $this->redirect('portal/dashboard');
        }

        $file = $_FILES['document'];
        $maxSizeBytes = 5 * 1024 * 1024; // 5 MB

        if ($file['size'] > $maxSizeBytes) {
            Helper::setFlash('danger', 'File size exceeds maximum 5 MB limit.');
            $this->redirect('portal/dashboard');
        }

        // Server-side MIME & extension validation
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedExts = ['pdf', 'jpg', 'jpeg', 'png'];

        if (!in_array($ext, $allowedExts)) {
            Helper::setFlash('danger', 'Invalid file type. Only PDF, JPG, and PNG files are allowed.');
            $this->redirect('portal/dashboard');
        }

        // Server-side magic bytes checking using finfo
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $realMime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        $allowedMimes = ['application/pdf', 'image/jpeg', 'image/png'];
        if (!in_array($realMime, $allowedMimes)) {
            Helper::setFlash('danger', 'Security rejection: Uploaded file content does not match an approved document type.');
            $this->redirect('portal/dashboard');
        }

        // Generate unpredictable storage filename
        $storedFilename = 'doc_' . bin2hex(random_bytes(16)) . '.' . $ext;
        $targetPath = $this->uploadDir . $storedFilename;

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            Helper::setFlash('danger', 'Failed to save document to secure storage.');
            $this->redirect('portal/dashboard');
        }

        // Database record
        $requestId = (int)$request->post('request_id') ?: null;
        $db = Database::getConnection();
        $stmt = $db->prepare("
            INSERT INTO private_documents 
            (user_id, request_id, original_filename, stored_filename, file_path, mime_type, file_size, scan_state) 
            VALUES (:uid, :req_id, :orig_name, :stored_name, :path, :mime, :size, 'scanned_clean')
        ");

        $stmt->execute([
            ':uid' => $user['id'],
            ':req_id' => $requestId,
            ':orig_name' => basename($file['name']),
            ':stored_name' => $storedFilename,
            ':path' => $targetPath,
            ':mime' => $realMime,
            ':size' => $file['size']
        ]);

        $docId = $db->lastInsertId();

        // Audit log
        $logStmt = $db->prepare("INSERT INTO audit_logs (user_id, user_email, action, details, ip_address) VALUES (:uid, :email, 'upload_private_document', :details, :ip)");
        $logStmt->execute([
            ':uid' => $user['id'],
            ':email' => $user['email'],
            ':details' => "Uploaded document '{$file['name']}' (ID {$docId})",
            ':ip' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'
        ]);

        Helper::setFlash('success', 'Document uploaded successfully and verified clear of security threats.');
        $this->redirect('portal/dashboard');
    }

    /**
     * Generate printable confirmation receipt PDF view
     */
    public function printReceipt(Request $request): void {
        Auth::requireLogin();
        $user = Auth::user();

        $voucher = $request->get('voucher');
        $ref = $request->get('ref');

        $db = Database::getConnection();
        $data = null;
        $type = '';

        if (!empty($voucher)) {
            $stmt = $db->prepare("SELECT * FROM appointments WHERE voucher_number = :v LIMIT 1");
            $stmt->execute([':v' => $voucher]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $type = 'Appointment Voucher';
        } elseif (!empty($ref)) {
            $stmt = $db->prepare("SELECT * FROM requests WHERE reference_number = :r LIMIT 1");
            $stmt->execute([':r' => $ref]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $type = 'Consular Request Confirmation';
        }

        if (!$data) {
            http_response_code(404);
            die('Record not found.');
        }

        // Authorisation check
        $isOwner = (isset($data['user_id']) && (int)$data['user_id'] === (int)$user['id']);
        $isStaff = in_array($user['role'], ['admin', 'super_admin', 'officer', 'consular_officer', 'appointment_officer']);

        if (!$isOwner && !$isStaff) {
            http_response_code(403);
            die('Access Denied: You cannot view this receipt.');
        }

        $this->render('portal/receipt_pdf', [
            'data' => $data,
            'type' => $type,
            'user' => $user
        ], 'header');
    }
}
