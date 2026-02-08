<?php
namespace App\Core;

class Router
{
    private $routes = [];

    public function add($method, $path, $controller, $action)
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function dispatch($uri, $method)
    {
        $uri = parse_url($uri, PHP_URL_PATH);
        // Retirer le dossier racine si l'app est dans un sous-dossier (ex: /mediatheque/public/...)
        // Pour faire simple, on va assumer que le RewriteRule gère l'index.php
        // On nettoie l'URI si nécessaire.

        // Simplification: on match l'URI exacte ou des patterns simples
        foreach ($this->routes as $route) {
            if ($route['path'] === $uri && $route['method'] === $method) {
                $controllerName = "App\\Controllers\\" . $route['controller'];
                $controller = new $controllerName();
                $action = $route['action'];
                $controller->$action();
                return;
            }
        }

        // 404
        http_response_code(404);
        echo "404 Not Found - URI: $uri";
    }
}
