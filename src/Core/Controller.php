<?php

namespace App\Core;

abstract class Controller {
    /**
     * Render view file with data layout
     */
    protected function render(string $viewPath, array $data = [], string $layout = 'header'): void {
        extract($data);
        $app = require __DIR__ . '/../../config/app.php';
        
        $viewFile = __DIR__ . '/../../views/' . $viewPath . '.php';
        if (!file_exists($viewFile)) {
            die("View file not found: views/{$viewPath}.php");
        }

        // Render header
        if ($layout === 'admin') {
            require __DIR__ . '/../../views/layouts/admin_header.php';
        } elseif ($layout === 'header') {
            require __DIR__ . '/../../views/layouts/header.php';
        }

        // Render main view
        require $viewFile;

        // Render footer
        if ($layout === 'admin') {
            require __DIR__ . '/../../views/layouts/admin_footer.php';
        } elseif ($layout === 'header') {
            require __DIR__ . '/../../views/layouts/footer.php';
        }
    }

    /**
     * Render JSON output
     */
    protected function json(array $data, int $statusCode = 200): void {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

    /**
     * Redirect to URL
     */
    protected function redirect(string $path): void {
        header('Location: ' . Helper::baseUrl($path));
        exit();
    }
}
