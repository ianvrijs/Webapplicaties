<?php

namespace app\controllers;

class UserController extends BaseController {
    public function handle($userId) {
        $this->setTitle('User Page');
        $this->view->display(__ROOT__ . '/app/templates/nav.php');
        $this->view->display(__ROOT__ . '/app/views/pages/user.php', ['userId' => $userId]);
        $this->view->display(__ROOT__ . '/app/templates/footer.php');
        $this->view->render();
    }

}