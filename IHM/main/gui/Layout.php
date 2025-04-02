<?php
namespace gui;

class Layout {
    private $template;

    public function __construct($file) {
        $this->template = file_get_contents($file);
    }

    public function render($content) {
        echo str_replace("{{ content }}", $content, $this->template);
    }
}
