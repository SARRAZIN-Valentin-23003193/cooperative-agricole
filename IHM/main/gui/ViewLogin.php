<?php
namespace gui;

class ViewLogin
{
private $layout;
private $errorMessage;

public function __construct($layout, $errorMessage = '')
{
$this->layout = $layout;
$this->errorMessage = $errorMessage;
}

public function display()
{
// Formulaire de connexion
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

// Affichage final avec le layout
$this->layout->render($content);
}
}
