<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/Routes/api.php';

use App\Core\{Request, Response, Router};

// إعداد CORS
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-CSRF-Token');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

// إنشاء Router وتشغيله
$router = new Router(new Request(), new Response());
$router->resolve();




// // phpinfo();

// // Simple PSR-4-ish autoloader for App\*
// spl_autoload_register(function ($class) {
//     $prefix = 'App\\';
//     if (strncmp($class, $prefix, strlen($prefix)) === 0) {
//         $relative = str_replace('\\', '/', substr($class, strlen($prefix)));
//         $file = __DIR__ . '/../app/' . $relative . '.php';
//         if (file_exists($file)) require $file;
//     }
// });

// // Create router and include all routes
// $router = new App\Core\Router();
// require __DIR__ . '/../routes/web.php';

// // Dispatch current request
// // echo $_SERVER['REQUEST_URI'];
// $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);





