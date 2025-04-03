<?php

namespace service;

/**
 * Interface PanierAccessInterface
 *
 * Cette interface définit la méthode nécessaire pour accéder aux paniers disponibles.
 * Elle permet de récupérer tous les paniers disponibles via une API.
 */
interface PanierAccessInterface {
    /**
     * Récupère tous les paniers disponibles via l'API.
     *
     * Cette méthode doit retourner un tableau contenant tous les paniers disponibles.
     * Les paniers peuvent contenir des informations telles que le nom, le prix, la quantité et d'autres détails associés.
     *
     * @return array Un tableau contenant tous les paniers disponibles. Si aucun panier n'est disponible, le tableau peut être vide.
     */
    public function getAllPaniers(): array;
}
