<?php

namespace gui;

require_once 'Layout.php';

/**
 * Classe ViewHome qui est responsable de l'affichage de la page d'accueil.
 * Elle génère le contenu de la page d'accueil et l'affiche en utilisant un modèle de layout.
 */
class ViewHome {
    private $layout;

    /**
     * Constructeur de la classe ViewHome.
     *
     * @param Layout $layout L'objet Layout qui sert à gérer le modèle de la page.
     */
    public function __construct($layout) {
        $this->layout = $layout;
    }


    /**
     * Affiche le contenu de la page d'accueil.
     *
     * Cette méthode génère du contenu HTML pour la page d'accueil et l'affiche via le layout.
     * Elle inclut un lien vers la page de connexion.
     */
    public function display() {
        $content = "<h2>Page d'accueil</h2><p>Bienvenue sur notre site !</p>";
        $content .= "<a href='?action=login'>connexion</a>";
        $this->layout->render($content);
    }
}