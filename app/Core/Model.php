<?php
namespace App\Core;

use PDO;
use PDOException;

class Model {

    protected $db;

    public function __construct() {
        try {
            $this->db = new PDO("mysql:host=localhost;dbname=capstone4-mvc;charset=utf8", "root", "");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("DB Connection failed: " . $e->getMessage());
        }
    }

    protected function query($sql) {
        $result = $this->db->query($sql);
        if ($result === false) {
            $errorInfo = $this->db->errorInfo();
            die("SQL Error: " . $errorInfo[2]);
        }
        return $result;
    }
}
