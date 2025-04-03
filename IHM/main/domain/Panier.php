<?php
namespace domain;

/**
 * Classe Panier qui représente un panier d'achat.
 * Un panier contient des produits, un prix total, et une quantité totale.
 */
class Panier
{
    private $id;
    private $nom; // Nom du panier
    private $produits;  // Tableau d'objets Produit
    private $prixTotal;
    private $quantiteTotale; // Nouvelle propriété pour la quantité totale

    public function __construct($id, $nom, $produits, $prixTotal)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->produits = [];
        $this->quantiteTotale = 0; // Initialisation de la quantité totale

        // Transformation des produits et calcul de la quantité totale
        foreach ($produits as $produitData) {
            $produit = new Produit($produitData['name'], $produitData['quantity'], $produitData['price']);
            $this->produits[] = $produit;
            $this->quantiteTotale += $produitData['quantity']; // Ajout de la quantité
        }

        $this->prixTotal = $prixTotal;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getProduits()
    {
        return $this->produits;
    }

    public function getPrixTotal()
    {
        return $this->prixTotal;
    }

    public function getQuantiteTotale()
    {
        return $this->quantiteTotale;
    }

    public function getDateMiseAJour()
    {
        return date("Y-m-d H:i:s"); // Date actuelle
    }
}
