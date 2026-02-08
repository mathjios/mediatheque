<?php
namespace App\Models;

use App\Core\Database;

class Loan
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function getActiveLoans()
    {
        $sql = "SELECT e.*, u.nom, u.prenom, d.titre 
                FROM emprunts e
                JOIN users u ON e.user_id = u.id
                JOIN documents d ON e.document_id = d.id
                WHERE e.date_retour_reel IS NULL
                ORDER BY e.date_emprunt DESC";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function getUserHistory($userId)
    {
        $sql = "SELECT e.*, d.titre, d.auteur
                FROM emprunts e
                JOIN documents d ON e.document_id = d.id
                WHERE e.user_id = :userId
                ORDER BY e.date_emprunt DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll();
    }

    public function create($userId, $documentId)
    {
        // Vérifier disponibilité
        $docModel = new Document();
        if (!$docModel->isAvailable($documentId)) {
            return false;
        }

        // Créer l'emprunt (pour 14 jours)
        $sql = "INSERT INTO emprunts (user_id, document_id, date_retour_prevu) VALUES (:uid, :did, DATE_ADD(NOW(), INTERVAL 14 DAY))";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'uid' => $userId,
            'did' => $documentId
        ]);
    }

    public function returnDocument($loanId)
    {
        $sql = "UPDATE emprunts SET date_retour_reel = NOW() WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $loanId]);
    }
}
