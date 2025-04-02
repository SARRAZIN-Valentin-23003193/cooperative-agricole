<?php
namespace domain;

class Commande
{
    private $id;
    private $userId; // L'identifiant de l'utilisateur qui a passé la commande
    private $paniers; // Un tableau d'objets Panier
    private $prixTotal;
    private $dateCommande;

    public function __construct($id, $userId, $paniers, $prixTotal, $dateCommande)
    {
        $this->id = $id;
        $this->userId = $userId;

        // Convertir les données en objets Panier
        $this->paniers = [];
        foreach ($paniers as $panierData) {
            $this->paniers[] = new Panier($panierData['id'], $panierData['produits'], $panierData['prixTotal']);
        }

        $this->prixTotal = $prixTotal;
        $this->dateCommande = $dateCommande;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getPaniers()
    {
        return $this->paniers;
    }

    public function getPrixTotal()
    {
        return $this->prixTotal;
    }

    public function getDateCommande()
    {
        return $this->dateCommande;
    }
}
