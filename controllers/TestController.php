<?php


namespace controllers;

class TestController extends BaseController
{
    public function handle($page)
    {
        $this->view->display('pages/test.php', [__ROOT__ . '/resources/templates/nav.php'], [__ROOT__ . '/resources/templates/footer.php'], ['page' => $page]);
        return $this->view->getContent();
    }
}