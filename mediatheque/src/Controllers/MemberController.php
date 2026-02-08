<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Core\Database;

class MemberController extends Controller
{

    public function index()
    {
        $this->checkAuth();
        if ($_SESSION['user']['role'] === 'member' || $_SESSION['user']['role'] === 'employee') {
            $this->redirect('/');
        }

        // Quick fetch via PDO standard approach since User model is simple right now
        // Or extend User model to have findAll
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->query("SELECT * FROM users ORDER BY nom, prenom");
        $members = $stmt->fetchAll();

        $this->render('members/index', ['members' => $members]);
    }

    public function add()
    {
        $this->checkAuth();
        if ($_SESSION['user']['role'] === 'member' || $_SESSION['user']['role'] === 'employee') {
            $this->redirect('/');
        }

        if ($this->isPost()) {
            $userModel = new User();
            if ($userModel->create($_POST)) {
                $this->redirect('/members');
            }
        }

        $this->render('members/form', ['action' => 'Ajouter']);
    }

    public function edit()
    {
        $this->checkAuth();
        // Seul l'admin peut éditer
        if (!$this->isAdmin()) {
            $this->redirect('/members');
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->redirect('/members');
        }

        $userModel = new User();
        $member = $userModel->findById($id);

        if (!$member) {
            $this->redirect('/members');
        }

        if ($this->isPost()) {
            if ($userModel->update($id, $_POST)) {
                $this->redirect('/members');
            }
        }

        $this->render('members/form', ['action' => 'Modifier', 'member' => $member]);
    }

    public function delete()
    {
        $this->checkAuth();
        // Seul l'admin peut supprimer
        if (!$this->isAdmin()) {
            $this->redirect('/members');
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            // Empêcher l'admin de se supprimer lui-même
            if ($id == $_SESSION['user']['id']) {
                $this->redirect('/members');
            }
            $userModel = new User();
            $userModel->delete($id);
        }
        $this->redirect('/members');
    }
}
