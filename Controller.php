<?php

namespace App\core;

use App\core;
use App\core\Application;
use App\core\middlewares\BaseMiddleware;

class Controller
{
    public string $layout = 'main';
    public string $action = ''; 
    // Array of Middleware classes
    protected array $middlewares = []; 

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function render($view, $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware; 
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}