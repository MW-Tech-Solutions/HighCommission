<?php

namespace App\Core;

class Router {
    private array $routes = [];

    public function get(string $path, array $handler): void {
        $this->routes['GET'][$this->normalizePath($path)] = $handler;
    }

    public function post(string $path, array $handler): void {
        $this->routes['POST'][$this->normalizePath($path)] = $handler;
    }

    private function normalizePath(string $path): string {
        $path = '/' . trim($path, '/');
        return $path === '/' ? '/' : $path;
    }

    public function dispatch(Request $request): void {
        $method = $request->getMethod();
        $uri = $this->normalizePath($request->getUri());

        if (isset($this->routes[$method][$uri])) {
            $handler = $this->routes[$method][$uri];
            $controllerClass = $handler[0];
            $action = $handler[1];

            if (class_exists($controllerClass)) {
                $controller = new $controllerClass();
                if (method_exists($controller, $action)) {
                    $controller->$action($request);
                    return;
                }
            }
        }

        // 404 Fallback
        http_response_code(404);
        $app = require __DIR__ . '/../../config/app.php';
        require __DIR__ . '/../../views/layouts/header.php';
        echo '<div class="container py-5 my-5 text-center">
                <div class="card shadow-sm p-5 border-0 rounded-4 max-w-600 mx-auto">
                    <h1 class="display-1 text-danger fw-bold">404</h1>
                    <h2 class="fw-bold mb-3" style="color: var(--nhc-emerald-dark);">Page Not Found</h2>
                    <p class="text-muted mb-4">The requested page or consular service path could not be located on the High Commission portal.</p>
                    <a href="' . Helper::baseUrl('/') . '" class="btn btn-emerald px-4 py-2 rounded-3"><i class="bi bi-house-door-fill me-2"></i>Return to Homepage</a>
                </div>
              </div>';
        require __DIR__ . '/../../views/layouts/footer.php';
    }
}
