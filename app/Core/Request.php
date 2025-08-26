<?php
namespace App\Core;

class Request {
    public function method(): string {
        return strtolower($_SERVER['REQUEST_METHOD'] ?? 'get');
    }

    public function path(): string {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';

        // إزالة بادئة المشروع/public إذا موجودة
        $base = '/copstone4-mvc3/public';
        if (strpos($uri, $base) === 0) {
            $uri = substr($uri, strlen($base));
        }

        $uri = rtrim($uri, '/');
        return $uri === '' ? '/' : $uri;
    }

    public function query(): array {
        return $_GET;
    }

    public function headers(): array {
        return function_exists('getallheaders') ? (getallheaders() ?: []) : [];
    }

    public function json(): array {
        $raw = file_get_contents('php://input');
        $data = json_decode($raw ?: '[]', true);
        return is_array($data) ? $data : [];
    }

    public function input(): array {
        return array_merge($_POST, $this->json());
    }
}
