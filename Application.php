<?php 

namespace App\core;

use App\core\Database;
use App\core\db\Database as DbDatabase;
use App\core\db\DbModel as DbDbModel;
use app\core\DbModel;
use LDAP\Result;
use App\core\Response;
use App\core\Session;
use App\models\User;

class Application
{
    public static string $ROOT_DIR;

    public string $layout = 'main';
    public string $userClass;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public DbDatabase $db;
    public ?UserModel $user;
    public View $view;
    public static Application $app;

    public ?Controller $controller = null;
    public function __construct($rootPath, array $config)
    {
        // print_r($config['userClass']);
        // return;
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->view = new View();

        $this->db = new DbDatabase($config['db']);

        $primaryValue = $this->session->get('user');
        if ($primaryValue) {
            // $primaryKey = $this->userClass::primaryKey();
            // $this->user = $this->userClass::findOne([$primaryKey => $primaryValue ]); 
            $primaryKey = (new $this->userClass)->primaryKey();
            $this->user = (new $this->userClass)->findOne([$primaryKey => $primaryValue ]); 
        } 
        else {
            $this->user = null;
        }

    }
    public static function isGuest()
    {
        return !self::$app->user;
    }

    public function run()
    {
        try{
            echo $this->router->resolve();
        } catch (\Exception $e) {
            $this->response->setStatusCode($e->getCode());    
            echo $this->view->renderView('_error', [
                'exception' => $e
            ]);
        }
    }

    // public function run()
    // {
    //     echo $this->router->resolve();
    // }

    public function getController() 
    {
        return $this->controller;
    }

    public function setController(\app\core\Controller $controller): void
    { 
        $this->controller = $controller;
    }

    public function login(UserModel  $user)
    {
         $this->user = $user;
         $primaryKey = $user->primaryKey();
         $primaryValue = $user->{$primaryKey};
         $this->session->set('user', $primaryValue);
         return true; 
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }
}

?>