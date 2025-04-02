<?php
/**
 * Classe DetailPanier
 *
 * Représente un détail de panier dans une commande.
 * Un détail panier associe un panier à une commande avec une quantité et un prix.
 * Compatible avec PHP 5.6
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
     * Récupère les détails d'un panier par son ID
     *
     * @param int $id Identifiant du détail panier
     * @param PDO $pdo Instance de connexion à la base de données
     * @return DetailPanier|null Le détail panier trouvé ou null si non trouvé
     */
    public static function findById($id, $pdo) {
        $stmt = $pdo->prepare('SELECT * FROM DetailPanier WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$data) {
            return null;
        }

        $detailPanier = new self();
        $detailPanier->setId($data['id']);
        $detailPanier->setPanierId($data['panierId']);
        $detailPanier->setPrix($data['prix']);
        $detailPanier->setQuantite($data['quantite']);

        return $detailPanier;
    }

    /**
     * Récupère tous les détails de panier d'une commande
     *
     * @param int $commandeId Identifiant de la commande
     * @param PDO $pdo Instance de connexion à la base de données
     * @return array Tableau des détails de panier
     */
    public static function findByCommandeId($commandeId, $pdo) {
        $stmt = $pdo->prepare('SELECT * FROM DetailPanier WHERE commande_id = :commande_id');
        $stmt->bindParam(':commande_id', $commandeId, PDO::PARAM_INT);
        $stmt->execute();

        $detailsPaniers = array();
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $detailPanier = new self();
            $detailPanier->setId($data['id']);
            $detailPanier->setPanierId($data['panierId']);
            $detailPanier->setPrix($data['prix']);
            $detailPanier->setQuantite($data['quantite']);

            $detailsPaniers[] = $detailPanier;
        }

        return $detailsPaniers;
    }

    /**
     * Enregistre le détail panier dans la base de données
     *
     * @param PDO $pdo Instance de connexion à la base de données
     * @return boolean True si succès, False sinon
     */
    public function save($pdo) {
        try {
            if ($this->commande === null || $this->commande->getId() === null) {
                throw new Exception("Un détail panier doit être associé à une commande sauvegardée");
            }

            if ($this->id) {
                // Mise à jour d'un détail existant
                $stmt = $pdo->prepare('
                    UPDATE DetailPanier 
                    SET panierId = :panierId, commande_id = :commande_id, 
                        prix = :prix, quantite = :quantite
                    WHERE id = :id
                ');
                $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            } else {
                // Création d'un nouveau détail
                $stmt = $pdo->prepare('
                    INSERT INTO DetailPanier 
                    (panierId, commande_id, prix, quantite)
                    VALUES (:panierId, :commande_id, :prix, :quantite)
                ');
            }

            $commandeId = $this->commande->getId();

            $stmt->bindParam(':panierId', $this->panierId, PDO::PARAM_INT);
            $stmt->bindParam(':commande_id', $commandeId, PDO::PARAM_INT);
            $stmt->bindParam(':prix', $this->prix, PDO::PARAM_STR);
            $stmt->bindParam(':quantite', $this->quantite, PDO::PARAM_INT);

            $result = $stmt->execute();

            if (!$this->id && $result) {
                $this->id = $pdo->lastInsertId();
            }

            return $result;
        } catch (Exception $e) {
            error_log("Erreur lors de la sauvegarde du détail panier: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Supprime le détail panier de la base de données
     *
     * @param PDO $pdo Instance de connexion à la base de données
     * @return boolean True si succès, False sinon
     */
    public function delete($pdo) {
        if (!$this->id) {
            return false;
        }

        try {
            $stmt = $pdo->prepare('DELETE FROM DetailPanier WHERE id = :id');
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Erreur lors de la suppression du détail panier: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Récupère le panier associé depuis l'API
     *
     * @return array|null Données du panier ou null si erreur
     */
    public function getPanierFromAPI() {
        $url = "http://localhost:8080/paniers-api/paniers/" . $this->panierId;

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
     * Calcule le prix total de ce détail panier (prix unitaire × quantité)
     *
     * @return float Le prix total du détail panier
     */
    public function calculerPrixTotal() {
        return $this->prix * $this->quantite;
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