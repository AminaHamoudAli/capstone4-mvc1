<?php
namespace App\Controllers;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

require_once __DIR__ . '/../Core/Controller.php';
use App\Core\Controller;
use App\Models\Leave;

class LeaveController extends Controller {
    private Leave $model;

    public function __construct() {
        parent::__construct();
        $this->model = new Leave();
    }

    // جلب كل الإجازات
    public function index(): void {
        $leaves = $this->model->all(); // تأكد أن all() ترجع array
        $this->ok(['data' => $leaves]);
        exit;

    }

    // جلب إجازة محددة بالـ id
    public function show(array $params): void {
        $id = (int)($params['id'] ?? 0);
        $row = $this->model->find($id);
        if (!$row) {
            $this->fail('Leave not found', 404);
    exit;

        }
        $this->ok(['data' => $row]);
    }

    // إنشاء إجازة جديدة
    public function store(array $input): void {
        foreach (['employee_id','start_date','end_date'] as $f) {
            if (!isset($input[$f])) {
                $this->fail("$f is required", 422);
                // return;
                exit;

            }
        }
        $input['reason'] = $input['reason'] ?? null;
        $input['status'] = $input['status'] ?? 'pending';

        $id = $this->model->create($input);
        $this->created(['id' => $id, 'message' => 'Leave created']);
    }

    // تعديل إجازة موجودة
    public function update(array $params, array $input): void {
        $id = (int)($params['id'] ?? 0);
        $row = $this->model->find($id);
        if (!$row) {
            $this->fail('Leave not found', 404);
            return;
        }

        foreach (['employee_id','start_date','end_date'] as $f) {
            if (!isset($input[$f])) {
                $this->fail("$f is required", 422);
                return;
            }
        }

        $input['reason'] = $input['reason'] ?? $row['reason'] ?? null;
        $input['status'] = $input['status'] ?? $row['status'] ?? 'pending';

        $ok = $this->model->update($id, $input);
        $ok ? $this->ok(['updated' => true]) : $this->fail('Update failed', 400);
    }

    // حذف إجازة
    public function destroy(array $params): void {
        $id = (int)($params['id'] ?? 0);
        $row = $this->model->find($id);
        if (!$row) {
            $this->fail('Leave not found', 404);
            return;
        }

        $this->ok(['deleted' => $this->model->delete($id)]);
    }
}
