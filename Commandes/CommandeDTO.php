<?php
/**
 * Classe CommandeDTO
 *
 * Data Transfer Object pour la représentation des commandes dans l'API REST.
 * Permet d'encapsuler les données d'une commande pour les échanges entre le client et le serveur.
 * Compatible avec PHP 5.6
 */
class CommandeDTO {
    /**
     * @var int Identifiant unique de la commande
     */
    private $id;

    /**
     * @var int Identifiant de l'utilisateur (abonné) qui a passé la commande
     */
    private $userId;

    /**
     * @var array Tableau de DetailPanierDTO associés à cette commande
     */
    private $paniers = array();

    /**
     * @var float Prix total de la commande
     */
    private $prixTotal;

    /**
     * @var string Lieu de retrait de la commande
     */
    private $lieuRetrait;

    /**
     * @var string Date de retrait de la commande (format Y-m-d H:i:s)
     */
    private $dateRetrait;

    /**
     * @var bool Indique si la commande a été validée par un gestionnaire
     */
    private $estValidee;

    /**
     * @var string Date de création de la commande (format Y-m-d H:i:s)
     */
    private $dateCreation;

    /**
     * Constructeur par défaut
     */
    public function __construct() {
        $this->estValidee = false;
        $this->dateCreation = date('Y-m-d H:i:s');
        $this->paniers = array();
    }

    /**
     * Constructeur à partir d'une entité Commande
     *
     * @param Commande $commande L'entité à convertir en DTO
     * @return CommandeDTO Instance de CommandeDTO
     */
    public static function fromCommande($commande) {
        $commandeDTO = new self();
        $commandeDTO->setId($commande->getId());
        $commandeDTO->setUserId($commande->getUserId());
        $commandeDTO->setPrixTotal($commande->getPrixTotal());
        $commandeDTO->setLieuRetrait($commande->getLieuRetrait());
        $commandeDTO->setDateRetrait($commande->getDateRetrait());
        $commandeDTO->setEstValidee($commande->getEstValidee());
        $commandeDTO->setDateCreation($commande->getDateCreation());

        foreach ($commande->getPaniers() as $detailPanier) {
            $commandeDTO->paniers[] = DetailPanierDTO::fromDetailPanier($detailPanier);
        }

        return $commandeDTO;
    }

    /**
     * Convertit le DTO en entité Commande
     *
     * @return Commande L'entité convertie
     */
    public function toCommande() {
        $commande = new Commande();
        $commande->setId($this->id);
        $commande->setUserId($this->userId);
        $commande->setLieuRetrait($this->lieuRetrait);
        $commande->setDateRetrait($this->dateRetrait);
        $commande->setEstValidee($this->estValidee);
        $commande->setDateCreation($this->dateCreation);

        foreach ($this->paniers as $detailPanierDTO) {
            $detailPanier = $detailPanierDTO->toDetailPanier();
            $commande->ajouterPanier($detailPanier);
        }

        $commande->calculerPrixTotal();
        return $commande;
    }

    /**
     * Convertit l'objet CommandeDTO en tableau associatif
     *
     * @return array Tableau associatif représentant la commande
     */
    public function toArray() {
        $paniersArray = array();
        foreach ($this->paniers as $panierDTO) {
            $paniersArray[] = $panierDTO->toArray();
        }

        return array(
            'id' => $this->id,
            'userId' => $this->userId,
            'paniers' => $paniersArray,
            'prixTotal' => $this->prixTotal,
            'lieuRetrait' => $this->lieuRetrait,
            'dateRetrait' => $this->dateRetrait,
            'estValidee' => $this->estValidee,
            'dateCreation' => $this->dateCreation
        );
    }

    /**
     * Crée un objet CommandeDTO à partir d'un tableau associatif
     *
     * @param array $data Données de la commande
     * @return CommandeDTO Nouvelle instance de CommandeDTO
     */
    public static function fromArray($data) {
        $commandeDTO = new self();

        if (isset($data['id'])) {
            $commandeDTO->setId($data['id']);
        }

        if (isset($data['userId'])) {
            $commandeDTO->setUserId($data['userId']);
        }

        if (isset($data['prixTotal'])) {
            $commandeDTO->setPrixTotal($data['prixTotal']);
        }

        if (isset($data['lieuRetrait'])) {
            $commandeDTO->setLieuRetrait($data['lieuRetrait']);
        }

        if (isset($data['dateRetrait'])) {
            $commandeDTO->setDateRetrait($data['dateRetrait']);
        }

        if (isset($data['estValidee'])) {
            $commandeDTO->setEstValidee($data['estValidee']);
        }

        if (isset($data['dateCreation'])) {
            $commandeDTO->setDateCreation($data['dateCreation']);
        }

        if (isset($data['paniers']) && is_array($data['paniers'])) {
            foreach ($data['paniers'] as $panierData) {
                $commandeDTO->paniers[] = DetailPanierDTO::fromArray($panierData);
            }
        }

        return $commandeDTO;
    }

    /**
     * Convertit l'objet CommandeDTO en chaîne JSON
     *
     * @return string Représentation JSON de la commande
     */
    public function toJson() {
        return json_encode($this->toArray());
    }

    /**
     * Crée un objet CommandeDTO à partir d'une chaîne JSON
     *
     * @param string $json Chaîne JSON représentant la commande
     * @return CommandeDTO|null Nouvelle instance de CommandeDTO ou null si erreur
     */
    public static function fromJson($json) {
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }

        return self::fromArray($data);
    }

    /**
     * Ajoute un DetailPanierDTO à la commande
     *
     * @param DetailPanierDTO $detailPanierDTO Le DTO du panier à ajouter
     * @return void
     */
    public function ajouterPanier($detailPanierDTO) {
        $this->paniers[] = $detailPanierDTO;
        $this->calculerPrixTotal();
    }

    /**
     * Calcule le prix total de la commande en additionnant le prix de tous les paniers
     *
     * @return float Prix total de la commande
     */
    public function calculerPrixTotal() {
        $total = 0.0;
        foreach ($this->paniers as $panierDTO) {
            $total += $panierDTO->getPrix() * $panierDTO->getQuantite();
        }
        $this->prixTotal = $total;
        return $total;
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
    public function getUserId() {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId($userId) {
        $this->userId = $userId;
    }

    /**
     * @return array
     */
    public function getPaniers() {
        return $this->paniers;
    }

    /**
     * @param array $paniers
     */
    public function setPaniers($paniers) {
        $this->paniers = $paniers;
        $this->calculerPrixTotal();
    }

    /**
     * @return float
     */
    public function getPrixTotal() {
        return $this->prixTotal;
    }

    /**
     * @param float $prixTotal
     */
    public function setPrixTotal($prixTotal) {
        $this->prixTotal = (float) $prixTotal;
    }

    /**
     * @return string
     */
    public function getLieuRetrait() {
        return $this->lieuRetrait;
    }

    /**
     * @param string $lieuRetrait
     */
    public function setLieuRetrait($lieuRetrait) {
        $this->lieuRetrait = $lieuRetrait;
    }

    /**
     * @return string
     */
    public function getDateRetrait() {
        return $this->dateRetrait;
    }

    /**
     * @param string $dateRetrait
     */
    public function setDateRetrait($dateRetrait) {
        $this->dateRetrait = $dateRetrait;
    }

    /**
     * @return boolean
     */
    public function getEstValidee() {
        return $this->estValidee;
    }

    /**
     * @param boolean $estValidee
     */
    public function setEstValidee($estValidee) {
        $this->estValidee = (bool) $estValidee;
    }

    /**
     * @return string
     */
    public function getDateCreation() {
        return $this->dateCreation;
    }

    /**
     * @param string $dateCreation
     */
    public function setDateCreation($dateCreation) {
        $this->dateCreation = $dateCreation;
    }
}