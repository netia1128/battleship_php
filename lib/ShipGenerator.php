<?php

require_once(__DIR__.'/../lib/Ship.php');

class ShipGenerator 
{
  public function __construct() 
  {
    $ships = $this->make_ships();
  }

  public function make_ships() 
  {
    $cruiser = new Ship("Cruiser", 3);
    $submarine = new Ship("Submarine", 2);
    $tug_boat = new Ship("Tug Boat", 1);
    $this->ships = [$cruiser, $submarine, $tug_boat];
    return $this->ships;
  }
}