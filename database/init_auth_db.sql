-- Création de la base de données Auth
CREATE DATABASE IF NOT EXISTS PHP_Rugby_Auth CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE PHP_Rugby_Auth;

-- Table des utilisateurs autorisés à manipuler les API
CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertion d'un utilisateur de test (mot de passe : "admin")
-- Hash généré via password_hash('admin', PASSWORD_DEFAULT)
INSERT INTO utilisateurs (username, password_hash, role) 
VALUES ('admin', '$2y$10$w8Pj4qU/A/Pof0V7K0TzB.2OOM.3f7VvC6y5V.JjT7I9g/zC3n3qW', 'admin')
ON DUPLICATE KEY UPDATE username=username;
