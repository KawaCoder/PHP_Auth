<?php
// PHP_Auth/config/env.php
// Variables d'environnement pour l'API d'Authentification

// -- BASE DE DONNÉES AUTH (AlwaysData) --
define('DB_HOST_AUTH', '127.0.0.1');
define('DB_NAME_AUTH', 'PHP_Rugby_Auth');
define('DB_USER_AUTH', 'root');
define('DB_PASSWORD_AUTH', '');

// Clé secrète pour générer et déchiffrer les Jetons de connexion
define('JWT_SECRET', 'MON_SUPER_SECRET_POUR_LE_PROJET_R401_WxyZ123!_Rugby');
?>
