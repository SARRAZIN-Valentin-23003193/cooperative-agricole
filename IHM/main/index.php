<?php
// index.php - Front Controller

use controllers\MainController;

session_start();

// Chargement des fichiers nécessaires
require_once 'controllers/MainController.php';
require_once 'gui/Layout.php';

// Récupération de l'action via la méthode GET
$action = isset($_GET['action']) ? $_GET['action'] : 'home'; // Valeur par défaut: home

// Création du contrôleur principal
$controller = new MainController();

// Routage basé sur l'action passée dans l'URL
switch ($action) {
    case 'home':
        $controller->homePage();
        break;

    case 'login':
        $controller->loginPage();
        break;

    default:
        http_response_code(404);
        echo "Page not found";
        break;
}
