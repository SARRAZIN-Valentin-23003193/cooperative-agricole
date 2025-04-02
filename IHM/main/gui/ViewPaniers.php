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
            $content .= "<div class='panier-container'>";

            foreach ($this->paniers as $panier) {
                $content .= "<div class='panier'>";
                $content .= "<h3>Panier : " . htmlspecialchars($panier->getNom()) . "</h3>";
                $content .= "<p><strong>ID:</strong> " . htmlspecialchars($panier->getId()) . "</p>";
                $content .= "<p><strong>Prix Total:</strong> " . htmlspecialchars($panier->getPrixTotal()) . " €</p>";
                $content .= "<p><strong>Quantité Totale:</strong> " . htmlspecialchars($panier->getQuantiteTotale()) . "</p>";

                $produits = $panier->getProduits();
                if (!empty($produits)) {
                    $content .= "<h4>Produits :</h4><ul>";
                    foreach ($produits as $produit) {
                        $content .= "<li>";
                        $content .= "<strong>Nom:</strong> " . htmlspecialchars($produit->getNom()) . " - ";
                        $content .= "<strong>Quantité:</strong> " . htmlspecialchars($produit->getQuantite()) . " - ";
                        $content .= "<strong>Prix:</strong> " . htmlspecialchars($produit->getPrix()) . " €";
                        $content .= "</li>";
                    }
                    $content .= "</ul>";
                } else {
                    $content .= "<p>Aucun produit dans ce panier.</p>";
                }

                $content .= "</div>";
            }

            $content .= "</div>";
        } else {
            $content .= "<p>Aucun panier disponible.</p>";
        }

        // Bouton retour à l'accueil
        $content .= "<div>
                        <a href='index.php?action=home'>
                            Retour à l'accueil
                        </a>
                     </div>";

        // Appel du render pour afficher le contenu avec le layout
        $this->layout->render($content);
    }
}
