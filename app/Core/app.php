<?php
namespace App\Core;
use PDO;
use PDOException;


final class App
{
    private static ?PDO $pdo = null;

    public static function conn(): PDO
    {
        if (self::$pdo === null) {
            try {
                self::$pdo = new PDO(
                    'mysql:host=localhost;dbname=capstone4-mvc;charset=utf8',
                    'root',
                    '',
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    ]
                );
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$pdo;
    }

    // دالة db() يمكن تبقيها أو تحذفها إذا أحببت
    public static function db(): PDO
    {
        return self::conn();
    }
}


