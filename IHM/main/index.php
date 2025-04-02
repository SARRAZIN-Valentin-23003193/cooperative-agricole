<?php
// index.php - Front Controller

use controllers\MainController;

session_start();

// Chargement des fichiers nécessaires
require_once 'controllers/MainController.php';
require_once 'gui/Layout.php';

// Récupération de l'URL demandée
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Création du contrôleur principal
$controller = new MainController();

// Routing basique
if ($uri == '/' || $uri == '/index.php') {
    $controller->homePage();
} elseif ($uri == '/about') {
    $controller->aboutPage();
} else {
    http_response_code(404);
    echo "Page not found";
}
