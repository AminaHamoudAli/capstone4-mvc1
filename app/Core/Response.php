<?php
namespace App\Core;
require_once __DIR__ . '/Response.php';

class Response {
  public function json($data, int $code=200): void {
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
  }
}



// namespace App\Core;

// class Response {
//     public function json(array $data, int $status = 200): void {
//         header('Content-Type: application/json; charset=UTF-8');
//         http_response_code($status);
//         echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
//         exit;
//     }
// }
