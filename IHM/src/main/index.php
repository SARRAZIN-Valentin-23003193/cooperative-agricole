<?php


// chemin de l'URL demandée au navigateur
// (p.ex. /index.php)
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// définition d'une session d'une heure
ini_set('session.gc_maxlifetime', 3600);
session_set_cookie_params(3600);
session_start();

// Authentification et création du compte (sauf pour le formulaire de connexion et de création de compte)
if ('/' != $uri and '/index.php' != $uri and '/index.php/logout' != $uri and '/index.php/create' != $uri) {

    $error = $controller->authenticateAction($userCreation, $userCheck, $dataUsers);

    if ($error != null) {
        $uri = '/index.php/error';
        if ($error == 'bad login or pwd' or $error == 'not connected')
            $redirect = '/index.php';

        if ($error == 'creation impossible')
            $redirect = '/index.php/create';
    }
}

// route la requête en interne
// i.e. lance le bon contrôleur en fonction de la requête effectuée
if ('/' == $uri || '/index.php' == $uri || '/index.php/logout' == $uri) {
    // affichage de la page de connexion

    session_destroy();
    $layout = new Layout("gui/layout.html");
    $vueLogin = new ViewLogin($layout);

    $vueLogin->display();
} elseif ('/index.php/companyAlternance' == $uri
    && isset($_GET['id'])) {
    // Affichage d'une entreprise offrant de l'alternance

    $controller->postAction($_GET['id'], $apiAlternance, $annoncesCheck);

    $layout = new Layout("gui/layout.html");
    $vuePostAlternance = new \gui\ViewCompanyAlternance($layout, $_SESSION['login'], $presenter);

    $vuePostAlternance->display();
} else {
    header('Status: 404 Not Found');
    echo '<html><body><h1>My Page NotFound</h1></body></html>';
}


