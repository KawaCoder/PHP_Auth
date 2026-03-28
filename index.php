<?php
// API d'Authentification (Génère le Jeton JWT)
namespace App\API;

require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/utils/JWT.php';

use App\Config\Database;
use App\Utils\JWT;
use PDO;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// On s'attend à recevoir { "username": "...", "password": "..." }
$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON, true);

$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

if (empty($username) || empty($password)) {
    http_response_code(400);
    echo json_encode(['error' => 'Identifiants requis.']);
    exit;
}

// Vérification en base de données Auth
$pdo = Database::getConnection();
$stmt = $pdo->prepare('SELECT id, username, password_hash, role FROM utilisateurs WHERE username = :username');
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || !password_verify($password, $user['password_hash'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Identifiants invalides.']);
    exit;
}

// Génération du Jeton (Token) valide pendant 1 heure
$payload = [
    'id' => $user['id'],
    'username' => $user['username'],
    'role' => $user['role']
];

$token = JWT::encode($payload, 3600); // 1 heure

http_response_code(200);
echo json_encode([
    'message' => 'Authentification réussie.',
    'token' => $token
]);
?>
