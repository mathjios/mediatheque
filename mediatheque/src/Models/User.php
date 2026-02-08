<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class User
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function findByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (email, password, nom, prenom, role) VALUES (:email, :password, :nom, :prenom, :role)");
        return $stmt->execute([
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'role' => $data['role'] ?? 'member'
        ]);
    }

    public function findById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function update($id, $data)
    {
        $sql = "UPDATE users SET email = :email, nom = :nom, prenom = :prenom, role = :role";
        $params = [
            'id' => $id,
            'email' => $data['email'],
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'role' => $data['role'] ?? 'member'
        ];

        // Si un nouveau mot de passe est fourni, on le met à jour
        if (!empty($data['password'])) {
            $sql .= ", password = :password";
            $params['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $sql .= " WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
