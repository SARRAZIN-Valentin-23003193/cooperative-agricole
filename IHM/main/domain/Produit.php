<?php
namespace domain;

class Produit
{
private $name;
private $quantity;
private $price;

public function __construct($name, $quantity, $price)
{
$this->name = $name;
$this->quantity = $quantity;
$this->price = $price;
}

public function getName()
{
return $this->name;
}

public function getQuantity()
{
return $this->quantity;
}

public function getPrice()
{
return $this->price;
}
}
