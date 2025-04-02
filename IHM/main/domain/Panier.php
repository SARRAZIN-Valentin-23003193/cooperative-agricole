<?php
namespace domain;

class Panier {
    private $id;
    private $produits = [];
    private $dateMiseAJour;
    private $prixTotal;

    public function __construct($id) {
        $this->id = $id;
        $this->dateMiseAJour = date("Y-m-d H:i:s");
        $this->prixTotal = 0;
    }

    public function ajouterProduit($produit, $quantite) {
        $this->produits[$produit->getId()] = ['produit' => $produit, 'quantite' => $quantite];
        $this->calculerPrixTotal();
    }

    public function supprimerProduit($produitId) {
        unset($this->produits[$produitId]);
        $this->calculerPrixTotal();
    }

    private function calculerPrixTotal() {
        $this->prixTotal = 0;
        foreach ($this->produits as $produitData) {
            $this->prixTotal += $produitData['produit']->getPrix() * $produitData['quantite'];
        }
    }

    public function getPrixTotal() {
        return $this->prixTotal;
    }

    public function getProduits() {
        return $this->produits;
    }

    public function getDateMiseAJour() {
        return $this->dateMiseAJour;
    }
}
