<?php

namespace too\phpmvc;

use too\phpmvc\Response;
use App\controllers\AuthController;
use too\phpmvc\Application;
use too\phpmvc\Controller;
use too\phpmvc\exception\Forbiddenexception;
use too\phpmvc\exception\NotFoundException;

class Router
{
    public Request $request; 
    public Response $response;
    protected array $routes = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve() 
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            throw new NotFoundException() ; 
        }
        if (is_string($callback)) {
            return Application::$app->view->renderView($callback);
        }
        if (is_array($callback)) {
            //controller variable is an instance of controller class
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;

            foreach ($controller->getMiddlewares() as $middleware) {
                $middleware->execute();
            }
        }
        return call_user_func($callback, $this->request, $this->response);
        // echo '<pre>';
        // var_dump($callback);
        // echo '</pre>';
        // exit;
    }
    


}