<?php
// index.php - Front Controller

use controllers\MainController;
use controllers\PanierController;

session_start();

// Chargement des fichiers nécessaires
require_once 'controllers/MainController.php';
require_once 'controllers/PanierController.php';
require_once 'gui/Layout.php';
require_once 'controllers/CommandesControllers.php';
require_once 'data/ApiCommande.php';
require_once 'gui/ViewCommandes.php';


// Récupération de l'action via la méthode GET
$action = isset($_GET['action']) ? $_GET['action'] : 'home'; // Valeur par défaut: home

// Création des contrôleurs
$mainController = new MainController();
$panierController = new PanierController();
$commandeController = new controllers\CommandesController(
    new data\ApiCommande(),
    new gui\ViewCommandes(new gui\Layout("gui/layout.html"))
);

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

    case 'commandes': // Afficher les commandes
        // Simuler un ID utilisateur pour cet exemple, il peut venir de la session utilisateur.
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '123'; // Exemple d'ID utilisateur
        $commandeController->afficherCommandes($userId);
        break;

    default:
        http_response_code(404);
        echo "Page not found";
        break;
}
