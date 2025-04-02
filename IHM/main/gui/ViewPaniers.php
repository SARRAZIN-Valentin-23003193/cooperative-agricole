<?php
namespace gui;

require_once 'Layout.php';

class ViewPaniers {
private $layout;
private $paniers;

public function __construct($layout, $paniers) {
$this->layout = $layout;
$this->paniers = $paniers;
}

public function display()
{
// Vérifier les paniers reçus
var_dump($this->paniers);  // Pour vérifier si on reçoit bien les paniers

$content = "<h2>Liste des Paniers Disponibles</h2>";

// Vérifier si des paniers existent
if (!empty($this->paniers) && !isset($this->paniers['error'])) {
$content .= "<table border='1' cellpadding='10' cellspacing='0' style='width: 100%; text-align: center;'>
    <tr>
        <th>ID</th>
        <th>Produits</th>
        <th>Prix Total (€)</th>
    </tr>";

    // Affichage des paniers
    foreach ($this->paniers as $panier) {
    $content .= "<tr>
        <td>{$panier->getId()}</td>
        <td>";

            // Vérification des produits dans le panier
            var_dump($panier->getProduits());  // Vérifier les produits dans chaque panier

            // Affichage des produits associés à ce panier
            if (!empty($panier->getProduits())) {
            foreach ($panier->getProduits() as $produit) {
            $content .= "Nom: {$produit['name']} <br>Quantité: {$produit['quantity']} <br>Prix: {$produit['price']} €<br><br>";
            }
            } else {
            $content .= "Aucun produit dans ce panier.";
            }

            // Affichage du prix total du panier
            $content .= "</td>
        <td>{$panier->getPrixTotal()} €</td>
    </tr>";
    }

    $content .= "</table>";
} else {
$content .= "<p>Aucun panier disponible.</p>";
}

// Vérification du contenu avant de le rendre
var_dump($content);  // Pour vérifier le contenu avant de l'afficher

// Rendu final avec le layout
$this->layout->render($content);
}
}
