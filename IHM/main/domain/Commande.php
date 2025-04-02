<?php
namespace domain;

class Commande
{
private $id;
private $produits;
private $prixTotal;
private $dateCommande;

public function __construct($id, $produits, $prixTotal, $dateCommande)
{
$this->id = $id;
$this->produits = $produits;  // Tableau d'objets Produit
$this->prixTotal = $prixTotal;
$this->dateCommande = $dateCommande;
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

public function getDateCommande()
{
return $this->dateCommande;
}
}
