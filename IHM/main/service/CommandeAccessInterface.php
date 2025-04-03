<?php

namespace service;

/**
 * Interface CommandeAccessInterface
 *
 * Cette interface définit les méthodes nécessaires pour accéder aux commandes d'un utilisateur.
 * Elle permet de récupérer toutes les commandes existantes pour un utilisateur donné à partir de son ID.
 */
interface CommandeAccessInterface
{
    /**
     * Récupère toutes les commandes existantes d'un utilisateur en utilisant son ID.
     *
     * @param string $userId L'ID de l'utilisateur dont on veut récupérer les commandes.
     * @return array Une liste des commandes de l'utilisateur.
     */
    public function getCommandesByUserId($userId): array;
}
