<?php
namespace resources\views;

use AllowDynamicProperties;

#[AllowDynamicProperties]
class View{
    private string $content;

    public function __construct($viewLoader){
        $this->viewLoader = $viewLoader;
    }

    public function display($viewName, array $preTemplates = [], array $postTemplates = [], $data = []): void
    {
        $content = '';

        foreach ($preTemplates as $templateName) {
            $content .= $this->viewLoader->load($templateName, $data);
        }

        $content .= $this->viewLoader->load($viewName, $data);

        foreach ($postTemplates as $templateName) {
            $content .= $this->viewLoader->load($templateName, $data);
        }

        $this->content = $content;

        echo $this->content;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}