<?php 

require_once 'ship_generator.php';
require_once 'ship.php';

use PHPUnit\Framework\TestCase;


class ShipGeneratorTest extends TestCase {

  public function testShipGeneratorInitialization() {
    $ship_generator = new ShipGenerator;
    
    $this->assertTrue($ship_generator->ships == []);
  }
}
