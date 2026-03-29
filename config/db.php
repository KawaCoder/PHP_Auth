<?php
namespace App\Config;

use PDO;
use Exception;

class Database
{
    private static ?PDO $pdo = null;

    private function __construct() {}
    private function __clone() {}
    public function __wakeup() {}

    public static function getConnection(): PDO
    {
        if (self::$pdo === null) {
            try {
                require_once __DIR__ . '/env.php';

                $server = DB_HOST_AUTH;
                $db = DB_NAME_AUTH; 
                $login = DB_USER_AUTH;
                $mdp = DB_PASSWORD_AUTH;

                self::$pdo = new PDO("mysql:host=$server;dbname=$db;charset=utf8", $login, $mdp);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
                die(json_encode(['error' => 'Erreur de connexion à la BDD Auth : ' . $e->getMessage()]));
            }
        }

        return self::$pdo;
    }
}
?>
