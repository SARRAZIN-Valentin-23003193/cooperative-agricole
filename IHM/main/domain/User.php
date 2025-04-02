<?php

namespace domain;

class User
{
    private $id;
    private $email;
    private $name;

    public function __construct($id, $email, $name)
    {
        $this->id = $id;
        $this->email = $email;
        $this->name = $name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getName()
    {
        return $this->name;
    }
}
