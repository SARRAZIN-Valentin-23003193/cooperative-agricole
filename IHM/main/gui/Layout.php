<?php
namespace gui;

/**
 * Classe Layout qui permet de gérer l'affichage des pages en utilisant un modèle de template.
 * Cette classe charge un fichier de template et permet de remplacer des sections de celui-ci
 * par du contenu dynamique.
 */
class Layout {
    private $template;

    /**
     * Constructeur de la classe Layout.
     *
     * Charge le contenu d'un fichier de template et le stocke dans la propriété `template`.
     *
     * @param string $file Le chemin du fichier de template à charger.
     */
    public function __construct($file) {
        $this->template = file_get_contents($file);
    }


    /**
     * Rend le contenu dynamique dans le template.
     *
     * Cette méthode remplace la section `{{ content }}` du template par le contenu passé en paramètre.
     *
     * @param string $content Le contenu dynamique à insérer dans le template.
     */
    public function render($content) {
        echo str_replace("{{ content }}", $content, $this->template);
    }
}
