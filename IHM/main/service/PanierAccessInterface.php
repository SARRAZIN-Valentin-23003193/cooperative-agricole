<?php

namespace service;

interface PanierAccessInterface
{

    /**
     * Récupère tous les paniers disponibles via l'API.
     *
     * @return array Un tableau contenant tous les paniers disponibles.
     */
    public function getAllPaniers(): array;
}
