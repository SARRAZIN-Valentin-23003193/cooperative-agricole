<?php

namespace service;

/**
 * Interface UserAccessInterface
 *
 * Cette interface définit la méthode nécessaire pour authentifier un utilisateur.
 * Elle permet de vérifier les informations de connexion d'un utilisateur (email et mot de passe).
 */
interface UserAccessInterface {

    /**
     * Authentifie un utilisateur avec son email et son mot de passe.
     *
     * Cette méthode doit envoyer les informations de connexion à l'API pour vérifier si l'utilisateur existe et si les informations sont valides.
     * Si les informations sont correctes, un objet représentant l'utilisateur doit être retourné. Sinon, null est retourné.
     *
     * @param string $email L'email de l'utilisateur.
     * @param string $password Le mot de passe de l'utilisateur.
     * @return \domain\User|null Un objet User si les informations sont valides, sinon null.
     */
    public function authenticateUser($email, $password);
}
