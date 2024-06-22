<?php

namespace app\middleware;

use app\requests\Request;
use app\requests\Response;

class MiddlewareStack
{
    private $middlewares = [];

    public function add(Middleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    public function handle(Request $request, Response $response)
    {
        foreach ($this->middlewares as $middleware) {
            $middleware->handle($request, $response);
        }
    }
}