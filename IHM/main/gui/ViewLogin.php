<?php
namespace gui;

/**
 * Classe ViewLogin qui est responsable de l'affichage du formulaire de connexion.
 * Elle génère le formulaire de connexion et affiche un message d'erreur si nécessaire.
 */
class ViewLogin
{
    private $layout;
    private $errorMessage;

    /**
     * Constructeur de la classe ViewLogin.
     *
     * @param Layout $layout L'objet Layout qui sert à gérer le modèle de la page.
     * @param string $errorMessage Un message d'erreur à afficher (optionnel).
     */
    public function __construct($layout, $errorMessage = '')
    {
        $this->layout = $layout;
        $this->errorMessage = $errorMessage;
    }

    /**
     * Affiche le contenu du formulaire de connexion.
     *
     * Cette méthode génère le contenu HTML pour le formulaire de connexion et affiche
     * un message d'erreur s'il existe. Le contenu est ensuite rendu avec le modèle de layout.
     */
    public function display()
    {
        // Formulaire de connexion HTML
        $content = "
        <h2>Connexion</h2>
        <form action='index.php?action=login' method='POST'>
            <label for='login'>Nom d'utilisateur :</label><br>
            <input type='text' id='login' name='login' required><br><br>

            <label for='password'>Mot de passe :</label><br>
            <input type='password' id='password' name='password' required><br><br>

            <input type='submit' value='Se connecter'>
        </form>";

        // Si un message d'erreur existe, on l'affiche
        if (!empty($this->errorMessage)) {
            $content .= "<p style='color: red;'>{$this->errorMessage}</p>";
        }

        // Rendu final avec le layout
        $this->layout->render($content);
    }
}
