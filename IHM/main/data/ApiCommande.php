<?php

namespace data;

use service\CommandeAccessInterface;
include_once "service/CommandeAccessInterface.php";

use domain\Commande;
include_once "domain/Commande.php";

class ApiCommande implements CommandeAccessInterface
{
    /**
     * Crée une commande avec les paniers associés et le prix total.
     *
     * @param array $panierId L'ID du panier à inclure dans la commande.
     * @param string $retraitDate La date de retrait de la commande.
     * @param string $lieuRetrait Le lieu de retrait de la commande.
     * @return bool True si la commande est créée avec succès, sinon false.
     */
    public function createCommande($panierId, $retraitDate, $lieuRetrait)
    {
        // URL de l'API pour créer une commande
        $apiUrl = "https://exemple-api.com/commandes"; // Remplacer par l'URL réelle de ton API

        // Données à envoyer dans la requête POST
        $data = array(
            'panierId' => $panierId,
            'retraitDate' => $retraitDate,
            'lieuRetrait' => $lieuRetrait
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
}
