<?php

namespace app\controllers;

use app\services\AuthService;
use app\requests\Request;
use app\views\View;
use JetBrains\PhpStorm\NoReturn;

class AuthController extends BaseController
{
    private AuthService $authService;

    public function __construct(AuthService $authService, View $view)
    {
        parent::__construct($view);
        $this->authService = $authService;
    }

    public function showLoginForm(): void
    {
        $this->setTitle('Login Page');
        $this->view->display(__ROOT__ . '/app/templates/nav.php');
        $this->view->display(__ROOT__ . '/app/views/pages/login-form.php');
        $this->view->display(__ROOT__ . '/app/templates/footer.php');
        $this->view->render();
    }

    public function showRegistrationForm(): void
    {
        $this->setTitle('Registration Page');
        $this->view->display(__ROOT__ . '/app/templates/nav.php');
        $this->view->display(__ROOT__ . '/app/views/pages/register-form.php');
        $this->view->display(__ROOT__ . '/app/templates/footer.php');
        $this->view->render();
    }

    public function login(Request $request): void
    {
        $usernameOrEmail = $request->get('usernameOrEmail');
        $password = $request->get('password');

        if ($this->authService->login($usernameOrEmail, $password)) {
            header('Location: /');
            exit;
        } else {
            echo 'Invalid username or password.';
        }
    }

    public function register(Request $request): void
    {
        $username = $request->get('username');
        $email = $request->get('email');
        $password = $request->get('password');

        if ($this->authService->register($username, $email, $password)) {
            header('Location: /login');
            exit;
        } else {
            echo 'Registration failed.';
        }
    }

    #[NoReturn] public function logout(): void
    {
        $this->authService->logout();
        header('Location: /login');
        exit;
    }
}