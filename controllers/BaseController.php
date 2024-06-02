<?php

namespace controllers;

use resources\views\View;

class BaseController {
    protected $view;

    public function __construct(View $view) {
        $this->view = $view;
    }
}