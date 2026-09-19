# 📚 Application Web de Gestion de Médiathèque

Bienvenue sur le projet **Application Web de Gestion de Médiathèque**.

Cette application a été réalisée dans le cadre du **BTS SIO – option SLAM**.  
Elle permet de gérer une médiathèque à travers une interface web et une base de données.

---

## 🎯 Objectif du projet

L'objectif de cette application est de permettre à une médiathèque de gérer facilement :

- 📚 Les documents culturels
- 👤 Les adhérents
- 📖 Les emprunts
- 🔄 Les retours
- 🗄️ Les données de la médiathèque
- 🔎 La recherche et la consultation des documents

L'application permet ainsi de centraliser les informations et de simplifier la gestion des emprunts.

---

## 🛠️ Technologies utilisées

### 💻 Développement

- PHP
- HTML5
- CSS3
- JavaScript

### 🗄️ Base de données

- MySQL
- SQL
- phpMyAdmin

### 🔧 Environnement

- XAMPP
- Apache
- Visual Studio Code
- Git
- GitHub

### 📐 Modélisation

- UML
- MCD – Modèle Conceptuel de Données
- MLD – Modèle Logique de Données

---

## 📚 Fonctionnalités

### 👤 Gestion des adhérents

L'application permet de :

- Ajouter un adhérent
- Consulter les adhérents
- Modifier les informations d'un adhérent
- Supprimer un adhérent
- Rechercher un adhérent

---

### 📖 Gestion des documents

La médiathèque peut gérer différents types de documents :

- 📕 Livres
- 💿 CD
- 📀 DVD

Pour chaque document, différentes informations peuvent être enregistrées.

Les fonctionnalités comprennent notamment :

- Ajouter un document
- Consulter un document
- Modifier un document
- Supprimer un document
- Rechercher un document

---

### 🔄 Gestion des emprunts

L'application permet de gérer les emprunts effectués par les adhérents.

Il est notamment possible de :

- Enregistrer un emprunt
- Associer un document à un adhérent
- Enregistrer la date d'emprunt
- Enregistrer la date prévue de retour
- Consulter les emprunts en cours

---

### ↩️ Gestion des retours

L'application permet également de gérer le retour des documents.

Les informations concernant les retours permettent de suivre l'état des emprunts et de connaître les documents actuellement disponibles.

---

## 🗄️ Base de données

La base de données MySQL permet de stocker les informations nécessaires au fonctionnement de l'application.

Les principales données concernent :

```text
Adhérents
    │
    │ effectuent
    ▼
Emprunts
    │
    │ concernent
    ▼
Documents
    │
    ├── Livres
    ├── CD
    └── DVD
