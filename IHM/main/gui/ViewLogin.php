<?php

namespace gui;

require_once 'Layout.php';

class ViewLogin {
    private $layout;

    public function __construct($layout) {
        $this->layout = $layout;
    }

    public function display() {
        // Création du formulaire de connexion
        $content = "
        <h2>Connexion</h2>
        <form action='index.php' method='POST'>
            <label for='login'>Nom d'utilisateur :</label><br>
            <input type='text' id='login' name='login' required><br><br>

            <label for='password'>Mot de passe :</label><br>
            <input type='password' id='password' name='password' required><br><br>

            <input type='submit' value='Se connecter'>
        </form>
        ";

        // Affichage du contenu dans la structure de la page (via Layout)
        $this->layout->render($content);
    }
}

