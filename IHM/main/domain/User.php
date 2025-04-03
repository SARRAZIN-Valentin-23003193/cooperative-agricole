<?php

namespace domain;

/**
 * Classe User qui représente un utilisateur dans le système.
 * Un utilisateur possède un identifiant et un email.
 */
class User
{
    private $id;
    private $email;

    public function __construct($id, $email)
    {
        $this->id = $id;
        $this->email = $email;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

}
