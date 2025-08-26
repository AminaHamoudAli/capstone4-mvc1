<?php
namespace App\Models;

use App\Core\app;
use PDO;


class Leave {
    private PDO $db;

    public function __construct() {
        $this->db = app::conn();
    }

    // جلب كل الإجازات
    public function all(): array {
        $st = $this->db->query('SELECT * FROM leaves ORDER BY id DESC');
        return $st->fetchAll();
    }

    // جلب إجازة محددة
    public function find(int $id): ?array {
        $st = $this->db->prepare('SELECT * FROM leaves WHERE id=? LIMIT 1');
        $st->execute([$id]);
        $r = $st->fetch();
        return $r ?: null;
    }

    // إنشاء إجازة جديدة
    public function create(array $d): int {
        $st = $this->db->prepare(
            'INSERT INTO leaves (employee_id, start_date, end_date, reason, status) VALUES (?,?,?,?,?)'
        );
        $st->execute([
            $d['employee_id'],
            $d['start_date'],
            $d['end_date'],
            $d['reason'],
            $d['status']
        ]);
        return (int)$this->db->lastInsertId();
    }

    // تعديل إجازة موجودة
    public function update(int $id, array $d): bool {
        $st = $this->db->prepare(
            'UPDATE leaves SET employee_id=?, start_date=?, end_date=?, reason=?, status=? WHERE id=?'
        );
        return $st->execute([
            $d['employee_id'],
            $d['start_date'],
            $d['end_date'],
            $d['reason'],
            $d['status'],
            $id
        ]);
    }

    // حذف إجازة
    public function delete(int $id): bool {
        $st = $this->db->prepare('DELETE FROM leaves WHERE id=?');
        return $st->execute([$id]);
    }
}
