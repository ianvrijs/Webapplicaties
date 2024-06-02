<?php

namespace controllers;

class UserController extends BaseController {
    public function handle($userId) {
        $this->view->display('pages/user.php', [__ROOT__ . '/resources/templates/nav.php'], [__ROOT__ . '/resources/templates/footer.php'], ['userId' => $userId]);
        return $this->view->getContent();
    }
}