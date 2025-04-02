<?php

namespace data;

use service\ProduitAccessInterface;
include_once "service/ProduitAccessInterface.php";

use domain\Produit;
include_once "domain/Produit.php";

class ApiProduit implements ProduitAccessInterface
{
    /**
     * Envoie les informations du produit à l'API pour les ajouter.
     *
     * @param string $nom Le nom du produit.
     * @param float $prix Le prix du produit.
     * @param int $quantiteDispo La quantité disponible du produit.
     * @param string $unite L'unité de mesure du produit (kg, unité, douzaine, etc.).
     * @return bool True si le produit est ajouté avec succès, sinon false.
     */
    public function createProduct($nom, $prix, $quantiteDispo, $unite)
    {
        // URL de l'API pour créer un produit
        $apiUrl = "https://exemple-api.com/produits"; // Remplacer par l'URL réelle de ton API

        // Données à envoyer dans la requête POST
        $data = array(
            'nom' => $nom,
            'prix' => $prix,
            'quantiteDispo' => $quantiteDispo,
            'unite' => $unite
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
     * Récupère les informations d'un produit spécifique via l'API.
     *
     * @param int $id L'ID du produit.
     * @return Produit|null L'objet Produit si trouvé, sinon null.
     */
    public function getProductById($id)
    {
        // URL de l'API pour récupérer un produit spécifique
        $apiUrl = "https://exemple-api.com/produits/{$id}"; // Remplacer par l'URL réelle de ton API

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

        // Vérifier si le produit existe
        if (isset($response['data'])) {
            // Créer l'objet Produit
            $productData = $response['data'];
            return new Produit($productData['id'], $productData['nom'], $productData['prix'], $productData['quantiteDispo'], $productData['unite']);
        }

        return null;
    }
}
