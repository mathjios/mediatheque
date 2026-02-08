<?php
namespace App\Core;

class Controller
{
    protected function basePath()
    {
        // Ex: SCRIPT_NAME = /mediatheque/public/index.php  => basePath = /mediatheque/public
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $base = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');
        return $base === '.' ? '' : $base;
    }

    protected function render($view, $data = [])
    {
        extract($data);
        $basePath = $this->basePath();

        // Output buffering pour capturer la vue
        ob_start();
        require_once __DIR__ . "/../../views/$view.php";
        $content = ob_get_clean();

        // Inclure le layout principal
        require_once __DIR__ . "/../../views/layout.php";
    }

    protected function redirect($url)
    {
        // Si on reçoit une URL absolue d'app (ex: /login), on la préfixe avec le basePath.
        if (is_string($url) && strpos($url, '/') === 0) {
            $url = $this->basePath() . $url;
        }
        header("Location: $url");
        exit;
    }

    protected function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function getPostConfig()
    {
        return $_POST;
    }

    // Auth Helpers
    protected function checkAuth()
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('/login');
        }
    }

    protected function isAdmin()
    {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    }
}
