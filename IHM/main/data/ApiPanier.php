<?php
namespace data;

use service\PanierAccessInterface;
include_once "service/PanierAccessInterface.php";

use domain\Panier;
include_once "domain/Panier.php";

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

// Initialisation de la requête CURL
$curlConnection = curl_init();
$params = array(
CURLOPT_URL => $apiUrl,
CURLOPT_RETURNTRANSFER => true,
CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
);

curl_setopt_array($curlConnection, $params);
$response = curl_exec($curlConnection);
curl_close($curlConnection);

if (!$response) {
echo "Erreur CURL : " . curl_error($curlConnection);
return array('error' => 'Erreur de connexion à l\'API');
}

$response = json_decode($response, true);

// Vérifier si le JSON est bien un tableau
if (!is_array($response)) {
return array('error' => 'Réponse invalide de l\'API');
}

$paniers = array();

// Itérer sur chaque panier retourné par l'API
foreach ($response as $panierData) {
// Création de chaque panier avec ses informations
$panier = new Panier(
$panierData['basket_id'],   // basket_id
[                           // produits
'name' => $panierData['name'],
'quantity' => $panierData['quantity'],
'price' => $panierData['price']
],
$panierData['price']        // prixTotal
);
$paniers[] = $panier;
}

return $paniers;
}
}
