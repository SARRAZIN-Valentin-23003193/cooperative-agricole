<?php

namespace data;

use service\PanierAccessInterface;
include_once "service/PanierAccessInterface.php";

use domain\Panier;
include_once "domain/Panier.php";

class ApiPanier implements PanierAccessInterface
{
    /**
     * Crée un panier avec une liste de produits.
     *
     * @param array $produits Une liste de produits (id et quantité).
     * @return bool True si le panier est créé avec succès, sinon false.
     */
    public function createPanier($produits)
    {
        // URL de l'API pour créer un panier
        $apiUrl = "https://exemple-api.com/paniers"; // Remplacer par l'URL réelle de ton API

        // Données à envoyer dans la requête POST
        $data = array(
            'produits' => $produits // Ex: [['idProduit' => 1, 'quantite' => 2], ['idProduit' => 2, 'quantite' => 3]]
        );

        // Initialisation de la connexion à l'API avec CURL
        $curlConnection = curl_init();

        // Paramètres de la requête CURL
        $params = array(
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data)
        );

        // Exécution de la requête CURL
        curl_setopt_array($curlConnection, $params);
        $response = curl_exec($curlConnection);
        curl_close($curlConnection);

        // Vérifier si la requête a échoué
        if (!$response) {
            echo curl_error($curlConnection);
            return false;
        }

        // Décoder la réponse JSON
        $response = json_decode($response, true);

        // Vérifier la réponse de l'API
        if (isset($response['success']) && $response['success'] === true) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Récupère un panier par son ID via l'API.
     *
     * @param int $id L'ID du panier.
     * @return Panier|null L'objet Panier si trouvé, sinon null.
     */
    public function getPanierById($id)
    {
        // URL de l'API pour récupérer un panier spécifique
        $apiUrl = "https://exemple-api.com/paniers/{$id}"; // Remplacer par l'URL réelle de ton API

        // Initialisation de la connexion à l'API avec CURL
        $curlConnection = curl_init();

        // Paramètres de la requête CURL
        $params = array(
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
        );

        // Exécution de la requête CURL
        curl_setopt_array($curlConnection, $params);
        $response = curl_exec($curlConnection);
        curl_close($curlConnection);

        // Vérifier si la requête a échoué
        if (!$response) {
            echo curl_error($curlConnection);
            return null;
        }

        // Décoder la réponse JSON
        $response = json_decode($response, true);

        // Vérifier si le panier existe
        if (isset($response['data'])) {
            // Créer l'objet Panier
            $panierData = $response['data'];
            return new Panier($panierData['id'], $panierData['produits'], $panierData['prixTotal']);
        }

        return null;
    }
}
