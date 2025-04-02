<?php
/**
 * Classe PanierDTO
 *
 * Data Transfer Object pour la représentation des paniers dans l'application.
 * Permet d'encapsuler les données d'un panier reçues de l'API Paniers.
 * Compatible avec PHP 5.6
 */
class PanierDTO {
    /**
     * @var int Identifiant unique du panier
     */
    private $id;

    /**
     * @var string Nom du panier
     */
    private $nom;

    /**
     * @var string Description du panier
     */
    private $description;

    /**
     * @var float Prix du panier
     */
    private $prix;

    /**
     * @var int Quantité disponible
     */
    private $quantiteDisponible;

    /**
     * @var bool Indique si le panier est valide (disponible)
     */
    private $valide;

    /**
     * @var string Date de dernière mise à jour du panier (format Y-m-d H:i:s)
     */
    private $derniereMiseAJour;

    /**
     * @var array Liste des produits contenus dans le panier
     */
    private $produits = array();

    /**
     * Constructeur par défaut
     */
    public function __construct() {
        $this->valide = true;
        $this->derniereMiseAJour = date('Y-m-d H:i:s');
        $this->produits = array();
    }

    /**
     * Convertit l'objet PanierDTO en tableau associatif
     *
     * @return array Tableau associatif représentant le panier
     */
    public function toArray() {
        return array(
            'id' => $this->id,
            'nom' => $this->nom,
            'description' => $this->description,
            'prix' => $this->prix,
            'quantiteDisponible' => $this->quantiteDisponible,
            'valide' => $this->valide,
            'derniereMiseAJour' => $this->derniereMiseAJour,
            'produits' => $this->produits
        );
    }

    /**
     * Crée un objet PanierDTO à partir d'un tableau associatif
     *
     * @param array $data Données du panier
     * @return PanierDTO Nouvelle instance de PanierDTO
     */
    public static function fromArray($data) {
        $panierDTO = new self();

        if (isset($data['id'])) {
            $panierDTO->setId($data['id']);
        }

        if (isset($data['nom'])) {
            $panierDTO->setNom($data['nom']);
        }

        if (isset($data['description'])) {
            $panierDTO->setDescription($data['description']);
        }

        if (isset($data['prix'])) {
            $panierDTO->setPrix($data['prix']);
        }

        if (isset($data['quantiteDisponible'])) {
            $panierDTO->setQuantiteDisponible($data['quantiteDisponible']);
        }

        if (isset($data['valide'])) {
            $panierDTO->setValide($data['valide']);
        }

        if (isset($data['derniereMiseAJour'])) {
            $panierDTO->setDerniereMiseAJour($data['derniereMiseAJour']);
        }

        if (isset($data['produits']) && is_array($data['produits'])) {
            $panierDTO->setProduits($data['produits']);
        }

        return $panierDTO;
    }

    /**
     * Convertit l'objet PanierDTO en chaîne JSON
     *
     * @return string Représentation JSON du panier
     */
    public function toJson() {
        return json_encode($this->toArray());
    }

    /**
     * Crée un objet PanierDTO à partir d'une chaîne JSON
     *
     * @param string $json Chaîne JSON représentant le panier
     * @return PanierDTO|null Nouvelle instance de PanierDTO ou null si erreur
     */
    public static function fromJson($json) {
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }

        return self::fromArray($data);
    }

    /**
     * Récupère un panier depuis l'API en utilisant son ID
     *
     * @param int $id Identifiant du panier à récupérer
     * @return PanierDTO|null Panier récupéré ou null si erreur
     */
    public static function fetchById($id) {
        $url = "http://localhost:8080/paniers-api/paniers/" . $id;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode == 200) {
            return self::fromJson($response);
        }

        return null;
    }

    /**
     * Récupère tous les paniers valides depuis l'API
     *
     * @return array Liste des PanierDTO valides
     */
    public static function fetchAllValides() {
        $url = "http://localhost:8080/paniers-api/paniers/valides";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode == 200) {
            $paniersData = json_decode($response, true);
            $paniers = array();

            if (is_array($paniersData)) {
                foreach ($paniersData as $panierData) {
                    $paniers[] = self::fromArray($panierData);
                }
            }

            return $paniers;
        }

        return array();
    }

    /**
     * Met à jour la quantité disponible d'un panier via l'API
     *
     * @param int $quantite Nouvelle quantité disponible
     * @return boolean True si la mise à jour a réussi, False sinon
     */
    public function updateQuantite($quantite) {
        if (!$this->id) {
            return false;
        }

        $url = "http://localhost:8080/paniers-api/paniers/" . $this->id . "/quantite";
        $data = array('quantite' => $quantite);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen(json_encode($data))
        ));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode == 200) {
            $this->quantiteDisponible = $quantite;
            return true;
        }

        return false;
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
     * @return string
     */
    public function getNom() {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom) {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description) {
        $this->description = $description;
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
    public function getQuantiteDisponible() {
        return $this->quantiteDisponible;
    }

    /**
     * @param int $quantiteDisponible
     */
    public function setQuantiteDisponible($quantiteDisponible) {
        $this->quantiteDisponible = (int) $quantiteDisponible;
    }

    /**
     * @return boolean
     */
    public function getValide() {
        return $this->valide;
    }

    /**
     * @param boolean $valide
     */
    public function setValide($valide) {
        $this->valide = (bool) $valide;
    }

    /**
     * @return string
     */
    public function getDerniereMiseAJour() {
        return $this->derniereMiseAJour;
    }

    /**
     * @param string $derniereMiseAJour
     */
    public function setDerniereMiseAJour($derniereMiseAJour) {
        $this->derniereMiseAJour = $derniereMiseAJour;
    }

    /**
     * @return array
     */
    public function getProduits() {
        return $this->produits;
    }

    /**
     * @param array $produits
     */
    public function setProduits($produits) {
        $this->produits = $produits;
    }
}
?>