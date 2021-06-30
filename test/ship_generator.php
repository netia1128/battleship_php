<?php

require_once 'ship.php';

class ShipGenerator {

  public function __construct() {
    $this->make_ships();
  }

  public function make_ships() {
    $cruiser = new Ship("Cruiser", 3);
    $submarine = new Ship("Submarine", 2);
    $tug_boat = new Ship("Tug Boat", 1);
    $this->ships = [$cruiser, $submarine, $tug_boat];
    return $this->ships;
  }

  // def make_ships
  //   cruiser = Ship.new("Cruiser", 3)
  //   submarine = Ship.new("Submarine", 2)
  //   tug_boat = Ship.new("Tug Boat", 1)
  //   @ships = [cruiser, submarine, tug_boat]
  // end
}

?>
