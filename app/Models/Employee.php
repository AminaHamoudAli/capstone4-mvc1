<?php

namespace App\Models;

use App\Core\App;
use PDO;


class Employee {
    private PDO $db;

    public function __construct() {
        $this->db = App::conn();
    }

    //  كل الموظفين
    public function all(): array {
        $st = $this->db->query('SELECT * FROM employees ORDER BY id DESC');
        return $st->fetchAll();
    }

   
    public function find(int $id): ?array {
        $st = $this->db->prepare('SELECT * FROM employees WHERE id=? LIMIT 1');
        $st->execute([$id]);
        $r = $st->fetch();
        return $r ?: null;
    }

    public function create(array $data): int {
        $st = $this->db->prepare(
            'INSERT INTO employees (name, email, salary, department, contract, evaluation) VALUES (?,?,?,?,?,?)'
        );
        $st->execute([
            $data['name'],
            $data['email'],
            $data['salary'],
            $data['department'],
            $data['contract'],
            $data['evaluation']
        ]);
        return (int)$this->db->lastInsertId();
    }

    // تعديل موظف موجود
    public function update(int $id, array $data): bool {
        $st = $this->db->prepare(
            'UPDATE employees SET name=?, email=?, salary=?, department=?, contract=?, evaluation=? WHERE id=?'
        );
        return $st->execute([
            $data['name'],
            $data['email'],
            $data['salary'],
            $data['department'],
            $data['contract'],
            $data['evaluation'],
            $id
        ]);
    }

    // حذف موظف
    public function delete(int $id): bool {
        $st = $this->db->prepare('DELETE FROM employees WHERE id=?');
        return $st->execute([$id]);
    }
}





