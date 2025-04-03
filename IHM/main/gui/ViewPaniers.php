<?php
namespace gui;

require_once 'Layout.php';

/**
 * Classe ViewPaniers qui est responsable de l'affichage des paniers disponibles.
 * Elle génère une vue des paniers avec leurs produits associés et affiche des informations
 * comme le prix total et la quantité totale. Si aucun panier n'est disponible, elle affiche
 * un message approprié.
 */
class ViewPaniers {
    private $layout;
    private $paniers;

    /**
     * Constructeur de la classe ViewPaniers.
     *
     * @param Layout $layout L'objet Layout utilisé pour rendre le modèle de la page.
     * @param array $paniers Un tableau d'objets Panier à afficher.
     */
    public function __construct($layout, $paniers) {
        $this->layout = $layout;
        $this->paniers = $paniers;
    }

    /**
     * Affiche le contenu des paniers disponibles.
     *
     * Cette méthode génère le contenu HTML pour afficher les informations des paniers, y
     * compris les produits qu'ils contiennent. Si aucun panier n'est disponible, un message
     * approprié est affiché.
     */
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
