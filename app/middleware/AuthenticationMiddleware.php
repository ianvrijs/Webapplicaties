<?php

namespace app\middleware;

use app\requests\Request;
use app\requests\Response;
use app\services\AuthService;

class AuthenticationMiddleware implements Middleware
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function handle(Request $request, Response $response)
    {
        if (!$this->authService->isLoggedIn()) {
            header('Location: /login');
            exit;
        }

        return $response;
    }
}