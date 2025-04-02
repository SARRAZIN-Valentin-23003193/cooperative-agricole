<?php

namespace controllers;

use data\ApiPanier;
use gui\ViewPaniers;
use gui\Layout;

require_once 'data/ApiPanier.php';
require_once 'gui/Layout.php';
require_once 'gui/ViewPaniers.php';


class PanierController
{
    public function afficherPaniers(): void
    {
        $apiPanier = new ApiPanier();
        $paniers = $apiPanier->getAllPaniers();

        // Création de l'affichage avec layout
        $layout = new Layout("gui/layout.html");
        $view = new ViewPaniers($layout, $paniers);
        $view->display();
    }
}