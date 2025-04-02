<?php

namespace service;

interface PanierAccessInterface
{
    /**
     * Crée un panier avec une liste de produits.
     *
     * @param array $produits Une liste de produits (id et quantité).
     * @return bool True si le panier est créé avec succès, sinon false.
     */
    public function createPanier($produits);

    /**
     * Récupère un panier par son ID.
     *
     * @param int $id L'ID du panier.
     * @return \domain\Panier|null L'objet Panier si trouvé, sinon null.
     */
    public function getPanierById($id);
}
