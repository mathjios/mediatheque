# Application Web de Gestion de Médiathèque

Application développée dans le cadre du BTS SIO SLAM.

## Prérequis
- Serveur Web (Apache ou Nginx)
- PHP 8.x
- MySQL / MariaDB
- Extension PDO PHP activée

## Installation

1. **Base de données**
   - Importer le fichier `database.sql` situé à la racine du projet dans votre SGBD (ex: via phpMyAdmin).
   - Ce script crée la base `mediatheque` et insère des données de test.

2. **Configuration**
   - Ouvrir le fichier `config/database.php`.
   - Modifier les identifiants si nécessaire (par défaut : `root` / sans mot de passe).

3. **Lancement**
   - Placer le dossier `mediatheque` dans le répertoire web de votre serveur (htdocs/www).
   - Accéder à l'application via `http://localhost/mediatheque/public/`.
   - **Note** : Le point d'entrée est le dossier `public/`.

## Comptes de Test

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| **Administrateur** | `admin@mediatheque.fr` | `password123` |
| **Bibliothécaire** | `biblio@mediatheque.fr` | `password123` |
| **Adhérent** | `membre@mediatheque.fr` | `password123` |

## Fonctionnalités Implémentées

- Authentification (Login / Logout)
- Gestion des Documents (Liste, Recherche, Ajout, Suppression)
- Gestion des Adhérents (Liste, Ajout)
- Gestion des Emprunts (Emprunter, Retourner, Historique Personnel)
- Sécurité (Hashage MDP, Sessions, Rôles)

## Architecture

Le projet suit une architecture MVC simple :
- `src/Core` : Noyau (Routeur, Base de données, Controlleur de base)
- `src/Controllers` : Logique métier
- `src/Models` : Accès aux données
- `views` : Templates HTML
- `public` : Point d'entrée (index.php, css)
