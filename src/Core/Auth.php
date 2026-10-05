<?php

namespace App\Core;

use PDO;

class Auth {
    /**
     * Check if user is logged in
     */
    public static function check(): bool {
        return !empty($_SESSION['user_id']);
    }

    /**
     * Get logged in user details
     */
    public static function user(): ?array {
        if (!self::check()) return null;
        return [
            'id' => $_SESSION['user_id'] ?? null,
            'full_name' => $_SESSION['user_name'] ?? '',
            'email' => $_SESSION['user_email'] ?? '',
            'role' => $_SESSION['user_role'] ?? 'citizen',
            'mfa_verified' => $_SESSION['mfa_verified'] ?? false,
        ];
    }

    /**
     * Attempt user login with throttling & session security
     */
    public static function attempt(string $email, string $password): bool {
        $db = Database::getConnection();

        // 1. Throttling check (max 5 failed attempts in 15 minutes)
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $throttleStmt = $db->prepare("SELECT COUNT(*) FROM audit_logs WHERE action = 'login_failed' AND ip_address = :ip AND created_at > DATE_SUB(NOW(), INTERVAL 15 MINUTE)");
        $throttleStmt->execute([':ip' => $ip]);
        if ((int)$throttleStmt->fetchColumn() >= 5) {
            Helper::setFlash('danger', 'Too many failed attempts. Please try again in 15 minutes.');
            return false;
        }

        // 2. Fetch user
        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email AND status = 'active' LIMIT 1");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            if (!headers_sent() && session_status() === PHP_SESSION_ACTIVE) {
                @session_regenerate_id(true);
            }

            // Set session variables
            $_SESSION['user_id'] = (int)$user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['mfa_verified'] = true; // Default true for demo; can be set false if MFA active

            // Load effective permissions into session
            self::loadPermissions((int)$user['id']);

            // Audit log success
            $logStmt = $db->prepare("INSERT INTO audit_logs (user_id, user_email, action, details, ip_address) VALUES (:uid, :email, 'login', 'User logged in successfully', :ip)");
            $logStmt->execute([
                ':uid' => $user['id'],
                ':email' => $user['email'],
                ':ip' => $ip
            ]);

            return true;
        }

        // Audit log failure
        $logStmt = $db->prepare("INSERT INTO audit_logs (user_id, user_email, action, details, ip_address) VALUES (NULL, :email, 'login_failed', 'Failed login attempt', :ip)");
        $logStmt->execute([':email' => $email, ':ip' => $ip]);

        return false;
    }

    /**
     * Calculate and cache effective user permissions
     * Rules: Effective = Role Grants + Explicit User Grants - Explicit User Denials (Denials Win)
     */
    public static function loadPermissions(int $userId): void {
        $db = Database::getConnection();

        // 1. Fetch Role Grants
        $roleStmt = $db->prepare("
            SELECT DISTINCT p.slug 
            FROM user_roles ur
            JOIN role_permissions rp ON ur.role_id = rp.role_id
            JOIN permissions p ON rp.permission_id = p.id
            WHERE ur.user_id = :uid
        ");
        $roleStmt->execute([':uid' => $userId]);
        $rolePermissions = $roleStmt->fetchAll(PDO::FETCH_COLUMN) ?: [];

        // 2. Fetch Explicit User Grants & Denials
        $userStmt = $db->prepare("
            SELECT p.slug, up.type 
            FROM user_permissions up
            JOIN permissions p ON up.permission_id = p.id
            WHERE up.user_id = :uid
        ");
        $userStmt->execute([':uid' => $userId]);
        $explicit = $userStmt->fetchAll(PDO::FETCH_ASSOC);

        $grants = [];
        $denials = [];
        foreach ($explicit as $item) {
            if ($item['type'] === 'grant') {
                $grants[] = $item['slug'];
            } elseif ($item['type'] === 'deny') {
                $denials[] = $item['slug'];
            }
        }

        // Combine role grants and user explicit grants
        $effective = array_unique(array_merge($rolePermissions, $grants));

        // Subtract explicit denials (Denials win)
        $effective = array_diff($effective, $denials);

        $_SESSION['user_permissions'] = array_values($effective);
    }

    /**
     * Check if logged in user has explicit permission
     */
    public static function can(string $permission): bool {
        if (!self::check()) return false;
        $user = self::user();

        // Admin & Super Admin have implicit grant to all permissions
        if (in_array($user['role'], ['admin', 'super_admin'])) {
            return true;
        }

        $perms = $_SESSION['user_permissions'] ?? [];
        return in_array($permission, $perms);
    }

    /**
     * Require explicit permission or fail
     */
    public static function requirePermission(string $permission, string $redirectTo = '/admin/dashboard'): void {
        self::requireLogin('/admin/login');
        if (!self::can($permission)) {
            Helper::setFlash('danger', 'Access denied. You do not possess clearance for this operational action (' . htmlspecialchars($permission) . ').');
            header('Location: ' . Helper::baseUrl($redirectTo));
            exit();
        }
    }

    /**
     * Logout user
     */
    public static function logout(): void {
        if (self::check()) {
            $user = self::user();
            $db = Database::getConnection();
            $logStmt = $db->prepare("INSERT INTO audit_logs (user_id, user_email, action, details, ip_address) VALUES (:uid, :email, 'logout', 'User logged out', :ip)");
            $logStmt->execute([
                ':uid' => $user['id'],
                ':email' => $user['email'],
                ':ip' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'
            ]);
        }

        unset($_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['user_email'], $_SESSION['user_role'], $_SESSION['user_permissions'], $_SESSION['mfa_verified']);
    }

    /**
     * Guard page requiring login
     */
    public static function requireLogin(string $redirectTo = '/portal/login'): void {
        if (!self::check()) {
            Helper::setFlash('warning', 'Please sign in to access this section.');
            header('Location: ' . Helper::baseUrl($redirectTo));
            exit();
        }
    }

    /**
     * Check if role string represents staff clearance
     */
    public static function isStaffRole(?string $role = null): bool {
        if ($role === null) {
            $user = self::user();
            $role = $user['role'] ?? '';
        }
        $staffRoles = ['officer', 'editor', 'admin', 'super_admin', 'consular_officer', 'registry_welfare_officer', 'trade_officer', 'appointment_officer', 'content_editor', 'publisher', 'supervisor', 'auditor'];
        return in_array($role, $staffRoles);
    }

    /**
     * Guard page requiring specific staff roles
     */
    public static function requireStaffRole(array $roles = []): void {
        self::requireLogin('/admin/login');
        if (!self::isStaffRole()) {
            Helper::setFlash('danger', 'Access denied. Staff clearance required.');
            header('Location: ' . Helper::baseUrl('/admin/login'));
            exit();
        }
    }
}

