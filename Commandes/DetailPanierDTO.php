<?php
/**
 * Classe DetailPanierDTO
 *
 * Data Transfer Object pour la représentation des détails de panier dans l'API REST.
 * Permet de transférer les données des détails de panier entre le client et le serveur.
 * Compatible avec PHP 5.6
 */
class DetailPanierDTO {
    /**
     * @var int Identifiant unique du détail panier
     */
    private $id;

    /**
     * @var int Identifiant du panier référencé
     */
    private $panierId;

    /**
     * @var float Prix unitaire du panier
     */
    private $prix;

    /**
     * @var int Quantité commandée
     */
    private $quantite;

    /**
     * Constructeur par défaut
     */
    public function __construct() {
        $this->quantite = 1;
    }

    /**
     * Constructeur avec paramètres
     *
     * @param int $panierId Identifiant du panier
     * @param float $prix Prix unitaire
     * @param int $quantite Quantité
     * @return DetailPanierDTO Instance de DetailPanierDTO
     */
    public static function create($panierId, $prix, $quantite = 1) {
        $dto = new self();
        $dto->setPanierId($panierId);
        $dto->setPrix($prix);
        $dto->setQuantite($quantite);
        return $dto;
    }

    /**
     * Crée un DTO à partir d'une entité DetailPanier
     *
     * @param DetailPanier $detailPanier L'entité à convertir
     * @return DetailPanierDTO Instance de DetailPanierDTO
     */
    public static function fromDetailPanier($detailPanier) {
        $dto = new self();
        $dto->setId($detailPanier->getId());
        $dto->setPanierId($detailPanier->getPanierId());
        $dto->setPrix($detailPanier->getPrix());
        $dto->setQuantite($detailPanier->getQuantite());
        return $dto;
    }

    /**
     * Convertit le DTO en entité DetailPanier
     *
     * @return DetailPanier L'entité convertie
     */
    public function toDetailPanier() {
        $detailPanier = new DetailPanier();
        $detailPanier->setId($this->id);
        $detailPanier->setPanierId($this->panierId);
        $detailPanier->setPrix($this->prix);
        $detailPanier->setQuantite($this->quantite);
        return $detailPanier;
    }

    /**
     * Convertit l'objet DetailPanierDTO en tableau associatif
     *
     * @return array Tableau associatif représentant le détail panier
     */
    public function toArray() {
        return array(
            'id' => $this->id,
            'panierId' => $this->panierId,
            'prix' => $this->prix,
            'quantite' => $this->quantite
        );
    }

    /**
     * Crée un objet DetailPanierDTO à partir d'un tableau associatif
     *
     * @param array $data Données du détail panier
     * @return DetailPanierDTO Nouvelle instance de DetailPanierDTO
     */
    public static function fromArray($data) {
        $dto = new self();

        if (isset($data['id'])) {
            $dto->setId($data['id']);
        }

        if (isset($data['panierId'])) {
            $dto->setPanierId($data['panierId']);
        }

        if (isset($data['prix'])) {
            $dto->setPrix($data['prix']);
        }

        if (isset($data['quantite'])) {
            $dto->setQuantite($data['quantite']);
        }

        return $dto;
    }

    /**
     * Convertit l'objet DetailPanierDTO en chaîne JSON
     *
     * @return string Représentation JSON du détail panier
     */
    public function toJson() {
        return json_encode($this->toArray());
    }

    /**
     * Crée un objet DetailPanierDTO à partir d'une chaîne JSON
     *
     * @param string $json Chaîne JSON représentant le détail panier
     * @return DetailPanierDTO|null Nouvelle instance de DetailPanierDTO ou null si erreur
     */
    public static function fromJson($json) {
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }

        return self::fromArray($data);
    }

    /**
     * Calcule le prix total de ce détail panier (prix unitaire × quantité)
     *
     * @return float Le prix total du détail panier
     */
    public function calculerPrixTotal() {
        return $this->prix * $this->quantite;
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getPanierId() {
        return $this->panierId;
    }

    /**
     * @param int $panierId
     */
    public function setPanierId($panierId) {
        $this->panierId = $panierId;
    }

    /**
     * @return float
     */
    public function getPrix() {
        return $this->prix;
    }

    /**
     * @param float $prix
     */
    public function setPrix($prix) {
        $this->prix = (float) $prix;
    }

    /**
     * @return int
     */
    public function getQuantite() {
        return $this->quantite;
    }

    /**
     * @param int $quantite
     */
    public function setQuantite($quantite) {
        $this->quantite = (int) $quantite;
    }
}
?>