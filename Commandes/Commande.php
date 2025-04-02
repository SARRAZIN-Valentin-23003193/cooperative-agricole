<?php
/**
 * Classe Commandes
 *
 * Représente une commande passée par un abonné dans l'application de la coopérative agricole.
 * Compatible avec PHP 5.6
 */
class Commande {
    /**
     * @var int Identifiant unique de la commande
     */
    private $id;

    /**
     * @var int Identifiant de l'utilisateur (abonné) qui a passé la commande
     */
    private $userId;

    /**
     * @var array Tableau de DetailPanier associés à cette commande
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
     * Constructeur de la classe Commandes
     *
     * @param int $userId ID de l'utilisateur
     * @param string $lieuRetrait Lieu de retrait de la commande
     * @param string $dateRetrait Date de retrait au format Y-m-d H:i:s
     */
    public function __construct($userId = null, $lieuRetrait = null, $dateRetrait = null) {
        $this->userId = $userId;
        $this->lieuRetrait = $lieuRetrait;
        $this->dateRetrait = $dateRetrait;
        $this->estValidee = false;
        $this->dateCreation = date('Y-m-d H:i:s');
        $this->prixTotal = 0.0;
    }

    /**
     * Calcule le prix total de la commande en additionnant le prix de tous les paniers
     *
     * @return float Prix total de la commande
     */
    public function calculerPrixTotal() {
        $total = 0.0;
        foreach ($this->paniers as $panier) {
            $total += $panier->getPrix() * $panier->getQuantite();
        }
        $this->prixTotal = $total;
        return $total;
    }

    /**
     * Ajoute un DetailPanier à la commande
     *
     * @param DetailPanier $detailPanier Le panier à ajouter
     * @return void
     */
    public function ajouterPanier($detailPanier) {
        $detailPanier->setCommande($this);
        $this->paniers[] = $detailPanier;
        $this->calculerPrixTotal();
    }

    /**
     * Récupère la commande à partir de la base de données
     *
     * @param int $id Identifiant de la commande à récupérer
     * @param PDO $pdo Instance de connexion à la base de données
     * @return Commande|null La commande trouvée ou null si non trouvée
     */
    public static function findById($id, $pdo) {
        $stmt = $pdo->prepare('SELECT * FROM Commandes WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $commandeData = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$commandeData) {
            return null;
        }

        $commande = new self();
        $commande->setId($commandeData['id']);
        $commande->setUserId($commandeData['userId']);
        $commande->setPrixTotal($commandeData['prixTotal']);
        $commande->setLieuRetrait($commandeData['lieuRetrait']);
        $commande->setDateRetrait($commandeData['dateRetrait']);
        $commande->setEstValidee($commandeData['estValidee'] ? true : false);
        $commande->setDateCreation($commandeData['dateCreation']);

        // Récupérer les détails des paniers associés à cette commande
        $stmt = $pdo->prepare('SELECT * FROM DetailPanier WHERE commande_id = :commande_id');
        $stmt->bindParam(':commande_id', $id, PDO::PARAM_INT);
        $stmt->execute();

        while ($panierData = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $detailPanier = new DetailPanier();
            $detailPanier->setId($panierData['id']);
            $detailPanier->setPanierId($panierData['panierId']);
            $detailPanier->setPrix($panierData['prix']);
            $detailPanier->setQuantite($panierData['quantite']);
            $detailPanier->setCommande($commande);

            $commande->paniers[] = $detailPanier;
        }

        return $commande;
    }

    /**
     * Récupère toutes les commandes d'un utilisateur
     *
     * @param int $userId Identifiant de l'utilisateur
     * @param PDO $pdo Instance de connexion à la base de données
     * @return array Tableau des commandes de l'utilisateur
     */
    public static function findByUserId($userId, $pdo) {
        $stmt = $pdo->prepare('SELECT id FROM Commandes WHERE userId = :userId');
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $commandes = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $commande = self::findById($row['id'], $pdo);
            if ($commande) {
                $commandes[] = $commande;
            }
        }

        return $commandes;
    }

    /**
     * Enregistre la commande dans la base de données
     *
     * @param PDO $pdo Instance de connexion à la base de données
     * @return boolean True si succès, False sinon
     */
    public function save($pdo) {
        try {
            $pdo->beginTransaction();

            if ($this->id) {
                // Mise à jour d'une commande existante
                $stmt = $pdo->prepare('
                    UPDATE Commandes 
                    SET userId = :userId, prixTotal = :prixTotal, lieuRetrait = :lieuRetrait, 
                        dateRetrait = :dateRetrait, estValidee = :estValidee, dateCreation = :dateCreation
                    WHERE id = :id
                ');
                $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            } else {
                // Création d'une nouvelle commande
                $stmt = $pdo->prepare('
                    INSERT INTO Commandes 
                    (userId, prixTotal, lieuRetrait, dateRetrait, estValidee, dateCreation)
                    VALUES (:userId, :prixTotal, :lieuRetrait, :dateRetrait, :estValidee, :dateCreation)
                ');
            }

            $estValidee = $this->estValidee ? 1 : 0;

            $stmt->bindParam(':userId', $this->userId, PDO::PARAM_INT);
            $stmt->bindParam(':prixTotal', $this->prixTotal, PDO::PARAM_STR);
            $stmt->bindParam(':lieuRetrait', $this->lieuRetrait, PDO::PARAM_STR);
            $stmt->bindParam(':dateRetrait', $this->dateRetrait, PDO::PARAM_STR);
            $stmt->bindParam(':estValidee', $estValidee, PDO::PARAM_INT);
            $stmt->bindParam(':dateCreation', $this->dateCreation, PDO::PARAM_STR);

            $stmt->execute();

            if (!$this->id) {
                $this->id = $pdo->lastInsertId();
            }

            // Supprimer les détails de paniers existants pour cette commande
            $stmt = $pdo->prepare('DELETE FROM DetailPanier WHERE commande_id = :commande_id');
            $stmt->bindParam(':commande_id', $this->id, PDO::PARAM_INT);
            $stmt->execute();

            // Ajouter les nouveaux détails de paniers
            foreach ($this->paniers as $panier) {
                $stmt = $pdo->prepare('
                    INSERT INTO DetailPanier 
                    (panierId, commande_id, prix, quantite)
                    VALUES (:panierId, :commande_id, :prix, :quantite)
                ');

                $stmt->bindParam(':panierId', $panier->getPanierId(), PDO::PARAM_INT);
                $stmt->bindParam(':commande_id', $this->id, PDO::PARAM_INT);
                $stmt->bindParam(':prix', $panier->getPrix(), PDO::PARAM_STR);
                $stmt->bindParam(':quantite', $panier->getQuantite(), PDO::PARAM_INT);

                $stmt->execute();
            }

            $pdo->commit();
            return true;
        } catch (Exception $e) {
            $pdo->rollBack();
            error_log("Erreur lors de la sauvegarde de la commande: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Supprime la commande de la base de données
     *
     * @param PDO $pdo Instance de connexion à la base de données
     * @return boolean True si succès, False sinon
     */
    public function delete($pdo) {
        if (!$this->id) {
            return false;
        }

        try {
            $pdo->beginTransaction();

            // Supprimer d'abord les détails des paniers (contrainte de clé étrangère)
            $stmt = $pdo->prepare('DELETE FROM DetailPanier WHERE commande_id = :commande_id');
            $stmt->bindParam(':commande_id', $this->id, PDO::PARAM_INT);
            $stmt->execute();

            // Puis supprimer la commande
            $stmt = $pdo->prepare('DELETE FROM Commandes WHERE id = :id');
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            $stmt->execute();

            $pdo->commit();
            return true;
        } catch (Exception $e) {
            $pdo->rollBack();
            error_log("Erreur lors de la suppression de la commande: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Valide une commande (réservé aux gestionnaires)
     *
     * @param PDO $pdo Instance de connexion à la base de données
     * @return boolean True si succès, False sinon
     */
    public function valider($pdo) {
        $this->estValidee = true;
        return $this->save($pdo);
    }

    /**
     * Convertit l'objet Commandes en tableau associatif
     *
     * @return array Tableau associatif représentant la commande
     */
    public function toArray() {
        $paniersArray = array();
        foreach ($this->paniers as $panier) {
            $paniersArray[] = $panier->toArray();
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
     * Crée un objet Commandes à partir d'un tableau associatif
     *
     * @param array $data Données de la commande
     * @return Commande Nouvelle instance de Commandes
     */
    public static function fromArray($data) {
        $commande = new self();

        if (isset($data['id'])) {
            $commande->setId($data['id']);
        }

        if (isset($data['userId'])) {
            $commande->setUserId($data['userId']);
        }

        if (isset($data['lieuRetrait'])) {
            $commande->setLieuRetrait($data['lieuRetrait']);
        }

        if (isset($data['dateRetrait'])) {
            $commande->setDateRetrait($data['dateRetrait']);
        }

        if (isset($data['estValidee'])) {
            $commande->setEstValidee($data['estValidee']);
        }

        if (isset($data['dateCreation'])) {
            $commande->setDateCreation($data['dateCreation']);
        }

        if (isset($data['paniers']) && is_array($data['paniers'])) {
            foreach ($data['paniers'] as $panierData) {
                $panier = DetailPanier::fromArray($panierData);
                $commande->ajouterPanier($panier);
            }
        }

        return $commande;
    }

    /**
     * Appelle l'API REST du composant Paniers pour récupérer un panier
     *
     * @param int $panierId ID du panier à récupérer
     * @return array|null Données du panier ou null si erreur
     */
    public static function getPanierFromAPI($panierId) {
        $url = "http://localhost:8080/paniers-api/paniers/" . $panierId;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode == 200) {
            return json_decode($response, true);
        }

        return null;
    }

    /**
     * Met à jour la quantité d'un panier via l'API REST
     *
     * @param int $panierId ID du panier à mettre à jour
     * @param int $quantite Nouvelle quantité disponible
     * @return boolean True si succès, False sinon
     */
    public static function updatePanierQuantite($panierId, $quantite) {
        $url = "http://localhost:8080/paniers-api/paniers/" . $panierId . "/quantite/" . $quantite;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $httpCode == 200;
    }

    // Getters et Setters

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
     * @return boolean
     */
    public function isEstValidee() {
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

/**
 * Classe DetailPanier
 *
 * Représente un détail de panier dans une commande
 */
class DetailPanier {
    /**
     * @var int Identifiant unique du détail panier
     */
    private $id;

    /**
     * @var int Identifiant du panier référencé
     */
    private $panierId;

    /**
     * @var Commande Commandes associée à ce détail
     */
    private $commande;

    /**
     * @var float Prix unitaire du panier
     */
    private $prix;

    /**
     * @var int Quantité commandée
     */
    private $quantite;

    /**
     * Constructeur de la classe DetailPanier
     *
     * @param int $panierId ID du panier
     * @param float $prix Prix unitaire
     * @param int $quantite Quantité (par défaut 1)
     */
    public function __construct($panierId = null, $prix = 0.0, $quantite = 1) {
        $this->panierId = $panierId;
        $this->prix = (float) $prix;
        $this->quantite = (int) $quantite;
    }

    /**
     * Convertit l'objet DetailPanier en tableau associatif
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
     * Crée un objet DetailPanier à partir d'un tableau associatif
     *
     * @param array $data Données du détail panier
     * @return DetailPanier Nouvelle instance de DetailPanier
     */
    public static function fromArray($data) {
        $detailPanier = new self();

        if (isset($data['id'])) {
            $detailPanier->setId($data['id']);
        }

        if (isset($data['panierId'])) {
            $detailPanier->setPanierId($data['panierId']);
        }

        if (isset($data['prix'])) {
            $detailPanier->setPrix($data['prix']);
        }

        if (isset($data['quantite'])) {
            $detailPanier->setQuantite($data['quantite']);
        }

        return $detailPanier;
    }

    // Getters et Setters

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
     * @return Commande
     */
    public function getCommande() {
        return $this->commande;
    }

    /**
     * @param Commande $commande
     */
    public function setCommande($commande) {
        $this->commande = $commande;
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