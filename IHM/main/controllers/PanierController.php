<?php

namespace controllers;

use data\ApiPanier;
use gui\ViewPaniers;
use gui\Layout;

require_once 'data/ApiPanier.php';
require_once 'gui/Layout.php';
require_once 'gui/ViewPaniers.php';


/**
 * Contrôleur pour la gestion des paniers.
 */
class PanierController
{
    /**
     * Affiche la liste de tous les paniers.
     *
     * @return void
     */
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