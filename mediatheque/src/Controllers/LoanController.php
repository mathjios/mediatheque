<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Loan;
use App\Models\User;
use App\Models\Document;
use App\Core\Database;

class LoanController extends Controller
{

    public function index()
    {
        $this->checkAuth();
        if ($_SESSION['user']['role'] === 'member' || $_SESSION['user']['role'] === 'employee') {
            $this->redirect('/my-loans');
        }

        $loanModel = new Loan();
        $loans = $loanModel->getActiveLoans();

        // Pour le formulaire d'ajout rapide
        $docModel = new Document();
        $docs = $docModel->findAll();
        
        // Vérifier la disponibilité pour chaque document
        foreach ($docs as &$doc) {
            $doc['disponible'] = $docModel->isAvailable($doc['id']);
        }

        // Quick fetch members
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->query("SELECT * FROM users WHERE role = 'member' ORDER BY nom");
        $members = $stmt->fetchAll();

        $this->render('loans/index', [
            'loans' => $loans,
            'members' => $members,
            'docs' => $docs
        ]);
    }

    public function create()
    {
        $this->checkAuth();
        if ($_SESSION['user']['role'] === 'member' || $_SESSION['user']['role'] === 'employee') {
            $this->redirect('/');
        }

        if ($this->isPost()) {
            $userId = $_POST['user_id'] ?? null;
            $docId = $_POST['document_id'] ?? null;

            if ($userId && $docId) {
                $loanModel = new Loan();
                if ($loanModel->create($userId, $docId)) {
                    // Success message handling to be added
                } else {
                    // Error handling
                }
            }
        }
        $this->redirect('/loans');
    }

    public function returnDoc()
    {
        $this->checkAuth();
        if ($_SESSION['user']['role'] === 'member' || $_SESSION['user']['role'] === 'employee') {
            $this->redirect('/');
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            $loanModel = new Loan();
            $loanModel->returnDocument($id);
        }
        $this->redirect('/loans');
    }

    public function myLoans()
    {
        $this->checkAuth();
        $loanModel = new Loan();
        $history = $loanModel->getUserHistory($_SESSION['user']['id']);

        $this->render('loans/my_loans', ['history' => $history]);
    }
}
