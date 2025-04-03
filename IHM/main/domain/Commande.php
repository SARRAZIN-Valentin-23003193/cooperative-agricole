<?php
namespace domain;

/**
 * Classe Commande qui représente une commande passée par un utilisateur.
 * Elle contient l'identifiant de la commande, l'identifiant de l'utilisateur,
 * les paniers associés à la commande, le prix total et la date de la commande.
 */
class Commande
{
    private $id;
    private $userId; // L'identifiant de l'utilisateur qui a passé la commande
    private $paniers; // Un tableau d'objets Panier
    private $prixTotal;
    private $dateCommande;

    /**
     * Constructeur de la classe Commande.
     *
     * Initialise une commande avec un identifiant, l'identifiant de l'utilisateur,
     * les paniers associés, le prix total et la date de la commande.
     *
     * @param int $id L'identifiant de la commande.
     * @param int $userId L'identifiant de l'utilisateur qui a passé la commande.
     * @param array $paniers Un tableau de données de paniers. Chaque panier est transformé en un objet Panier.
     * @param float $prixTotal Le prix total de la commande.
     * @param string $dateCommande La date de la commande.
     */
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
