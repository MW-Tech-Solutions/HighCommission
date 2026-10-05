<?php

namespace App\Core;

class Helper {
    /**
     * Generate dynamic base URL for subfolder or domain root compatibility
     */
    public static function baseUrl(string $path = ''): string {
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $dir = dirname($scriptName);
        
        // Remove /public if script is in public/
        $dir = preg_replace('/\/public$/', '', $dir);
        $dir = rtrim(str_replace('\\', '/', $dir), '/');
        
        $path = ltrim($path, '/');
        return ($dir === '' || $dir === '/') ? '/' . $path : $dir . '/' . $path;
    }

    /**
     * Sanitize string output
     */
    public static function sanitize(?string $str): string {
        if ($str === null) return '';
        return htmlspecialchars(trim($str), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Generate or fetch CSRF token
     */
    public static function csrfToken(): string {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Render hidden CSRF input field
     */
    public static function csrfField(): string {
        $token = self::csrfToken();
        return '<input type="hidden" name="csrf_token" value="' . $token . '">';
    }

    /**
     * Validate submitted CSRF token
     */
    public static function validateCsrf(?string $token): bool {
        return !empty($token) && !empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    /**
     * Set flash alert message
     */
    public static function setFlash(string $type, string $message): void {
        $_SESSION['flash'] = [
            'type' => $type, // 'success', 'danger', 'warning', 'info'
            'message' => $message
        ];
    }

    /**
     * Get and clear flash message
     */
    public static function getFlash(): ?array {
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
        return null;
    }

    /**
     * Render status badge HTML with Bootstrap styling
     */
    public static function statusBadge(string $status): string {
        $status = strtolower($status);
        $badgeClass = 'bg-secondary';
        
        switch ($status) {
            case 'received':
            case 'pending':
            case 'submitted':
            case 'in_progress':
                $badgeClass = 'bg-info text-dark';
                break;
            case 'under_review':
            case 'info_needed':
                $badgeClass = 'bg-warning text-dark';
                break;
            case 'approved':
            case 'verified':
            case 'confirmed':
            case 'attended':
            case 'valid':
            case 'matched':
                $badgeClass = 'bg-success';
                break;
            case 'closed':
            case 'rejected':
            case 'cancelled':
            case 'revoked':
            case 'flagged':
            case 'unverified':
            case 'fraudulent':
                $badgeClass = 'bg-danger';
                break;
        }
        
        $label = ucwords(str_replace('_', ' ', $status));
        return '<span class="badge ' . $badgeClass . '">' . self::sanitize($label) . '</span>';
    }

    /**
     * Format date nicely
     */
    public static function formatDate(?string $date, string $format = 'd M Y, h:i A'): string {
        if (!$date) return 'N/A';
        return date($format, strtotime($date));
    }

    /**
     * Validate and sanitize rich text server-side using an allowed element/attribute policy
     * Editors cannot inject scripts, inline event handlers, or iframe malware.
     */
    public static function sanitizeHtml(?string $html): string {
        if (empty($html)) return '';

        // 1. Remove dangerous script, iframe, object, embed, applet, style, form tags along with their content
        $html = preg_replace('/<(script|iframe|object|embed|applet|style|form|input|button)[^>]*?>.*?<\/\\1>/si', '', $html);
        $html = preg_replace('/<(script|iframe|object|embed|applet|style|form|input|button)[^>]*?>/si', '', $html);

        // 2. Remove inline event handlers (e.g. onclick=, onload=, onerror=)
        $html = preg_replace('/ on[a-z]+\s*=\s*(["\'])[^\1]*?\1/si', '', $html);
        $html = preg_replace('/ on[a-z]+\s*=\s*[^ >]+/si', '', $html);

        // 3. Remove javascript: and data: links
        $html = preg_replace('/href\s*=\s*(["\'])\s*javascript:[^\1]*?\1/si', 'href="#"', $html);
        $html = preg_replace('/src\s*=\s*(["\'])\s*javascript:[^\1]*?\1/si', 'src=""', $html);

        // 4. Allow safe HTML tags only: p, br, b, i, strong, em, h1-h6, ul, ol, li, a, img, blockquote, table, tr, td, th, span, div
        $allowedTags = '<p><br><b><i><strong><em><h1><h2><h3><h4><h5><h6><ul><ol><li><a><img><blockquote><table><tr><td><th><thead><tbody><span><div>';
        return strip_tags($html, $allowedTags);
    }

    /**
     * Send HTTP security headers (OWASP ASVS Baseline)
     */
    public static function setSecurityHeaders(): void {
        if (headers_sent()) return;

        header("X-Frame-Options: SAMEORIGIN");
        header("X-Content-Type-Options: nosniff");
        header("Referrer-Policy: strict-origin-when-cross-origin");
        header("X-XSS-Protection: 1; mode=block");
        header("Permissions-Policy: geolocation=(), camera=(), microphone=()");
        header("Content-Security-Policy: default-src 'self' 'unsafe-inline' 'unsafe-eval' https: data:; img-src 'self' data: https:; font-src 'self' https: data:;");
    }

    /**
     * Prevent SSRF and Open Redirect vulnerabilities by validating target URLs
     */
    public static function safeRedirect(string $url, string $defaultFallback = '/'): void {
        // Ensure redirect target is relative path or matches canonical domain
        if (strpos($url, '//') === 0 || preg_match('/^[a-z0-9]+:/i', $url)) {
            $parsed = parse_url($url);
            $allowedHost = 'nigeriankenya.or.ke';
            if (!isset($parsed['host']) || $parsed['host'] !== $allowedHost) {
                $url = self::baseUrl($defaultFallback);
            }
        }
        header("Location: " . $url);
        exit();
    }
}


