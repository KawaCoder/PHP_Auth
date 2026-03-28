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
                $server = '127.0.0.1';
                $db = 'PHP_Rugby_Auth'; // Base de données distincte !
                $login = 'root';
                $mdp = '';

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
