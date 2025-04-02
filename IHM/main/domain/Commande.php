<?php
namespace domain;

class Commande {
    private $id;
    private $panier;
    private $dateCommande;
    private $retraitDate;
    private $lieuRetrait;

    public function __construct($id, Panier $panier, $retraitDate, $lieuRetrait) {
        $this->id = $id;
        $this->panier = $panier;
        $this->dateCommande = date("Y-m-d H:i:s");
        $this->retraitDate = $retraitDate;
        $this->lieuRetrait = $lieuRetrait;
    }

    public function getPanier() {
        return $this->panier;
    }

    public function getDateCommande() {
        return $this->dateCommande;
    }

    public function getRetraitDate() {
        return $this->retraitDate;
    }

    public function getLieuRetrait() {
        return $this->lieuRetrait;
    }
}
