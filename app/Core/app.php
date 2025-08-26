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


// namespace App\Core;

// use PDO;
// use PDOException;

// final class App
// {
//     private static ?PDO $pdo = null;

//     public static function conn(): void
//     {
//         if (self::$pdo === null) {
//             try {
//                 self::$pdo = new PDO(
//                     'mysql:host=localhost;dbname=capstone4-mvc;charset=utf8',
//                     'root',
//                     '',
//                     [
//                         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//                         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//                     ]
//                 );
//             } catch (PDOException $e) {
//                 die("Database connection failed: " . $e->getMessage());
//             }
//         }
//     }

//     public static function db(): PDO
//     {
//         if (self::$pdo === null) {
//             self::conn();
//         }

//         return self::$pdo;
//     }
// }

// namespace App\Core;

// use PDO;

// class App {
//     private static ?PDO $pdo = null;

//     public static function conn(): PDO {
//         if (self::$pdo === null) {
//             $host = 'localhost';
//             $db   = 'capstone4-mvc';
//             $user = 'root';
//             $pass = '';
//             $charset = 'utf8mb4';

//             $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
//             self::$pdo = new PDO($dsn, $user, $pass);
//             self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         }
//         return self::$pdo;
//     }
// }


