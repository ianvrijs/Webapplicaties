<?php

namespace requests;

interface Middleware
{
    public function handle(Request $request, Response $response);
}

