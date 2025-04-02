<?php
namespace controllers;

use data\ApiCommande;
use gui\ViewCommandes;

class CommandesController
{
private $apiCommande;
private $view;

public function __construct(ApiCommande $apiCommande, ViewCommandes $view)
{
$this->apiCommande = $apiCommande;
$this->view = $view;
}

public function afficherCommandes($userId)
{
// Récupérer les commandes de l'utilisateur via l'API
$commandes = $this->apiCommande->getCommandesByUserId($userId);

// Passer les commandes à la vue pour l'affichage
$this->view->display($commandes);
}
}
