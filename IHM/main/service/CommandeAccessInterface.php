<?php

namespace service;

interface CommandeAccessInterface
{
    /**
     * Crée une commande avec les paniers associés et le prix total.
     *
     * @param array $panierId L'ID du panier à inclure dans la commande.
     * @param string $retraitDate La date de retrait de la commande.
     * @param string $lieuRetrait Le lieu de retrait de la commande.
     * @return bool True si la commande est créée avec succès, sinon false.
     */
    public function createCommande($panierId, $retraitDate, $lieuRetrait);
}
