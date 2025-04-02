<?php

namespace service;

interface ProduitAccessInterface
{
    /**
     * Crée un produit.
     *
     * @param string $nom Le nom du produit.
     * @param float $prix Le prix du produit.
     * @param int $quantiteDispo La quantité disponible du produit.
     * @param string $unite L'unité de mesure du produit (kg, unité, douzaine, etc.).
     * @return bool True si le produit est ajouté avec succès, sinon false.
     */
    public function createProduct($nom, $prix, $quantiteDispo, $unite);

    /**
     * Récupère un produit par son ID.
     *
     * @param int $id L'ID du produit.
     * @return \domain\Produit|null L'objet Produit si trouvé, sinon null.
     */
    public function getProductById($id);
}
