<?php

namespace app\requests;

interface Middleware
{
    public function handle(Request $request, Response $response);
}

