<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller
{
    public function loginForm()
    {
        if (isset($_SESSION['user'])) {
            $this->redirect('/');
        }
        $this->render('auth/login');
    }

    public function login()
    {
        if (!$this->isPost()) {
            $this->redirect('/login');
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            // Connexion réussie
            $_SESSION['user'] = [
                'id' => $user['id'],
                'email' => $user['email'],
                'nom' => $user['nom'],
                'prenom' => $user['prenom'],
                'role' => $user['role']
            ];
            $this->redirect('/');
        } else {
            // Echec
            $this->render('auth/login', [
                'error' => 'Identifiants incorrects',
                'email' => $email
            ]);
        }
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('/login');
    }

    public function registerForm()
    {
        if (isset($_SESSION['user'])) {
            $this->redirect('/');
        }
        $this->render('auth/register');
    }

    public function register()
    {
        if (!$this->isPost()) {
            $this->redirect('/register');
        }

        $nom = trim($_POST['nom'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';

        $errors = [];

        if ($nom === '' || $prenom === '' || $email === '' || $password === '' || $passwordConfirm === '') {
            $errors[] = 'Tous les champs sont obligatoires.';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email invalide.';
        }

        if ($password !== $passwordConfirm) {
            $errors[] = 'Les mots de passe ne correspondent pas.';
        }

        if (strlen($password) < 6) {
            $errors[] = 'Le mot de passe doit contenir au moins 6 caractères.';
        }

        $userModel = new User();
        if (empty($errors) && $userModel->findByEmail($email)) {
            $errors[] = 'Un compte existe déjà avec cet email.';
        }

        if (!empty($errors)) {
            $this->render('auth/register', [
                'errors' => $errors,
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
            ]);
            return;
        }

        $created = $userModel->create([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'password' => $password,
            'role' => 'member',
        ]);

        if (!$created) {
            $this->render('auth/register', [
                'errors' => ['Une erreur est survenue lors de la création du compte.'],
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
            ]);
            return;
        }

        // Auto-login après inscription
        $user = $userModel->findByEmail($email);
        if ($user) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'email' => $user['email'],
                'nom' => $user['nom'],
                'prenom' => $user['prenom'],
                'role' => $user['role']
            ];
        }

        $this->redirect('/');
    }
}
