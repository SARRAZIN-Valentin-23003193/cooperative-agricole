<?php

namespace service;

interface UserAccessInterface
{
    public function authenticateUser($email, $password);
}
