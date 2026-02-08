<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Document;

class DocumentController extends Controller
{

    public function index()
    {
        $documentModel = new Document();

        $query = $_GET['q'] ?? null;
        if ($query) {
            $documents = $documentModel->search($query);
        } else {
            $documents = $documentModel->findAll();
        }

        // Vérifier la disponibilité pour chaque doc
        foreach ($documents as &$doc) {
            $doc['disponible'] = $documentModel->isAvailable($doc['id']);
        }

        $this->render('documents/index', [
            'documents' => $documents,
            'query' => $query
        ]);
    }

    public function add()
    {
        $this->checkAuth();
        if ($_SESSION['user']['role'] === 'member' || $_SESSION['user']['role'] === 'employee') {
            $this->redirect('/documents');
        }

        if ($this->isPost()) {
            $data = $_POST;
            // Gestion upload image simplifiée
            $data['image'] = null; // A implémenter si besoin

            $model = new Document();
            if ($model->create($data)) {
                $this->redirect('/documents');
            }
        }

        $this->render('documents/form', ['action' => 'Ajouter']);
    }

    public function delete()
    {
        $this->checkAuth();
        // Seul l'admin peut supprimer
        if ($_SESSION['user']['role'] === 'member' || $_SESSION['user']['role'] === 'employee') {
            $this->redirect('/documents');
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            $model = new Document();
            $model->delete($id);
        }
        $this->redirect('/documents');
    }
}
