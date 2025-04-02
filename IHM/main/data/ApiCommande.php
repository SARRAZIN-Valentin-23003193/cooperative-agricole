<?php
namespace data;

use service\CommandeAccessInterface;
include_once "service/CommandeAccessInterface.php";

use domain\Commande;
use domain\Produit;
include_once "domain/Commande.php";
include_once "domain/Produit.php";

class ApiCommande implements CommandeAccessInterface
{
/**
* Récupère toutes les commandes existantes d'un utilisateur en utilisant son ID.
*
* @param string $userId L'ID de l'utilisateur dont on veut récupérer les commandes.
* @return array Une liste des commandes de l'utilisateur.
*/
public function getCommandesByUserId($userId): array
{
// URL de l'API pour récupérer les commandes de l'utilisateur
$apiUrl = "https://exemple-api.com/commandes?userId={$userId}"; // Remplacer par l'URL réelle de ton API

// Initialisation de la connexion à l'API avec CURL
$curlConnection = curl_init();

// Paramètres de la requête CURL
$params = array(
CURLOPT_URL => $apiUrl,
CURLOPT_RETURNTRANSFER => true,
CURLOPT_HTTPHEADER => array('Content-Type: application/json')
);

// Exécution de la requête CURL
curl_setopt_array($curlConnection, $params);
$response = curl_exec($curlConnection);
curl_close($curlConnection);

// Vérifier si la requête a échoué
if (!$response) {
echo "Erreur CURL : " . curl_error($curlConnection);
return array('error' => 'Erreur de connexion à l\'API');
}

// Décoder la réponse JSON
$response = json_decode($response, true);

// Vérification de la réponse de l'API
if (isset($response['success']) && $response['success'] === true) {
// Transformer chaque commande en objet Commande
$commandes = [];
foreach ($response['data'] as $commandeData) {
$produits = [];
foreach ($commandeData['produits'] as $produitData) {
// Transformer chaque produit en objet Produit
$produits[] = new Produit($produitData['name'], $produitData['quantity'], $produitData['price']);
}

// Créer l'objet Commande
$commandes[] = new Commande(
$commandeData['id'],
$produits,
$commandeData['prixTotal'],
$commandeData['dateCommande']
);
}
return $commandes;
} else {
// Si l'utilisateur n'a pas de commandes ou si une erreur est survenue
return array(
'success' => false,
'message' => 'Aucune commande trouvée pour cet utilisateur.',
'details' => $response['message'] ?? 'Aucune description d\'erreur fournie.'
);
}
}
}
