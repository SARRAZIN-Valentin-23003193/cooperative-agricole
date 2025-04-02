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
// Début du contenu de la page
$content = "<h2>Liste des Paniers Disponibles</h2>";
// Si des paniers existent

    if (!empty($this->paniers)) {
// Affichage brut de l'objet panier pour débogage

    foreach ($this->paniers as $panier) {
$content .= "<pre>";
                $content .= "ID: " . $panier->getId() . "\n";
                $content .= "Prix Total: " . $panier->getPrixTotal() . "\n";

                $produits = $panier->getProduits();
                if (!empty($produits)) {
                    foreach ($produits as $produit) {
                        $content .= "Nom: " . $produit['name'] . ", ";
                        $content .= "Quantité: " . $produit['quantity'] . ", ";
                        $content .= "Prix: " . $produit['price'] . "\n";
                    }
                } else {
                    $content .= "Aucun produit dans ce panier.\n";
                }
                $content .= "</pre>";

}
} else {

$content .= "<p>Aucun panier disponible.</p>";
}

// Appel du render pour afficher le contenu avec le layout
$this->layout->render($content);
}
}
