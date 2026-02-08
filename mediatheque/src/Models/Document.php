<?php
namespace App\Models;

use App\Core\Database;

class Document
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function findAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM documents ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM documents WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function search($query)
    {
        $sql = "SELECT * FROM documents WHERE titre LIKE :query OR auteur LIKE :query ORDER BY titre ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['query' => "%$query%"]);
        return $stmt->fetchAll();
    }

    public function create($data)
    {
        $sql = "INSERT INTO documents (titre, auteur, type, image) VALUES (:titre, :auteur, :type, :image)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'titre' => $data['titre'],
            'auteur' => $data['auteur'],
            'type' => $data['type'],
            'image' => $data['image'] ?? null
        ]);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE documents SET titre = :titre, auteur = :auteur, type = :type, image = :image WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'titre' => $data['titre'],
            'auteur' => $data['auteur'],
            'type' => $data['type'],
            'image' => $data['image'] ?? null
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM documents WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function isAvailable($id)
    {
        // Un document est dispo s'il n'a pas d'emprunt en cours (date_retour_reel IS NULL)
        $sql = "SELECT COUNT(*) FROM emprunts WHERE document_id = :id AND date_retour_reel IS NULL";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $count = $stmt->fetchColumn();
        return $count == 0;
    }
}
