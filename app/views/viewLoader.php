<?php
namespace app\views;
use AllowDynamicProperties;

#[AllowDynamicProperties]
class ViewLoader{

    public function __construct($path){
        $this->path = $path;
    }

    public function getAllStylesheets($directory = '/public/src/style/') {
        $stylesheets = glob($_SERVER['DOCUMENT_ROOT'] . $directory . '*.css');
        $stylesheets = array_map(function($stylesheet) {
            return str_replace($_SERVER['DOCUMENT_ROOT'], '', $stylesheet);
        }, $stylesheets);
        return $stylesheets;
    }

    public function loadStylesheets($stylesheets = []) {
        $links = [];
        foreach ($stylesheets as $stylesheet) {
            $links[] = '<link rel="stylesheet" type="text/css" href="' . $stylesheet . '">';
        }
        return $links;
    }

    public function load($viewName, $data = [], $stylesheets = []) {
        $stylesheets = $this->getAllStylesheets();
        $data['stylesheets'] = $this->loadStylesheets($stylesheets);
        extract($data);
        ob_start();
        require $viewName;
        $content = ob_get_clean();
        return $content;
    }
}