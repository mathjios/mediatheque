-- Script de création de la base de données Médiathèque

-- Création de la base si elle n'existe pas
CREATE DATABASE IF NOT EXISTS mediatheque CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mediatheque;

-- Désactivation des vérifications de clés étrangères temporairement
SET FOREIGN_KEY_CHECKS = 0;

-- Suppression des tables existantes pour repartir à zéro
DROP TABLE IF EXISTS emprunts;
DROP TABLE IF EXISTS documents;
DROP TABLE IF EXISTS users;

-- Table des utilisateurs (Admin, Bibliothécaire, Adhérent)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    role ENUM('admin', 'employee', 'member') NOT NULL DEFAULT 'member',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Table des documents
CREATE TABLE documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    auteur VARCHAR(100) NOT NULL,
    type ENUM('Livre', 'CD', 'DVD') NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Table des emprunts
CREATE TABLE emprunts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    document_id INT NOT NULL,
    date_emprunt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_retour_prevu DATETIME NOT NULL,
    date_retour_reel DATETIME DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (document_id) REFERENCES documents(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Réactivation des clés étrangères
SET FOREIGN_KEY_CHECKS = 1;

-- ==========================================
-- JEU DE DONNÉES DE TEST (SEED)
-- ==========================================

-- Mots de passe hashés (tous sont 'password123' pour le test)
-- Hash généré via password_hash('password123', PASSWORD_DEFAULT)
-- Exemple simplifié, en prod utiliser l'app pour générer

INSERT INTO users (email, password, nom, prenom, role) VALUES 
('admin@mediatheque.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', 'Super', 'admin'),
('biblio@mediatheque.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Librarian', 'Marie', 'employee'),
('membre@mediatheque.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Dupont', 'Jean', 'member');

INSERT INTO documents (titre, auteur, type) VALUES 
('Les Misérables', 'Victor Hugo', 'Livre'),
('1984', 'George Orwell', 'Livre'),
('Thriller', 'Michael Jackson', 'CD'),
('Inception', 'Christopher Nolan', 'DVD'),
('Le Petit Prince', 'Antoine de Saint-Exupéry', 'Livre');

-- Un emprunt en cours (membre a emprunté 1984)
INSERT INTO emprunts (user_id, document_id, date_emprunt, date_retour_prevu) VALUES 
(3, 2, NOW(), DATE_ADD(NOW(), INTERVAL 14 DAY));
