<?php 

require_once 'ship_generator.php';
require_once 'ship.php';

use PHPUnit\Framework\TestCase;


class ShipGeneratorTest extends TestCase {

  public function testShipGeneratorInitialization() {
    $ship_generator = new ShipGenerator;
    
    $this->assertTrue($ship_generator->ships == []);
  }

  public function testMakeShips() {
    $ship_generator = new ShipGenerator;
    $ship_generator->make_ships();
    
    $this->assertTrue(count($ship_generator->ships) == 3);
    $this->assertTrue(is_a($ship_generator->ships[0], 'Ship'));
  }
}
