<?php
namespace domain;

class Panier
{
private $id;
private $produits;  // Un tableau d'objets Produit
private $prixTotal;

public function __construct($id, $produits, $prixTotal)
{
$this->id = $id;

// On transforme les données de produits en objets Produit
$this->produits = [];
foreach ($produits as $produitData) {
$this->produits[] = new Produit($produitData['name'], $produitData['quantity'], $produitData['price']);
}

$this->prixTotal = $prixTotal;
}

public function getId()
{
return $this->id;
}

public function getProduits()
{
return $this->produits;
}

public function getPrixTotal()
{
return $this->prixTotal;
}

public function getDateMiseAJour()
{
return "2025-04-02 15:49:11";  // Une valeur statique pour l'instant, peut être ajustée selon les besoins.
}
}
