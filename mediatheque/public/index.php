<?php
session_start();

// Autoloader simple (PSR-4 style pour le dossier src)
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../src/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Initialiser le routeur
use App\Core\Router;

$router = new Router();

// --- DEFINITION DES ROUTES ---

// Accueil
$router->add('GET', '/', 'HomeController', 'index');
$router->add('GET', '/home', 'HomeController', 'index');

// Auth
$router->add('GET', '/login', 'AuthController', 'loginForm');
$router->add('POST', '/login', 'AuthController', 'login');
$router->add('GET', '/logout', 'AuthController', 'logout');
// Inscription
$router->add('GET', '/register', 'AuthController', 'registerForm');
$router->add('POST', '/register', 'AuthController', 'register');

// Documents
$router->add('GET', '/documents', 'DocumentController', 'index');
$router->add('GET', '/documents/add', 'DocumentController', 'add');
$router->add('POST', '/documents/add', 'DocumentController', 'add');
$router->add('GET', '/documents/delete', 'DocumentController', 'delete');

// Members
$router->add('GET', '/members', 'MemberController', 'index');
$router->add('GET', '/members/add', 'MemberController', 'add');
$router->add('POST', '/members/add', 'MemberController', 'add');
$router->add('GET', '/members/edit', 'MemberController', 'edit');
$router->add('POST', '/members/edit', 'MemberController', 'edit');
$router->add('GET', '/members/delete', 'MemberController', 'delete');

// Loans
$router->add('GET', '/loans', 'LoanController', 'index');
$router->add('POST', '/loans/create', 'LoanController', 'create');
$router->add('GET', '/loans/return', 'LoanController', 'returnDoc');
$router->add('GET', '/my-loans', 'LoanController', 'myLoans');

// Dispatch
// Nettoyage de l'URI pour retirer le script name si présent (fix pour certains setups XAMPP)
$requestUri = $_SERVER['REQUEST_URI'];
$scriptName = $_SERVER['SCRIPT_NAME'];
$dirName = dirname($scriptName);

if (strpos($requestUri, $scriptName) === 0) {
    $requestUri = substr($requestUri, strlen($scriptName));
} elseif (strpos($requestUri, $dirName) === 0) {
    $requestUri = substr($requestUri, strlen($dirName));
}
if ($requestUri === '')
    $requestUri = '/';

$router->dispatch($requestUri, $_SERVER['REQUEST_METHOD']);
