<?php
namespace App\Controllers;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

require_once __DIR__ . '/../Core/Controller.php';
use App\Core\Controller;
use App\Models\Salary;

class SalaryController extends Controller {
    private Salary $model;

    public function __construct() {
        parent::__construct();
        $this->model = new Salary();
    }

    // جلب جميع الرواتب أو حسب الموظف
    public function index(array $query = []): void {
        $employeeId = isset($query['employee_id']) ? (int)$query['employee_id'] : null;
        $data = $employeeId ? $this->model->getByEmployee($employeeId) : $this->model->getAll();
        $this->ok(['data' => $data]);
        exit;

    }

    // جلب راتب موظف واحد
    public function show(array $params): void {
        $id = (int)($params['id'] ?? 0);
        $row = $this->model->getByEmployee($id);
        if (!$row) {
            $this->fail('Salary not found', 404);
            return;
        }
        $this->ok(['data' => $row]);
    }

    // إنشاء راتب جديد
    public function store(array $input): void {
        foreach (['employee_id','bonus_percent','deduction_percent'] as $f) {
            if (!isset($input[$f])) {
                $this->fail("$f is required", 422);
                return;
            }
        }

        $id = $this->model->create([
            'employee_id'      => (int)$input['employee_id'],
            'bonus_percent'    => (float)$input['bonus_percent'],
            'deduction_percent'=> (float)$input['deduction_percent']
        ]);

        $this->created(['id' => $id, 'message'=>'Salary created']);
    }

    // تعديل راتب موجود
    public function update(array $params, array $input): void {
        $id = (int)($params['id'] ?? 0);
        $row = $this->model->getByEmployee($id);
        if (!$row) { $this->fail('Salary not found', 404); return; }

        foreach (['employee_id','bonus_percent','deduction_percent'] as $f) {
            if (!isset($input[$f])) {
                $this->fail("$f is required", 422);
                return;
            }
        }

        $ok = $this->model->update($id, [
            'employee_id'      => (int)$input['employee_id'],
            'bonus_percent'    => (float)$input['bonus_percent'],
            'deduction_percent'=> (float)$input['deduction_percent']
        ]);

        $ok ? $this->ok(['updated'=>true]) : $this->fail('Update failed', 400);
    }

    // حذف راتب
    public function destroy(array $params): void {
        $id = (int)($params['id'] ?? 0);
        $row = $this->model->getByEmployee($id);
        if (!$row) { $this->fail('Salary not found', 404); return; }

        $this->ok(['deleted' => $this->model->delete($id)]);
    }

    // حساب صافي الراتب من الأساسي والمكافآت والخصومات
    public function calculate(array $input): void {
        $base  = (float)($input['base_salary'] ?? 0);
        $bonusPercent = (float)($input['bonus_percent'] ?? 0);
        $deductionPercent = (float)($input['deduction_percent'] ?? 0);

        $bonus = ($base * $bonusPercent) / 100;
        $deduction = ($base * $deductionPercent) / 100;
        $net = $base + $bonus - $deduction;

        $this->ok([
            'net_salary' => $net,
            'bonus'      => $bonus,
            'deduction'  => $deduction
        ]);
    }
}
