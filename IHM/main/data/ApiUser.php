<?php

namespace data;

use service\UserAccessInterface;
include_once "service/UserAccessInterface.php";

use domain\User;
include_once "domain/User.php";

class ApiUser implements UserAccessInterface
{
    /**
     * Envoie l'email et le mot de passe à l'API pour vérifier les informations de connexion.
     *
     * @param string $email L'email de l'utilisateur.
     * @param string $password Le mot de passe de l'utilisateur.
     * @return User|null L'utilisateur connecté si les informations sont valides, sinon null.
     */
    public function authenticateUser($email, $password)
    {
        // URL de l'API pour vérifier les informations de l'utilisateur
        $apiUrl = "https://exemple-api.com/connexion"; // Remplacer par l'URL réelle de ton API

        // Données à envoyer dans la requête POST
        $data = array(
            'email' => $email,
            'password' => $password
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
            return null;
        }

        // Décoder la réponse JSON
        $response = json_decode($response, true);

        // Vérification de la réponse de l'API
        if (isset($response['success']) && $response['success'] === true) {
            // L'utilisateur est authentifié, on retourne un objet User
            $userData = $response['data']; // Supposons que l'API renvoie les informations de l'utilisateur dans 'data'

            // Création de l'objet User avec les données reçues de l'API
            $user = new User($userData['id'], $userData['email'], $userData['name']);
            return $user;
        } else {
            // Les informations de connexion sont invalides
            return null;
        }
    }
}
