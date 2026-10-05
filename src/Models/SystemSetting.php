<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Helper;
use PDO;

class SystemSetting {
    private static array $cache = [];

    /**
     * Fetch all settings into a key => value array
     */
    public static function getAll(): array {
        if (!empty(self::$cache)) {
            return self::$cache;
        }

        try {
            $db = Database::getConnection();
            $rows = $db->query("SELECT setting_key, setting_value FROM system_settings")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $r) {
                self::$cache[$r['setting_key']] = $r['setting_value'];
            }
        } catch (\Throwable $e) {
            // Fallback defaults if DB call fails
        }

        return self::$cache;
    }

    /**
     * Get a specific setting by key with a fallback
     */
    public static function get(string $key, ?string $default = ''): string {
        $all = self::getAll();
        if (array_key_exists($key, $all) && $all[$key] !== null && $all[$key] !== '') {
            return $all[$key];
        }
        return $default ?? '';
    }

    /**
     * Set a single setting key
     */
    public static function set(string $key, string $value, string $group = 'general', ?int $updatedBy = null): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO system_settings (setting_key, setting_value, group_name, updated_by) 
                             VALUES (:key, :val, :grp, :uid) 
                             ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value), group_name = VALUES(group_name), updated_by = VALUES(updated_by)");
        $result = $stmt->execute([
            ':key' => $key,
            ':val' => $value,
            ':grp' => $group,
            ':uid' => $updatedBy
        ]);

        self::$cache[$key] = $value;
        return $result;
    }

    /**
     * Invalidate setting memory cache
     */
    public static function invalidateCache(): void {
        self::$cache = [];
    }

    /**
     * Get asset URL with version query param for cache busting
     */
    public static function getAssetUrl(string $settingKey, string $defaultPath = ''): string {
        $path = self::get($settingKey, $defaultPath);
        if (empty($path)) {
            $path = $defaultPath;
        }
        if (empty($path)) {
            return '';
        }

        // Check if full HTTP/HTTPS URL
        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        $cleanPath = ltrim($path, '/');
        $fullSystemPath = __DIR__ . '/../../public/' . $cleanPath;
        $version = file_exists($fullSystemPath) ? filemtime($fullSystemPath) : time();

        return Helper::baseUrl($cleanPath) . '?v=' . $version;
    }

    /**
     * Get resolved Logo asset data for a given placement:
     * placements: 'main', 'footer', 'auth', 'sidebar', 'dark_bg', 'light_bg'
     */
    public static function getLogo(string $placement = 'main'): array {
        $keyMap = [
            'main' => 'logo_main',
            'footer' => 'logo_footer',
            'auth' => 'logo_auth',
            'sidebar' => 'logo_sidebar',
            'dark_bg' => 'logo_dark_bg',
            'light_bg' => 'logo_light_bg',
        ];

        $targetKey = $keyMap[$placement] ?? 'logo_main';
        $path = self::get($targetKey);

        // Inherit from logo_main if placement override is empty
        if (empty($path) && $targetKey !== 'logo_main') {
            $path = self::get('logo_main');
        }

        $alt = self::get('logo_alt_text', 'Coat of Arms of the Federal Republic of Nigeria');

        if (!empty($path)) {
            $url = self::getAssetUrl($targetKey, $path);
            return [
                'has_image' => true,
                'url' => $url,
                'alt' => $alt,
                'path' => $path
            ];
        }

        return [
            'has_image' => false,
            'url' => '',
            'alt' => $alt,
            'path' => ''
        ];
    }

    /**
     * Get Favicon URL with cache buster
     */
    public static function getFaviconUrl(): string {
        $faviconPath = self::get('favicon_url');
        if (!empty($faviconPath)) {
            return self::getAssetUrl('favicon_url', $faviconPath);
        }
        // Check default assets directory
        $defaultFavicon = 'assets/images/favicon.ico';
        if (file_exists(__DIR__ . '/../../public/' . $defaultFavicon)) {
            return Helper::baseUrl($defaultFavicon) . '?v=' . filemtime(__DIR__ . '/../../public/' . $defaultFavicon);
        }
        return '';
    }
}
