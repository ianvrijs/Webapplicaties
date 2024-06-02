<?php
namespace app\views;

use AllowDynamicProperties;

#[AllowDynamicProperties]
class View{
    private string $content;
    private string $title;
    private array $stylesheets;

    public function __construct($viewLoader){
        $this->viewLoader = $viewLoader;
        $this->content = '';
        $this->title = '';
        $this->stylesheets = [];
    }

    public function display($viewName, $data = []): void
    {
        $this->stylesheets = $this->viewLoader->getAllStylesheets();

        $this->addContent($this->viewLoader->load($viewName, $data, $this->stylesheets));
    }

    public function render(): void
    {
        echo "<!DOCTYPE html>\n<html>\n<head>\n<title>{$this->title}</title>\n";
        foreach ($this->stylesheets as $stylesheet) {
            echo "<link rel='stylesheet' type='text/css' href='{$stylesheet}'>\n";
        }
        echo "</head>\n<body>\n";
        echo $this->content;
        echo "</body>\n</html>";
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function addContent(string $content): void
    {
        $this->content .= $content;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}