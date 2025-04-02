<?php
namespace domain;

class Produit {
    private $id;
    private $nom;
    private $prix;
    private $quantiteDispo;
    private $unite;

    public function __construct($id, $nom, $prix, $quantiteDispo, $unite) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prix = $prix;
        $this->quantiteDispo = $quantiteDispo;
        $this->unite = $unite;
    }

    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrix() {
        return $this->prix;
    }

    public function getQuantiteDispo() {
        return $this->quantiteDispo;
    }

    public function getUnite() {
        return $this->unite;
    }
}
