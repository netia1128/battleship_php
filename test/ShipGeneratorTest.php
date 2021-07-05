<?php 

require(__DIR__.'/../lib/Ship.php');
require_once(__DIR__.'/../lib/ShipGenerator.php');

use PHPUnit\Framework\TestCase;

class ShipGeneratorTest extends TestCase 
{

  public function testShipGeneratorInitialization() 
  {
    $ship_generator = new ShipGenerator;
    
    $this->assertTrue(count($ship_generator->ships) == 3);
    $this->assertTrue(is_a($ship_generator->ships[0], 'Ship'));
  }

  public function testMakeShips() 
  {
    $ship_generator = new ShipGenerator;
    $ship_generator->make_ships();
    
    $this->assertTrue(count($ship_generator->ships) == 3);
    $this->assertTrue(is_a($ship_generator->ships[0], 'Ship'));
  }
}
