<?php



// namespace App\Controllers;
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type, Authorization");
// header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
// header("Access-Control-Allow-Headers: Content-Type");

// require_once __DIR__ . '/../Core/Controller.php';
// use App\Core\Controller;
// use App\Models\Employee;

// class EmployeeController extends Controller {
//     private Employee $model;

//     public function __construct() {
//         parent::__construct();
//         $this->model = new Employee();
//     }

//     // جلب كل الموظفين
//     public function index(): void {
//         $employees = $this->model->all(); // all() موجودة في Model
//         $this->ok(['data' => $employees]);
//         exit;

//     }

//     // جلب موظف واحد بالـ id
//     public function show(array $params): void {
//         $id = (int)($params['id'] ?? 0);
//         $emp = $this->model->find($id); // تعديل هنا من getById() إلى find()
//         if (!$emp) {
//             $this->fail('Employee not found', 404);
//             return;
//         }
//         $this->ok(['data' => $emp]);
//     }

//     // إنشاء موظف جديد
//     public function store(): void {
//         $input = json_decode(file_get_contents('php://input'), true);

//         foreach (['name','email','salary','department','contract','evaluation'] as $f) {
//             if (!isset($input[$f]) || $input[$f] === '') {
//                 $this->fail("$f is required", 422);
//                 return;
//             }
//         }

//         $newId = $this->model->create($input); // create() يعيد ID الموظف الجديد
//         $this->created(['id' => $newId, 'message' => 'Employee created']);
//     }

//     // تعديل بيانات موظف موجود
//     public function update(array $params, array $input): void {
//         $id = (int)($params['id'] ?? 0);
//         if (!$this->model->find($id)) { // تعديل هنا
//             $this->fail('Employee not found', 404);
//             return;
//         }

//         foreach (['name','email','salary','department','contract','evaluation'] as $f) {
//             if (!isset($input[$f]) || $input[$f] === '') {
//                 $this->fail("$f is required", 422);
//                 return;
//             }
//         }

//         $ok = $this->model->update($id, $input);
//         $ok ? $this->ok(['updated' => true]) : $this->fail('Update failed', 400);
//     }

//     // حذف موظف
//     public function destroy(array $params): void {
//         $id = (int)($params['id'] ?? 0);
//         if (!$this->model->find($id)) { // تعديل هنا
//             $this->fail('Employee not found', 404);
//             return;
//         }
//         $this->ok(['deleted' => $this->model->delete($id)]);
//     }
// }


namespace App\Controllers;

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once __DIR__ . '/../Core/Controller.php';
use App\Core\Controller;
use App\Models\Employee;

class EmployeeController extends Controller {
    private Employee $model;

    public function __construct() {
        parent::__construct();
        $this->model = new Employee();
    }

    // جلب كل الموظفين
    public function index(): void {
        $employees = $this->model->all();
        $this->ok([
            'success' => true,
            'data' => $employees
        ]);
        exit;
    }

    // جلب موظف واحد بالـ id
    public function show(array $params): void {
        $id = (int)($params['id'] ?? 0);
        $emp = $this->model->find($id);
        if (!$emp) {
            $this->fail('Employee not found', 404);
            return;
        }
        $this->ok([
            'success' => true,
            'data' => $emp
        ]);
    }

    // // إنشاء موظف جديد
    public function store(): void {
        $input = json_decode(file_get_contents('php://input'), true);

        foreach (['name','email','salary','department','contract','evaluation'] as $f) {
            if (!isset($input[$f]) || $input[$f] === '') {
                $this->fail("$f is required", 422);
                // return;
            }
        }

        $newId = $this->model->create($input);
        $this->created([
            'success' => true,
            'data' => [
                'id' => $newId,
                'message' => 'تمت إضافة الموظف بنجاح'
            ]
        ]);
    }
// public function store(){
// //     // نجرب نقرأ JSON من الطلب
//     $input = json_decode(file_get_contents('php://input'), true);
// // 
//     if (!is_array($input)) {
//         $input = $_POST;
// }

// $required = ['name','email','salary','department','contract','evaluation'];
// foreach ($required as $f) {
// if (!isset($input[$f]) || trim((string)$input[$f]) === '') {
// $this->fail("$f is required", 422);
// return;
// }
// }

//     // نستدعي الموديل لإضافة موظف
//     $newId = $this->model->create($input);

//     if ($newId > 0) {
//         $this->created([
//             'success' => true,
//             'data' => [
//                 'id' => $newId,
//                 'message' => 'تمت إضافة الموظف بنجاح'
//             ]
//         ]);
//     } else {
//         $this->fail('Failed to create employee', 500);
//     }
// }

// public function store(){

//     $input = json_decode(file_get_contents('php://input'),true);

//     
//     if (!is_array($input)) {
//         $input = $_POST;
//     }

//     // نتحقق من الحقول المطلوبة
//     $required = ['name','email','salary','department','contract','evaluation'];
//     foreach ($required as $f) {
//         if (!isset($input[$f]) || trim((string)$input[$f]) === '') {
//             $this->fail("$f is required", 422);
//             return;
//         }
//     }

//     // نستدعي الموديل لإضافة موظف
//     $newId = $this->model->create($input);

//     if ($newId > 0) {
//         $this->created([
//             'success' => true,
//             'data' => [
//                 'id' => $newId,
//                 'message' => 'تمت إضافة الموظف بنجاح'
//             ]
//         ]);
//     } else {
//         $this->fail('Failed to create employee', 500);
//     }
// }
    // تعديل بيانات موظف موجود
    public function update(array $params, array $input): void {
        $id = (int)($params['id'] ?? 0);
        if (!$this->model->find($id)) {
            $this->fail('Employee not found', 404);
            return;
        }

        foreach (['name','email','salary','department','contract','evaluation'] as $f) {
            if (!isset($input[$f]) || $input[$f] === '') {
                $this->fail("$f is required", 422);
                return;
            }
        }

        $ok = $this->model->update($id, $input);
        if ($ok) {
            $this->ok([
                'success' => true,
                'data' => [
                    'id' => $id,
                    'message' => 'تم تحديث بيانات الموظف بنجاح'
                ]
            ]);
        } else {
            $this->fail('Update failed', 400);
        }
    }

    // حذف موظف
    public function destroy(array $params): void {
        $id = (int)($params['id'] ?? 0);
        if (!$this->model->find($id)) {
            $this->fail('Employee not found', 404);
            return;
        }

        $deleted = $this->model->delete($id);
        $this->ok([
            'success' => true,
            'data' => [
                'deleted' => $deleted,
                'message' => 'تم حذف الموظف بنجاح'
            ]
        ]);
    }
}
