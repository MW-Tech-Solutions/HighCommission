<?php

namespace App\Core;

class Request {
    public function getMethod(): string {
        return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
    }

    public function getUri(): string {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($uri, PHP_URL_PATH);
        
        // Strip base path subdirectory if running under /KenyaHighCommission or similar
        $scriptDir = dirname($_SERVER['SCRIPT_NAME'] ?? '');
        $scriptDir = preg_replace('/\/public$/', '', $scriptDir);
        $scriptDir = rtrim(str_replace('\\', '/', $scriptDir), '/');
        
        if ($scriptDir !== '' && strpos($path, $scriptDir) === 0) {
            $path = substr($path, strlen($scriptDir));
        }
        
        // Remove /index.php if present
        $path = preg_replace('/^\/index\.php/', '', $path);
        
        return ($path === '' || $path === false) ? '/' : $path;
    }

    public function get(string $key, $default = null) {
        return isset($_GET[$key]) ? Helper::sanitize($_GET[$key]) : $default;
    }

    public function post(string $key, $default = null) {
        if (!isset($_POST[$key])) return $default;
        if (is_array($_POST[$key])) {
            return array_map([Helper::class, 'sanitize'], $_POST[$key]);
        }
        return Helper::sanitize($_POST[$key]);
    }

    public function all(): array {
        $data = [];
        foreach ($_POST as $key => $val) {
            if (is_array($val)) {
                $data[$key] = array_map([Helper::class, 'sanitize'], $val);
            } else {
                $data[$key] = Helper::sanitize($val);
            }
        }
        return $data;
    }

    public function file(string $key): ?array {
        return $_FILES[$key] ?? null;
    }
}
