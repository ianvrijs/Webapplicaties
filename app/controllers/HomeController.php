<?php

namespace app\controllers;

class HomeController extends BaseController {
    public function handle() {
        $this->setTitle('Home Page');
        $this->view->display(__ROOT__ . '/app/templates/nav.php');
        $this->view->display('pages/home.php');
        $this->view->display(__ROOT__ . '/app/templates/footer.php');


        $this->view->render();
    }
}