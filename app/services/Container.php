<?php
namespace app\services;

use app\controllers\AuthController;
use app\controllers\CardController;
use app\controllers\DeckController;
use app\controllers\HomeController;
use app\controllers\TestController;
use app\controllers\UserController;
use app\database\Database;
use app\middleware\AuthenticationMiddleware;
use app\services\AuthService;
use app\services\UserService;
use Exception;

class Container
{
    protected array $instances = [];
    protected array $services = [];
    private static ?Container $instance = null;

    private function __construct()
    {
        $this->services = [
            Database::class => function() {
                return new Database();
            },
            UserService::class => function($container) {
                return new UserService($container->get(Database::class));
            },
            SessionManager::class => function() {
                return new SessionManager();
            },
            AuthService::class => function($container) {
                return new AuthService($container->get(UserService::class), $container->get(SessionManager::class));
            },
            AuthenticationMiddleware::class => function($container) {
                return new AuthenticationMiddleware($container->get(AuthService::class));
            },
            AuthController::class => function($container) {
                return new AuthController($container->get(AuthService::class), $container->get('view'));
            },
            CardController::class=> function($container){
                return new CardController($container->get('view'), $container->get(SessionManager::class));
            },
            HomeController::class => function($container) {
                return new HomeController($container->get('view'));
            },
            TestController::class => function($container) {
                return new TestController($container->get('view'));
            },
            UserController::class => function($container) {
                return new UserController($container->get('view'), $container);
            },
            DeckService::class => function($container) {
                return new DeckService($container->get(Database::class));
            },
            DeckController::class => function($container) {
                return new DeckController($container->get(DeckService::class), $container->get('view'));
            },
        ];
    }

    public static function getInstance(): Container
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function set(string $abstract, $concrete = null)
    {
        if ($concrete === null) {
            $concrete = $abstract;
        }

        $this->instances[$abstract] = $concrete;
    }

    /**
     * @throws Exception
     */
    public function get($name)
    {
        if (!isset($this->instances[$name])) {
            if (isset($this->services[$name])) {
                $this->instances[$name] = $this->services[$name]($this);
            } else {
                throw new \Exception("Service $name not found");
            }
        }
        return $this->instances[$name];
    }

    public function has(string $abstract): bool
    {
        return isset($this->instances[$abstract]);
    }
}