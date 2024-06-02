<?php

namespace app\controllers;

use app\views\View;

class BaseController {
    protected $view;

    public function __construct(View $view) {
        $this->view = $view;
    }
    public function setTitle($title): void
    {
        $this->view->setTitle($title);
    }
}