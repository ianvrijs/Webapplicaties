<?php

namespace app\services;

use app\database\models\User;

class AuthService
{
    private UserService $userService;
    private SessionManager $sessionManager;

    public function __construct(UserService $userService, SessionManager $sessionManager)
    {
        $this->userService = $userService;
        $this->sessionManager = $sessionManager;
    }

    public function login($usernameOrEmail, $password)
    {
        $user = $this->userService->getUserByUsernameOrEmail($usernameOrEmail);
        if (password_verify($password, $user['password'])) {
            $this->sessionManager->set('user_id', $user['id']);
            return true;
        }

        return false;
    }

    public function register($username, $email, $password)
    {
        return $this->userService->createUser($username, $email, $password);
    }

    public function logout()
    {
        $this->sessionManager->remove('user_id');
    }

    public function isLoggedIn()
    {
        return $this->sessionManager->exists('user_id');
    }
}