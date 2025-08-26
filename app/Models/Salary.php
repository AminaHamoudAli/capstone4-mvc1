<?php
namespace App\Models;

use App\Core\app;
use PDO;

class Salary {
    private PDO $db;

    public function __construct() {
        $this->db = app::conn();
    }

    // جلب كل الرواتب أو رواتب موظف محدد
    public function all(?int $employeeId = null): array {
        if ($employeeId) {
            $st = $this->db->prepare('SELECT * FROM salaries WHERE employee_id=? ORDER BY id DESC');
            $st->execute([$employeeId]);
            return $st->fetchAll();
        }
        $st = $this->db->query('SELECT * FROM salaries ORDER BY id DESC');
        return $st->fetchAll();
    }
        // إضافات بسيطة
        public function getAll(): array {
            return $this->all();
        }

        public function getByEmployee(int $id): array {
            return $this->all($id);
        }

    // جلب راتب محدد
    public function find(int $id): ?array {
        $st = $this->db->prepare('SELECT * FROM salaries WHERE id=? LIMIT 1');
        $st->execute([$id]);
        $r = $st->fetch();
        return $r ?: null;
    }

    // إنشاء راتب جديد
    public function create(array $d): int {
        $st = $this->db->prepare('INSERT INTO salaries (employee_id,bonus_percent,deduction_percent) VALUES (?,?,?)');
        $st->execute([$d['employee_id'], $d['bonus_percent'], $d['deduction_percent']]);
        return (int)$this->db->lastInsertId();
    }

    // تحديث راتب موجود
    public function update(int $id, array $d): bool {
        $st = $this->db->prepare('UPDATE salaries SET employee_id=?, bonus_percent=?, deduction_percent=? WHERE id=?');
        return $st->execute([$d['employee_id'], $d['bonus_percent'], $d['deduction_percent'], $id]);
    }

    // حذف راتب
    public function delete(int $id): bool {
        $st = $this->db->prepare('DELETE FROM salaries WHERE id=?');
        return $st->execute([$id]);
    }
}
