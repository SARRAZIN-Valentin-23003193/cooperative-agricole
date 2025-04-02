<?php
namespace domain;

class Panier
{
private $id;
private $produits;
private $prixTotal;

public function __construct($id, $produits, $prixTotal)
{
$this->id = $id;
$this->produits = $produits;
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
// Retourner une date fictive ou l'implémenter selon la logique de ton application
return "2025-04-02 15:49:11";  // Ex: valeur statique, tu peux l'ajuster.
}
}
