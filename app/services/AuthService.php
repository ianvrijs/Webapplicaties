<?php

namespace app\services;

use app\database\models\User;

class AuthService
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login($usernameOrEmail, $password)
    {
        // Fetch the user from the database using the provided username or email
        $user = $this->userService->getUserByUsernameOrEmail($usernameOrEmail);

        // Verify the provided password with the user's hashed password
        if (password_verify($password, $user['password'])) {
            // Store the user's ID in the session to keep them logged in
            $_SESSION['user_id'] = $user['id'];
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
        // Remove the user's ID from the session to log them out
        unset($_SESSION['user_id']);
    }

    public function isLoggedIn()
    {
        // Check if the user's ID is stored in the session
        return isset($_SESSION['user_id']);
    }
}