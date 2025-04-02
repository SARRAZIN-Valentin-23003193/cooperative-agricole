<?php
namespace controllers;

use gui\Layout;
use gui\ViewHome;
use gui\ViewLogin;

include_once 'gui/ViewHome.php'; // Inclure le fichier de la classe ViewHome
include_once 'gui/ViewLogin.php'; // Inclure le fichier de la classe ViewHome

class MainController {

    public function homePage() {
        $layout = new Layout("gui/layout.html");
        $view = new ViewHome($layout);
        $view->display();
    }

    public function loginPage() {
        $layout = new Layout("gui/layout.html");
        $view = new ViewLogin($layout);
        $view->display();
    }
}
