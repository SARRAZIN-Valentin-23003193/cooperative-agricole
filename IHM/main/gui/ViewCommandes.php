<?php
namespace gui;

/**
 * Classe ViewCommandes qui est responsable de l'affichage des commandes.
 * Elle prend les données des commandes et les rend dans un format HTML via un modèle de layout.
 */
class ViewCommandes
{
    private $layout;

    /**
     * Constructeur de la classe ViewCommandes.
     *
     * @param Layout $layout L'objet Layout qui sert à gérer le modèle de la page.
     */
    public function __construct($layout)
    {
        $this->layout = $layout;
    }

    /**
     * Affiche la liste des commandes.
     *
     * Cette méthode génère du contenu HTML en fonction des commandes passées et les rend dans le template de layout.
     *
     * @param array $commandes Un tableau d'objets Commande à afficher. Si vide ou si une erreur est présente, un message d'absence de commandes est affiché.
     */
    public function display($commandes)
    {
        // Début du contenu HTML
        $content = "<h2>Liste des Commandes</h2>";

        // Vérification si des commandes existent
        if (!empty($commandes) && !isset($commandes['error'])) {
            $content .= "<table border='1' cellpadding='10' cellspacing='0' style='width: 100%; text-align: center;'>
                <tr>
                    <th>ID Commande</th>
                    <th>Produits</th>
                    <th>Prix Total (€)</th>
                    <th>Date de Commande</th>
                </tr>";

            // Affichage des commandes
            foreach ($commandes as $commande) {
                $content .= "<tr>
                    <td>{$commande->getId()}</td>
                    <td>";

                // Affichage des produits associés à la commande
                if (!empty($commande->getProduits())) {
                    foreach ($commande->getProduits() as $produit) {
                        $content .= "Nom: {$produit->getName()}<br>Quantité: {$produit->getQuantity()}<br>Prix: {$produit->getPrice()} €<br><br>";
                    }
                } else {
                    $content .= "Aucun produit dans cette commande.";
                }

                // Affichage du prix total et de la date de commande
                $content .= "</td>
                    <td>{$commande->getPrixTotal()} €</td>
                    <td>{$commande->getDateCommande()}</td>
                </tr>";
            }

            $content .= "</table>";
        } else {
            $content .= "<p>Aucune commande disponible.</p>";
        }

        // Rendu final avec le layout
        $this->layout->render($content);
    }
}
