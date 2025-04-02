<?php

namespace gui;

require_once 'Layout.php';

class ViewHome {
    private $layout;

    public function __construct($layout) {
        $this->layout = $layout;
    }

    public function display() {
        $content = "<h2>Page d'accueil</h2><p>Bienvenue sur notre site !</p>";
        $this->layout->render($content);
    }
}