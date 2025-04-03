<?php
namespace data;

use service\PanierAccessInterface;
include_once "service/PanierAccessInterface.php";

use domain\Panier;
include_once "domain/Panier.php";

/**
 * Classe ApiPanier qui implémente l'interface PanierAccessInterface.
 * Cette classe gère l'accès aux paniers via une API externe.
 */
class ApiPanier implements PanierAccessInterface
{
    /**
     * Récupère tous les paniers disponibles via l'API.
     *
     * @return array Un tableau contenant tous les paniers disponibles.
     */
    public function getAllPaniers(): array
    {
        $apiUrl = "http://127.0.0.1:8080/api-paniers-1.0-SNAPSHOT/api/paniers";

        $curlConnection = curl_init();
        $params = [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        ];

        curl_setopt_array($curlConnection, $params);
        $response = curl_exec($curlConnection);
        curl_close($curlConnection);

        if (!$response) {
            echo "Erreur CURL : " . curl_error($curlConnection);
            return ['error' => 'Erreur de connexion à l\'API'];
        }

        $response = json_decode($response, true);

        // Vérifier si la réponse est bien un tableau
        if (!is_array($response)) {
            return ['error' => 'Réponse invalide de l\'API'];
        }

        $paniers = [];

        foreach ($response as $panierData) {
            // Création de l'objet Panier avec les nouvelles données
            $paniers[] = new Panier(
                $panierData['basket_id'],
                $panierData['name'],      // Nom du panier
                [],                        // Pas de produits détaillés dans cet exemple
                $panierData['price'],      // Prix total
                $panierData['quantity']    // Quantité totale (déjà fournie)
            );
        }

        return $paniers;
    }
}
