<?php
namespace data;

use domain\User;
use service\UserAccessInterface;

include_once "service/UserAccessInterface.php";
include_once "domain/User.php";

/**
 * Classe ApiUser qui implémente l'interface UserAccessInterface.
 * Cette classe gère l'authentification des utilisateurs via une API externe.
 */
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
        // Construction correcte de l'URL avec http_build_query()
        $queryParams = http_build_query([
            'mail' => $email,
            'password' => $password
        ]);
        $apiUrl = "http://localhost:8080/glassfishtest1-1.0-SNAPSHOT/api/user/authentificate?" . $queryParams;

        // Initialisation de la connexion à l'API avec CURL
        $curlConnection = curl_init();

        // Paramètres de la requête CURL
        curl_setopt_array($curlConnection, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json']
        ]);

        // Exécution de la requête CURL
        $response = curl_exec($curlConnection);
        curl_close($curlConnection);

        // Vérifier si la requête a échoué
        if (!$response) {
            echo "Erreur CURL : " . curl_error($curlConnection);
            return null;
        }

        // Décoder la réponse JSON
        $responseData = json_decode($response, true);

        // Vérifier si la réponse contient un ID (numérique)
        if ($responseData !== null && is_numeric($responseData)) {
            // Supposons que la réponse renvoie l'ID directement
            $userId = $responseData;

            // Créer un objet User avec l'ID et l'email
            return new User($userId, $email);
        }

        // Si aucune réponse valide, retourner null
        return null;
    }
}
