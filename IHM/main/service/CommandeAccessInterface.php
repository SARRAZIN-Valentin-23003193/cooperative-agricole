<?php

namespace service;

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
