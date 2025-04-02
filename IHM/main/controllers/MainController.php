<?php
namespace controllers;

use data\ApiUser;
use domain\User;

class MainController
{
private $apiUser;

public function __construct()
{
$this->apiUser = new ApiUser();
}

// Affichage de la page d'accueil
public function homePage()
{
$layout = new \gui\Layout();
$view = new \gui\ViewHome($layout);
$view->display();
}

// Affichage du formulaire de connexion et traitement de la connexion
public function loginPage()
{
// Vérification de la soumission du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// Récupération des données du formulaire
$login = isset($_POST['login']) ? $_POST['login'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Appel à l'API pour authentifier l'utilisateur
$user = $this->apiUser->authenticateUser($login, $password);

if ($user) {
// Si l'utilisateur est authentifié, on stocke son ID dans la session
$_SESSION['user_id'] = $user->getId();
$_SESSION['user_name'] = $user->getName();

// Rediriger vers la page d'accueil ou autre page (ici on redirige vers la page d'accueil)
header('Location: index.php?action=home');
exit();
} else {
// Si l'authentification échoue, on peut afficher un message d'erreur
$errorMessage = "Identifiants invalides.";
}
}

// Affichage du formulaire de connexion
$layout = new \gui\Layout();
$view = new \gui\ViewLogin($layout, isset($errorMessage) ? $errorMessage : '');
$view->display();
}
}
