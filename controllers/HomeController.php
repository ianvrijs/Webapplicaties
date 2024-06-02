<?php

namespace controllers;

class HomeController extends BaseController {
    public function handle() {
        $this->view->display(__ROOT__ . '/resources/templates/nav.php');
        $this->view->display('pages/home.php');
        $this->view->display(__ROOT__ . '/resources/templates/footer.php');
        return $this->view->getContent();
    }
}