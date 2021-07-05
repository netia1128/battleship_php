<?php

class Ship {

  public $name;
  public $length;
  public $health;

  public function __construct($name, $length) 
  {
    $this->name = $name;
    $this->length = $length;
    $this->health = $length;
  }

  public function is_sunk() 
  {
    return($this->health === 0);
  }

  public function hit() 
  {
    $this->health--;
  }
}