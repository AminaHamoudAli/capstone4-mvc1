<?php
// api.php - نقطة دخول الـ API

// ===================== Require Files =====================
require_once __DIR__ . '/../Core/Request.php';
require_once __DIR__ . '/../Core/Router.php';
require_once __DIR__ . '/../Core/Response.php';

require_once __DIR__ . '/../Controllers/EmployeeController.php';
require_once __DIR__ . '/../Controllers/SalaryController.php';
require_once __DIR__ . '/../Controllers/LeaveController.php';

// ===================== Use Namespaces =====================
use App\Core\{Request, Router, Response};
use App\Controllers\{EmployeeController, SalaryController, LeaveController};

// ===================== إنشاء كائنات =====================
$request  = new Request();
$response = new Response();
$router   = new Router($request, $response);

$employee = new EmployeeController();
$salary   = new SalaryController();
$leave    = new LeaveController();

// ===================== Employee Routes =====================
$router->add('GET', '/api/v1/employees', fn() => $employee->index());
$router->add('GET', '/api/v1/employees/{id}', fn($p) => $employee->show($p));
$router->add('POST', '/api/v1/employees', fn() => $employee->store());
$router->add('PUT', '/api/v1/employees/{id}', fn($p) => $employee->update($p, json_decode(file_get_contents('php://input'), true)));
$router->add('DELETE', '/api/v1/employees/{id}', fn($p) => $employee->destroy($p));

// ===================== Salary Routes =====================
$router->add('GET', '/api/v1/salaries', fn() => $salary->index($_GET));
$router->add('GET', '/api/v1/salaries/{id}', fn($p) => $salary->show($p));
$router->add('POST', '/api/v1/salaries', fn() => $salary->store(json_decode(file_get_contents('php://input'), true)));
$router->add('PUT', '/api/v1/salaries/{id}', fn($p) => $salary->update($p, json_decode(file_get_contents('php://input'), true)));
$router->add('DELETE', '/api/v1/salaries/{id}', fn($p) => $salary->destroy($p));
$router->add('POST', '/api/v1/salaries/calculate', fn() => $salary->calculate(json_decode(file_get_contents('php://input'), true)));

// ===================== Leave Routes =====================
$router->add('GET', '/api/v1/leaves', fn() => $leave->index());
$router->add('GET', '/api/v1/leaves/{id}', fn($p) => $leave->show($p));
$router->add('POST', '/api/v1/leaves', fn() => $leave->store(json_decode(file_get_contents('php://input'), true)));
$router->add('PUT', '/api/v1/leaves/{id}', fn($p) => $leave->update($p, json_decode(file_get_contents('php://input'), true)));
$router->add('DELETE', '/api/v1/leaves/{id}', fn($p) => $leave->destroy($p));

// ===================== Run Router =====================
$router->resolve();
