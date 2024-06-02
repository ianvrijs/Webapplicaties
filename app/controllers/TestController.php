<?php


namespace app\controllers;

class TestController extends BaseController
{
    public function handle($page)
    {
        $this->setTitle('Test Page');
        $this->view->display(__ROOT__ . '/app/templates/nav.php');
        $this->view->display(__ROOT__ . '/app/views/pages/test.php', ['page' => $page]);
        $this->view->display(__ROOT__ . '/app/templates/footer.php');
        $this->view->render();
    }
}