<?php

namespace app\middleware;

use app\requests\Request;
use app\requests\Response;

interface Middleware
{
    public function handle(Request $request, Response $response );
}

