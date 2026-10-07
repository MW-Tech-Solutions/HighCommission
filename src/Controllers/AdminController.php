<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Helper;
use App\Core\Auth;
use PDO;
use App\Models\RequestModel;
use App\Models\Appointment;
use App\Models\DiasporaCitizen;
use App\Models\Notice;
use App\Models\Verification;
use App\Models\TradeMatchmaking;
use App\Models\AuditLog;
use App\Models\SystemSetting;
use App\Services\MailService;
use App\Core\Database;

class AdminController extends Controller {
    public function login(Request $request): void {
        if (Auth::check()) {
            if (Auth::isStaffRole()) {
                $this->redirect('admin/dashboard');
            } else {
                $this->redirect('portal/dashboard');
            }
        }

        if ($request->getMethod() === 'POST') {
            if (!Helper::validateCsrf($request->post('csrf_token'))) {
                Helper::setFlash('danger', 'Invalid security token.');
                $this->redirect('admin/login');
            }

            $email = trim((string)$request->post('email'));
            $password = (string)$request->post('password');

            if (Auth::attempt($email, $password)) {
                $user = Auth::user();
                if (Auth::isStaffRole($user['role'])) {
                    Helper::setFlash('success', "Authenticated as High Commission Staff: {$user['full_name']}");
                    $this->redirect('admin/dashboard');
                } else {
                    Helper::setFlash('info', "Authenticated as Citizen: {$user['full_name']}");
                    $this->redirect('portal/dashboard');
                }
            } else {
                Helper::setFlash('danger', 'Invalid email address or password.');
                $this->redirect('admin/login');
            }
        }

        $this->render('admin/login', [], 'header');
    }


    public function dashboard(Request $request): void {
        Auth::requireStaffRole();

        $requests = RequestModel::getAll();
        $appointments = Appointment::getAll();
        $citizens = DiasporaCitizen::getAll();
        $notices = Notice::getAll();

        $pendingCount = count(array_filter($requests, fn($r) => in_array($r['status'], ['received', 'under_review', 'info_needed'])));
        $distressCount = count(array_filter($requests, fn($r) => $r['service_type'] === 'emergency_distress'));
        $appointmentCount = count($appointments);
        $citizenCount = count($citizens);

        $this->render('admin/dashboard', [
            'requests' => $requests,
            'appointments' => $appointments,
            'citizens' => $citizens,
            'notices' => $notices,
            'pendingCount' => $pendingCount,
            'distressCount' => $distressCount,
            'appointmentCount' => $appointmentCount,
            'citizenCount' => $citizenCount
        ], 'admin');
    }

    public function requests(Request $request): void {
        Auth::requireStaffRole();

        if ($request->getMethod() === 'POST') {
            if (!Helper::validateCsrf($request->post('csrf_token'))) {
                Helper::setFlash('danger', 'Invalid security token.');
                $this->redirect('admin/requests');
            }

            $id = (int)$request->post('request_id');
            $status = $request->post('status');
            $notes = $request->post('internal_notes');
            $user = Auth::user();

            RequestModel::updateStatus($id, $status, $user['id'], $notes);
            AuditLog::log($user['id'], $user['email'], 'update_request', "Updated request ID {$id} status to {$status}");
            
            Helper::setFlash('success', "Consular case status updated to " . strtoupper($status));
            $this->redirect('admin/requests');
        }

        $requests = RequestModel::getAll();
        $this->render('admin/requests', ['requests' => $requests], 'admin');
    }

    public function requestDetail(Request $request): void {
        Auth::requireStaffRole();
        $user = Auth::user();

        $ref = $request->get('ref');
        $id = (int)$request->get('id');

        $req = null;
        if (!empty($ref)) {
            $req = RequestModel::findByReference($ref);
        } elseif ($id > 0) {
            $all = RequestModel::getAll();
            foreach ($all as $r) {
                if ((int)$r['id'] === $id) {
                    $req = $r;
                    break;
                }
            }
        }

        if (!$req) {
            Helper::setFlash('warning', 'Consular case not found or access restricted.');
            $this->redirect('admin/requests');
        }

        if ($request->getMethod() === 'POST') {
            if (!Helper::validateCsrf($request->post('csrf_token'))) {
                Helper::setFlash('danger', 'Invalid security token.');
                $this->redirect('admin/requests/view?ref=' . $req['reference_number']);
            }

            $action = $request->post('action');
            if ($action === 'post_message') {
                $msg = trim((string)$request->post('message'));
                if (!empty($msg)) {
                    RequestModel::addMessage($req['id'], $user['id'], 'staff', $msg);
                    AuditLog::log($user['id'], $user['email'], 'reply_request', "Staff posted reply to request #{$req['reference_number']}");
                    Helper::setFlash('success', 'Official response posted to case thread.');
                }
            } elseif ($action === 'update_status') {
                $status = $request->post('status');
                $notes = $request->post('internal_notes');
                $officerId = (int)($request->post('assigned_officer_id') ?? $user['id']);

                RequestModel::updateStatus($req['id'], $status, $officerId, $notes);
                AuditLog::log($user['id'], $user['email'], 'update_request', "Updated case #{$req['reference_number']} status to {$status}");
                Helper::setFlash('success', 'Consular case processing details updated.');
            }

            $this->redirect('admin/requests/view?ref=' . $req['reference_number']);
        }

        $messages = RequestModel::getMessages($req['id']);

        $this->render('admin/request_detail', [
            'req' => $req,
            'messages' => $messages,
            'user' => $user
        ], 'admin');
    }

    public function appointments(Request $request): void {
        Auth::requireStaffRole();

        if ($request->getMethod() === 'POST') {
            if (!Helper::validateCsrf($request->post('csrf_token'))) {
                Helper::setFlash('danger', 'Invalid security token.');
                $this->redirect('admin/appointments');
            }

            $id = (int)$request->post('appointment_id');
            $status = $request->post('status');
            $user = Auth::user();

            Appointment::updateStatus($id, $status);
            AuditLog::log($user['id'], $user['email'], 'update_appointment', "Updated appointment ID {$id} status to {$status}");

            Helper::setFlash('success', "Appointment status updated to " . strtoupper($status));
            $this->redirect('admin/appointments');
        }

        $appointments = Appointment::getAll();
        $this->render('admin/appointments', ['appointments' => $appointments], 'admin');
    }

    public function citizens(Request $request): void {
        Auth::requireStaffRole();

        if ($request->getMethod() === 'POST') {
            if (!Helper::validateCsrf($request->post('csrf_token'))) {
                Helper::setFlash('danger', 'Invalid security token.');
                $this->redirect('admin/citizens');
            }

            $id = (int)$request->post('citizen_id');
            $status = $request->post('status');
            $user = Auth::user();

            DiasporaCitizen::updateStatus($id, $status, $user['id']);
            AuditLog::log($user['id'], $user['email'], 'verify_citizen', "Updated diaspora citizen ID {$id} registration status to {$status}");

            Helper::setFlash('success', "Diaspora registration status updated to " . strtoupper($status));
            $this->redirect('admin/citizens');
        }

        $citizens = DiasporaCitizen::getAll();
        $this->render('admin/citizens', ['citizens' => $citizens], 'admin');
    }

    public function notices(Request $request): void {
        Auth::requireStaffRole();

        if ($request->getMethod() === 'POST') {
            if (!Helper::validateCsrf($request->post('csrf_token'))) {
                Helper::setFlash('danger', 'Invalid security token.');
                $this->redirect('admin/notices');
            }

            $action = $request->post('action');
            $user = Auth::user();

            // Handle image upload if provided
            $featuredImage = null;
            $imageUrl = trim($request->post('featured_image_url') ?? '');
            if (!empty($imageUrl)) {
                $featuredImage = $imageUrl;
            }

            if (!empty($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['featured_image'];
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'])) {
                    $publicDir = __DIR__ . '/../../public/uploads/news';
                    $rootDir = __DIR__ . '/../../uploads/news';
                    if (!file_exists($publicDir)) @mkdir($publicDir, 0755, true);
                    if (!file_exists($rootDir)) @mkdir($rootDir, 0755, true);

                    $filename = 'news_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
                    $publicPath = $publicDir . '/' . $filename;
                    $rootPath = $rootDir . '/' . $filename;

                    if (move_uploaded_file($file['tmp_name'], $publicPath)) {
                        @copy($publicPath, $rootPath);
                        $featuredImage = 'uploads/news/' . $filename;
                    }
                }
            }

            if ($action === 'create') {
                $noticeId = Notice::create([
                    'title' => $request->post('title'),
                    'category' => $request->post('category'),
                    'content' => $request->post('content'),
                    'featured_image' => $featuredImage,
                    'is_urgent' => $request->post('is_urgent'),
                    'is_published' => $request->post('is_published'),
                    'author_id' => $user['id']
                ]);

                // Dispatch Email to Subscribed Users if Published
                if (!empty($request->post('is_published'))) {
                    try {
                        $db = Database::getConnection();
                        $subscribers = $db->query("SELECT email FROM newsletter_subscriptions WHERE status = 'subscribed'")->fetchAll(PDO::FETCH_COLUMN);
                        $title = $request->post('title');
                        $snippet = substr(strip_tags($request->post('content')), 0, 200) . '...';
                        $newsUrl = Helper::baseUrl('news/view?id=' . $noticeId);

                        foreach ($subscribers as $subEmail) {
                            MailService::sendNewsBroadcast($subEmail, $title, $snippet, $newsUrl);
                        }
                    } catch (\Throwable $e) {
                        // Log silently
                    }
                }

                AuditLog::log($user['id'], $user['email'], 'create_notice', "Created notice: " . $request->post('title'));
                Helper::setFlash('success', 'Notice published successfully and dispatched to newsletter subscribers.');
            } elseif ($action === 'update') {
                $id = (int)$request->post('notice_id');
                $updateData = [
                    'title' => $request->post('title'),
                    'category' => $request->post('category'),
                    'content' => $request->post('content'),
                    'is_urgent' => $request->post('is_urgent'),
                    'is_published' => $request->post('is_published')
                ];

                // Only update featured_image if a new one was uploaded/provided or deletion flag set
                if (!empty($request->post('delete_featured_image'))) {
                    $updateData['featured_image'] = null;
                } elseif ($featuredImage !== null) {
                    $updateData['featured_image'] = $featuredImage;
                }

                Notice::update($id, $updateData);
                AuditLog::log($user['id'], $user['email'], 'update_notice', "Updated notice ID {$id}");
                Helper::setFlash('success', 'Notice updated successfully.');
            } elseif ($action === 'delete') {
                $id = (int)$request->post('notice_id');
                Notice::delete($id);
                AuditLog::log($user['id'], $user['email'], 'delete_notice', "Deleted notice ID {$id}");
                Helper::setFlash('info', 'Notice deleted.');
            }
            $this->redirect('admin/notices');
        }

        $notices = Notice::getAll();
        $this->render('admin/notices', ['notices' => $notices], 'admin');
    }

    public function verification(Request $request): void {
        Auth::requireStaffRole();

        if ($request->getMethod() === 'POST') {
            if (!Helper::validateCsrf($request->post('csrf_token'))) {
                Helper::setFlash('danger', 'Invalid security token.');
                $this->redirect('admin/verification');
            }

            $user = Auth::user();
            $code = Verification::create([
                'verification_code' => $request->post('verification_code'),
                'document_type' => $request->post('document_type'),
                'holder_name' => $request->post('holder_name'),
                'passport_or_ref' => $request->post('passport_or_ref'),
                'issue_date' => $request->post('issue_date'),
                'expiry_date' => $request->post('expiry_date'),
                'status' => $request->post('status'),
                'issued_by_officer' => $user['full_name'] . ' (High Commission Nairobi)',
                'remarks' => $request->post('remarks')
            ]);

            AuditLog::log($user['id'], $user['email'], 'create_verification', "Issued verification record: {$code}");
            Helper::setFlash('success', "Official verification seal code issued: {$code}");
            $this->redirect('admin/verification');
        }

        $records = Verification::getAll();
        $this->render('admin/verification', ['records' => $records], 'admin');
    }

    public function trade(Request $request): void {
        Auth::requireStaffRole();
        $submissions = TradeMatchmaking::getAll();
        $this->render('admin/trade', ['submissions' => $submissions], 'admin');
    }

    public function audit(Request $request): void {
        Auth::requireStaffRole();
        $logs = AuditLog::getAll();
        $this->render('admin/audit_logs', ['logs' => $logs], 'admin');
    }

    public function users(Request $request): void {
        Auth::requirePermission('system.manage_users');
        $db = \App\Core\Database::getConnection();
        $currentUser = Auth::user();

        if ($request->getMethod() === 'POST') {
            if (!Helper::validateCsrf($request->post('csrf_token'))) {
                Helper::setFlash('danger', 'Invalid security token.');
                $this->redirect('admin/users');
            }

            $action = $request->post('action', 'update');

            if ($action === 'create') {
                $fullName = Helper::sanitize($request->post('full_name'));
                $email = Helper::sanitize($request->post('email'));
                $phone = Helper::sanitize($request->post('phone'));
                $password = $request->post('password');
                $role = $request->post('role', 'citizen');
                $status = $request->post('status', 'active');
                $nin = Helper::sanitize($request->post('nin_number'));
                $passport = Helper::sanitize($request->post('passport_number'));

                $existing = $db->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
                $existing->execute([':email' => $email]);
                if ($existing->fetch()) {
                    Helper::setFlash('danger', 'An account with this email address already exists.');
                } else {
                    $passHash = password_hash($password, PASSWORD_BCRYPT);
                    $stmt = $db->prepare("INSERT INTO users (full_name, email, phone, password_hash, role, status, nin_number, passport_number) VALUES (:fn, :em, :ph, :phash, :r, :st, :nin, :pass)");
                    $stmt->execute([
                        ':fn' => $fullName,
                        ':em' => $email,
                        ':ph' => $phone,
                        ':phash' => $passHash,
                        ':r' => $role,
                        ':st' => $status,
                        ':nin' => $nin,
                        ':pass' => $passport
                    ]);
                    $newId = (int)$db->lastInsertId();

                    $roleIdStmt = $db->prepare("SELECT id FROM roles WHERE slug = :slug LIMIT 1");
                    $roleIdStmt->execute([':slug' => $role]);
                    $roleId = $roleIdStmt->fetchColumn();
                    if ($roleId) {
                        $db->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (:uid, :rid)")->execute([':uid' => $newId, ':rid' => $roleId]);
                    }

                    AuditLog::log($currentUser['id'], $currentUser['email'], 'create_user', "Created user account ID {$newId} ({$email}) with role {$role}");
                    Helper::setFlash('success', 'User account created successfully.');
                }
            } elseif ($action === 'reset_password') {
                $userId = (int)$request->post('user_id');
                $password = $request->post('password');
                if ($userId > 0 && !empty($password)) {
                    $passHash = password_hash($password, PASSWORD_BCRYPT);
                    $stmt = $db->prepare("UPDATE users SET password_hash = :ph WHERE id = :id");
                    $stmt->execute([':ph' => $passHash, ':id' => $userId]);
                    AuditLog::log($currentUser['id'], $currentUser['email'], 'reset_user_password', "Reset password for user ID {$userId}");
                    Helper::setFlash('success', 'User password updated successfully.');
                }
            } else {
                // Update User Details & Clearance
                $userId = (int)$request->post('user_id');
                $fullName = Helper::sanitize($request->post('full_name'));
                $email = Helper::sanitize($request->post('email'));
                $phone = Helper::sanitize($request->post('phone'));
                $newRole = $request->post('role');
                $status = $request->post('status');
                $nin = Helper::sanitize($request->post('nin_number'));
                $passport = Helper::sanitize($request->post('passport_number'));

                if ($userId > 0) {
                    $stmt = $db->prepare("UPDATE users SET full_name = :fn, email = :em, phone = :ph, role = :role, status = :status, nin_number = :nin, passport_number = :pass WHERE id = :id");
                    $stmt->execute([
                        ':fn' => $fullName,
                        ':em' => $email,
                        ':ph' => $phone,
                        ':role' => $newRole,
                        ':status' => $status,
                        ':nin' => $nin,
                        ':pass' => $passport,
                        ':id' => $userId
                    ]);

                    // Sync user_roles
                    $roleIdStmt = $db->prepare("SELECT id FROM roles WHERE slug = :slug LIMIT 1");
                    $roleIdStmt->execute([':slug' => $newRole]);
                    $roleId = $roleIdStmt->fetchColumn();

                    if ($roleId) {
                        $db->prepare("DELETE FROM user_roles WHERE user_id = :uid")->execute([':uid' => $userId]);
                        $db->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (:uid, :rid)")->execute([':uid' => $userId, ':rid' => $roleId]);
                    }

                    AuditLog::log($currentUser['id'], $currentUser['email'], 'manage_user', "Updated user ID {$userId} role to {$newRole}, status to {$status}");
                    Helper::setFlash('success', "User clearance and account details updated successfully.");
                }
            }

            $this->redirect('admin/users');
        }

        $users = $db->query("SELECT u.*, r.name as role_name FROM users u LEFT JOIN user_roles ur ON u.id = ur.user_id LEFT JOIN roles r ON ur.role_id = r.id ORDER BY u.created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
        $roles = $db->query("SELECT * FROM roles ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

        $this->render('admin/users', ['users' => $users, 'roles' => $roles], 'admin');
    }

    public function roles(Request $request): void {
        Auth::requirePermission('system.manage_users');
        $db = \App\Core\Database::getConnection();
        $currentUser = Auth::user();

        if ($request->getMethod() === 'POST') {
            if (!Helper::validateCsrf($request->post('csrf_token'))) {
                Helper::setFlash('danger', 'Invalid security token.');
                $this->redirect('admin/roles');
            }

            $action = $request->post('action');

            if ($action === 'update_permissions') {
                $roleId = (int)$request->post('role_id');
                $selectedPerms = $request->post('permissions') ?: [];

                if ($roleId > 0) {
                    $db->prepare("DELETE FROM role_permissions WHERE role_id = :rid")->execute([':rid' => $roleId]);
                    $insertStmt = $db->prepare("INSERT INTO role_permissions (role_id, permission_id) VALUES (:rid, :pid)");
                    foreach ($selectedPerms as $pid) {
                        $insertStmt->execute([':rid' => $roleId, ':pid' => (int)$pid]);
                    }
                    AuditLog::log($currentUser['id'], $currentUser['email'], 'manage_role_permissions', "Updated permissions for role ID {$roleId}");
                    Helper::setFlash('success', 'Role permissions updated successfully.');
                }
            } elseif ($action === 'create_role') {
                $name = Helper::sanitize($request->post('name'));
                $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9_]+/', '_', $request->post('slug'))));
                $description = Helper::sanitize($request->post('description'));

                if (!empty($name) && !empty($slug)) {
                    $check = $db->prepare("SELECT id FROM roles WHERE slug = :slug LIMIT 1");
                    $check->execute([':slug' => $slug]);
                    if ($check->fetch()) {
                        Helper::setFlash('danger', 'A role with this slug identifier already exists.');
                    } else {
                        $stmt = $db->prepare("INSERT INTO roles (name, slug, description, is_system) VALUES (:n, :s, :d, 0)");
                        $stmt->execute([':n' => $name, ':s' => $slug, ':d' => $description]);
                        AuditLog::log($currentUser['id'], $currentUser['email'], 'create_role', "Created custom role: {$name} ({$slug})");
                        Helper::setFlash('success', 'Custom role created successfully.');
                    }
                }
            } elseif ($action === 'create_staff') {
                $fullName = Helper::sanitize($request->post('full_name'));
                $email = Helper::sanitize($request->post('email'));
                $phone = Helper::sanitize($request->post('phone'));
                $password = $request->post('password');
                $role = $request->post('role', 'officer');

                $existing = $db->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
                $existing->execute([':email' => $email]);
                if ($existing->fetch()) {
                    Helper::setFlash('danger', 'A staff account with this email address already exists.');
                } else {
                    $passHash = password_hash($password, PASSWORD_BCRYPT);
                    $stmt = $db->prepare("INSERT INTO users (full_name, email, phone, password_hash, role, status) VALUES (:fn, :em, :ph, :phash, :r, 'active')");
                    $stmt->execute([
                        ':fn' => $fullName,
                        ':em' => $email,
                        ':ph' => $phone,
                        ':phash' => $passHash,
                        ':r' => $role
                    ]);
                    $newId = (int)$db->lastInsertId();

                    $roleIdStmt = $db->prepare("SELECT id FROM roles WHERE slug = :slug LIMIT 1");
                    $roleIdStmt->execute([':slug' => $role]);
                    $roleId = $roleIdStmt->fetchColumn();
                    if ($roleId) {
                        $db->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (:uid, :rid)")->execute([':uid' => $newId, ':rid' => $roleId]);
                    }

                    AuditLog::log($currentUser['id'], $currentUser['email'], 'create_staff_user', "Registered staff officer {$fullName} ({$email}) with role {$role}");
                    Helper::setFlash('success', 'Staff officer registered successfully.');
                }
            }

            $this->redirect('admin/roles');
        }

        $roles = $db->query("SELECT * FROM roles ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
        $allPermissions = $db->query("SELECT * FROM permissions ORDER BY module ASC, name ASC")->fetchAll(PDO::FETCH_ASSOC);

        foreach ($roles as &$r) {
            $userCountStmt = $db->prepare("SELECT COUNT(*) FROM users WHERE role = :slug");
            $userCountStmt->execute([':slug' => $r['slug']]);
            $r['user_count'] = (int)$userCountStmt->fetchColumn();

            $permStmt = $db->prepare("
                SELECT p.* FROM permissions p 
                INNER JOIN role_permissions rp ON p.id = rp.permission_id 
                WHERE rp.role_id = :rid 
                ORDER BY p.module ASC, p.name ASC
            ");
            $permStmt->execute([':rid' => $r['id']]);
            $r['permissions'] = $permStmt->fetchAll(PDO::FETCH_ASSOC);
        }
        unset($r);

        $staffUsers = $db->query("
            SELECT u.*, r.name as role_name FROM users u 
            LEFT JOIN user_roles ur ON u.id = ur.user_id 
            LEFT JOIN roles r ON ur.role_id = r.id 
            WHERE u.role != 'citizen' AND u.role != 'public_visitor' 
            ORDER BY u.created_at DESC
        ")->fetchAll(PDO::FETCH_ASSOC);

        $this->render('admin/roles', [
            'roles' => $roles,
            'allPermissions' => $allPermissions,
            'staffUsers' => $staffUsers
        ], 'admin');
    }

    public function settings(Request $request): void {
        Auth::requirePermission('system.manage_settings');
        $db = \App\Core\Database::getConnection();
        $user = Auth::user();

        if ($request->getMethod() === 'POST') {
            if (!Helper::validateCsrf($request->post('csrf_token'))) {
                Helper::setFlash('danger', 'Invalid security token.');
                $this->redirect('admin/settings');
            }

            $postedSettings = $request->post('settings') ?? [];
            $publicUploadDir = __DIR__ . '/../../public/uploads/branding';
            $rootUploadDir = __DIR__ . '/../../uploads/branding';
            if (!file_exists($publicUploadDir)) {
                @mkdir($publicUploadDir, 0755, true);
            }
            if (!file_exists($rootUploadDir)) {
                @mkdir($rootUploadDir, 0755, true);
            }

            // Allowed branding & institutional image upload keys
            $fileKeys = [
                'logo_main', 'logo_footer', 'logo_auth', 'logo_sidebar', 'logo_dark_bg', 'logo_light_bg', 'favicon_url',
                'high_commissioner_photo',
                'discover_card_1_image', 'discover_card_2_image', 'discover_card_3_image', 'discover_card_4_image'
            ];

            // Handle Deletions
            $deleteFlags = $request->post('delete_logo') ?? [];
            foreach ($fileKeys as $fileKey) {
                if (!empty($deleteFlags[$fileKey])) {
                    SystemSetting::set($fileKey, '', 'branding', $user['id']);
                }
            }

            // Handle Uploads
            $allowedExts = ['png', 'jpg', 'jpeg', 'webp', 'gif', 'ico', 'svg'];
            $allowedMimes = ['image/png', 'image/jpeg', 'image/webp', 'image/gif', 'image/x-icon', 'image/vnd.microsoft.icon', 'image/svg+xml'];

            foreach ($fileKeys as $fileKey) {
                if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] === UPLOAD_ERR_OK) {
                    $tmpName = $_FILES[$fileKey]['tmp_name'];
                    $fileName = $_FILES[$fileKey]['name'];
                    $fileSize = $_FILES[$fileKey]['size'];

                    if ($fileSize > 5 * 1024 * 1024) {
                        Helper::setFlash('warning', "File {$fileName} exceeds maximum allowed size of 5MB.");
                        continue;
                    }

                    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    $mime = Helper::getMimeType($tmpName);

                    if (!in_array($ext, $allowedExts) || (!in_array($mime, $allowedMimes) && $ext !== 'ico')) {
                        Helper::setFlash('danger', "Invalid image file type for {$fileKey}. Allowed: PNG, JPG, WEBP, GIF, ICO, SVG.");
                        continue;
                    }

                    // Handle SVG sanitization safely without corrupting valid XML attributes
                    if ($ext === 'svg' || $mime === 'image/svg+xml') {
                        $svgContent = @file_get_contents($tmpName);
                        if ($svgContent !== false) {
                            $svgContent = preg_replace('/<script[\s\S]*?>[\s\S]*?<\/script>/i', '', $svgContent);
                            $svgContent = preg_replace('/\s+on[a-z]+\s*=\s*(["\'])[^\1]*?\1/i', '', $svgContent);
                            @file_put_contents($tmpName, $svgContent);
                        }
                    }

                    $safeFileName = $fileKey . '_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
                    $publicTargetPath = $publicUploadDir . '/' . $safeFileName;
                    $rootTargetPath = $rootUploadDir . '/' . $safeFileName;

                    $moved = false;
                    if (@move_uploaded_file($tmpName, $publicTargetPath)) {
                        @copy($publicTargetPath, $rootTargetPath);
                        $moved = true;
                    } elseif (@move_uploaded_file($tmpName, $rootTargetPath)) {
                        @copy($rootTargetPath, $publicTargetPath);
                        $moved = true;
                    }

                    if ($moved) {
                        $relativeUrl = 'uploads/branding/' . $safeFileName;
                        $postedSettings[$fileKey] = $relativeUrl;
                    }
                }
            }

            // Save Settings to Database
            $stmt = $db->prepare("INSERT INTO system_settings (setting_key, setting_value, group_name, updated_by) 
                                 VALUES (:key, :val, :grp, :uid) 
                                 ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value), updated_by = VALUES(updated_by)");

            foreach ($postedSettings as $key => $val) {
                // Assign group
                $group = 'general';
                if (in_array($key, ['chancery_address', 'chancery_phone', 'emergency_hotline', 'chancery_email', 'office_hours_summary'])) {
                    $group = 'contact';
                } elseif (in_array($key, ['branding_primary_color', 'branding_dark_color', 'branding_leaf_color', 'branding_accent_color', 'logo_main', 'logo_footer', 'logo_auth', 'logo_sidebar', 'logo_dark_bg', 'logo_light_bg', 'logo_alt_text', 'favicon_url', 'copyright_text'])) {
                    $group = 'branding';
                } elseif (in_array($key, ['font_heading', 'font_body', 'font_button'])) {
                    $group = 'typography';
                } elseif (in_array($key, ['social_twitter', 'social_facebook', 'social_instagram'])) {
                    $group = 'social';
                } elseif (in_array($key, ['high_commissioner_name', 'high_commissioner_title', 'high_commissioner_quote', 'high_commissioner_photo', 'high_commissioner_message_url'])) {
                    $group = 'high_commissioner';
                } elseif (str_starts_with($key, 'discover_card_')) {
                    $group = 'discover_nigeria';
                }

                $stmt->execute([
                    ':key' => $key,
                    ':val' => trim($val),
                    ':grp' => $group,
                    ':uid' => $user['id']
                ]);
            }

            SystemSetting::invalidateCache();

            AuditLog::log($user['id'], $user['email'], 'update_settings', "Updated institutional system settings and dynamic branding.");
            Helper::setFlash('success', 'Institutional branding and system settings updated successfully.');
            $this->redirect('admin/settings');
        }

        $rawSettings = $db->query("SELECT * FROM system_settings")->fetchAll(PDO::FETCH_ASSOC);
        $settings = [];
        foreach ($rawSettings as $s) {
            $settings[$s['setting_key']] = $s['setting_value'];
        }

        $this->render('admin/settings', ['settings' => $settings], 'admin');
    }

    public function reports(Request $request): void {
        Auth::requireStaffRole();
        $db = \App\Core\Database::getConnection();

        $reportType = $request->get('type') ?? 'consular_workload';
        $startDate = $request->get('start_date') ?? date('Y-m-01');
        $endDate = $request->get('end_date') ?? date('Y-m-d');

        $reportData = [];
        $summary = [];

        if ($reportType === 'consular_workload') {
            $stmt = $db->prepare("SELECT * FROM requests WHERE DATE(created_at) BETWEEN :start AND :end ORDER BY created_at DESC");
            $stmt->execute([':start' => $startDate, ':end' => $endDate]);
            $reportData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $summary['total_cases'] = count($reportData);
            $summary['approved'] = count(array_filter($reportData, fn($r) => $r['status'] === 'approved'));
            $summary['under_review'] = count(array_filter($reportData, fn($r) => $r['status'] === 'under_review'));
        } elseif ($reportType === 'diaspora_registry') {
            $stmt = $db->prepare("SELECT * FROM diaspora_citizens WHERE DATE(created_at) BETWEEN :start AND :end ORDER BY created_at DESC");
            $stmt->execute([':start' => $startDate, ':end' => $endDate]);
            $reportData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $summary['total_registered'] = count($reportData);
            $summary['verified'] = count(array_filter($reportData, fn($r) => $r['status'] === 'verified'));
        } elseif ($reportType === 'appointments_attendance') {
            $stmt = $db->prepare("SELECT * FROM appointments WHERE appointment_date BETWEEN :start AND :end ORDER BY appointment_date DESC");
            $stmt->execute([':start' => $startDate, ':end' => $endDate]);
            $reportData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $summary['total_slots'] = count($reportData);
            $summary['attended'] = count(array_filter($reportData, fn($r) => $r['status'] === 'attended'));
            $summary['cancelled'] = count(array_filter($reportData, fn($r) => $r['status'] === 'cancelled'));
        }

        $this->render('admin/reports', [
            'reportType' => $reportType,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'reportData' => $reportData,
            'summary' => $summary
        ], 'admin');
    }

    public function export(Request $request): void {
        Auth::requireStaffRole();
        $user = Auth::user();
        $db = \App\Core\Database::getConnection();

        $type = $request->get('type') ?? 'consular_workload';
        $format = $request->get('format') ?? 'csv';

        // Security permission check per report type
        if ($type === 'consular_workload' && !Auth::can('cases.export')) {
            Helper::setFlash('danger', 'Clearance denied for consular case exports.');
            $this->redirect('admin/reports');
        } elseif ($type === 'diaspora_registry' && !Auth::can('registry.export')) {
            Helper::setFlash('danger', 'Clearance denied for diaspora registry exports.');
            $this->redirect('admin/reports');
        }

        // Audit Log entry for sensitive data export
        AuditLog::log($user['id'], $user['email'], 'export_report', "Exported {$type} report in {$format} format");

        if ($type === 'consular_workload') {

            $rows = $db->query("SELECT reference_number, applicant_name, applicant_email, service_type, status, priority, created_at FROM requests ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
            $headers = ['Reference Number', 'Applicant Name', 'Applicant Email', 'Service Type', 'Status', 'Priority', 'Created Date'];
            \App\Services\ExportService::streamCsv('Consular_Workload_Report_' . date('Ymd') . '.csv', $headers, $rows);
        } elseif ($type === 'diaspora_registry') {
            $rows = $db->query("SELECT registration_number, full_name, passport_number, state_of_origin, kenya_county, occupation, status, created_at FROM diaspora_citizens ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
            $headers = ['Reg Number', 'Full Name', 'Passport Number', 'State of Origin', 'Kenya County', 'Occupation', 'Status', 'Registered Date'];
            \App\Services\ExportService::streamCsv('Diaspora_Registry_Report_' . date('Ymd') . '.csv', $headers, $rows);
        } else {
            Helper::setFlash('danger', 'Unknown report export type.');
            $this->redirect('admin/reports');
        }
    }

    public function hero(Request $request): void {
        Auth::requireStaffRole();
        $user = Auth::user();

        if ($request->getMethod() === 'POST') {
            if (!Helper::validateCsrf($request->post('csrf_token'))) {
                Helper::setFlash('danger', 'Invalid security token.');
                $this->redirect('admin/hero');
            }

            $action = $request->post('action');

            if ($action === 'create' || $action === 'update') {
                $heading = Helper::sanitize($request->post('heading'));
                $subheading = Helper::sanitize($request->post('subheading'));
                $imageAlt = Helper::sanitize($request->post('image_alt'));
                $imageDesktop = Helper::sanitize($request->post('image_desktop'));
                $ctaPLabel = Helper::sanitize($request->post('cta_primary_label'));
                $ctaPUrl = Helper::sanitize($request->post('cta_primary_url'));
                $ctaSLabel = Helper::sanitize($request->post('cta_secondary_label'));
                $ctaSUrl = Helper::sanitize($request->post('cta_secondary_url'));
                $captionTheme = $request->post('caption_theme') === 'dark_on_light' ? 'dark_on_light' : 'light_on_dark';
                $textAlign = in_array($request->post('text_align'), ['left', 'center', 'right']) ? $request->post('text_align') : 'left';
                $displayOrder = (int)$request->post('display_order');
                $isEnabled = (int)$request->post('is_enabled');

                // Dual-location File Upload Handling for public and root directories
                if (!empty($_FILES['desktop_image_file']) && $_FILES['desktop_image_file']['error'] === UPLOAD_ERR_OK) {
                    $file = $_FILES['desktop_image_file'];
                    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                    $allowedExts = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                    
                    if (in_array($ext, $allowedExts)) {
                        $publicTargetDir = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'hero' . DIRECTORY_SEPARATOR;
                        $rootTargetDir = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'hero' . DIRECTORY_SEPARATOR;

                        if (!file_exists($publicTargetDir)) @mkdir($publicTargetDir, 0755, true);
                        if (!file_exists($rootTargetDir)) @mkdir($rootTargetDir, 0755, true);

                        $filename = 'hero_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
                        $publicFilePath = $publicTargetDir . $filename;
                        $rootFilePath = $rootTargetDir . $filename;

                        $moved = false;
                        if (@move_uploaded_file($file['tmp_name'], $publicFilePath)) {
                            @copy($publicFilePath, $rootFilePath);
                            $moved = true;
                        } elseif (@move_uploaded_file($file['tmp_name'], $rootFilePath)) {
                            @copy($rootFilePath, $publicFilePath);
                            $moved = true;
                        }

                        if ($moved) {
                            $imageDesktop = 'assets/images/hero/' . $filename;
                        } else {
                            Helper::setFlash('danger', 'Failed to save uploaded hero image.');
                        }
                    } else {
                        Helper::setFlash('danger', 'Invalid hero image file format. Allowed formats: JPG, PNG, WEBP, GIF.');
                    }
                }

                if (empty($imageDesktop)) {
                    $imageDesktop = 'assets/images/hero/IMG-20260901-WA0014.jpg';
                }

                $imageMobile = $imageDesktop; // Unified image auto-fits all screen sizes

                $data = [
                    'heading' => $heading,
                    'subheading' => $subheading,
                    'image_desktop' => $imageDesktop,
                    'image_mobile' => $imageMobile,
                    'image_alt' => !empty($imageAlt) ? $imageAlt : 'Hero Slide Image',
                    'cta_primary_label' => $ctaPLabel,
                    'cta_primary_url' => $ctaPUrl,
                    'cta_secondary_label' => $ctaSLabel,
                    'cta_secondary_url' => $ctaSUrl,
                    'caption_theme' => $captionTheme,
                    'text_align' => $textAlign,
                    'display_order' => $displayOrder,
                    'is_enabled' => $isEnabled
                ];

                if ($action === 'create') {
                    \App\Models\HeroSlide::create($data);
                    AuditLog::log($user['id'], $user['email'], 'create_hero_slide', "Created hero slide: {$heading}");
                    Helper::setFlash('success', 'Hero slide created and published.');
                } else {
                    $id = (int)$request->post('slide_id');
                    \App\Models\HeroSlide::update($id, $data);
                    AuditLog::log($user['id'], $user['email'], 'update_hero_slide', "Updated hero slide ID {$id}");
                    Helper::setFlash('success', 'Hero slide updated successfully.');
                }
            } elseif ($action === 'toggle') {
                $id = (int)$request->post('slide_id');
                $status = (int)$request->post('is_enabled');
                \App\Models\HeroSlide::toggle($id, $status);
                AuditLog::log($user['id'], $user['email'], 'toggle_hero_slide', "Toggled hero slide ID {$id} status to {$status}");
                Helper::setFlash('info', 'Slide visibility updated.');
            } elseif ($action === 'delete') {
                $id = (int)$request->post('slide_id');
                \App\Models\HeroSlide::delete($id);
                AuditLog::log($user['id'], $user['email'], 'delete_hero_slide', "Deleted hero slide ID {$id}");
                Helper::setFlash('info', 'Slide deleted.');
            }

            $this->redirect('admin/hero');
        }

        $slides = \App\Models\HeroSlide::getAll();
        $this->render('admin/hero', ['slides' => $slides], 'admin');
    }
}



