<?php
namespace controllers;

use data\ApiCommande;
use gui\ViewCommandes;

/**
 * Contrôleur pour la gestion des commandes.
 */
class CommandesController
{

    /**
     * @var ApiCommande Instance de l'API pour la gestion des commandes.
     */
    private $apiCommande;

    /**
     * @var ViewCommandes Instance de la vue pour l'affichage des commandes.
     */
    private $view;

    /**
     * Constructeur du contrôleur des commandes.
     *
     * @param ApiCommande $apiCommande Instance de l'API pour récupérer les commandes.
     * @param ViewCommandes $view Instance de la vue pour afficher les commandes.
     */
    public function __construct(ApiCommande $apiCommande, ViewCommandes $view) {
        $this->apiCommande = $apiCommande;
        $this->view = $view;
    }

    /**
     * Affiche les commandes d'un utilisateur donné.
     *
     * @param int $userId Identifiant de l'utilisateur.
     * @return void
     */
    public function afficherCommandes($userId) {
        // Récupérer les commandes de l'utilisateur via l'API
        $commandes = $this->apiCommande->getCommandesByUserId($userId);

        // Passer les commandes à la vue pour l'affichage
        $this->view->display($commandes);
    }
}
