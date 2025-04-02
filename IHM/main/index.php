<?php
// index.php - Front Controller

use controllers\MainController;
use controllers\PanierController;

session_start();

// Chargement des fichiers nécessaires
require_once 'controllers/MainController.php';
require_once 'controllers/PanierController.php';
require_once 'gui/Layout.php';

// Récupération de l'action via la méthode GET
$action = isset($_GET['action']) ? $_GET['action'] : 'home'; // Valeur par défaut: home

// Création des contrôleurs
$mainController = new MainController();
$panierController = new PanierController();

// Routage basé sur l'action passée dans l'URL
switch ($action) {
    case 'home':
        $mainController->homePage();
        break;

    case 'login':
        $mainController->loginPage();
        break;

    case 'paniers': // Nouvelle route pour afficher les paniers
        $panierController->afficherPaniers();
        break;

    default:
        http_response_code(404);
        echo "Page not found";
        break;
}
