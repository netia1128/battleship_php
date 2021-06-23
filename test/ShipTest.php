require '.:/home/netia/projects/battleship_pp/ship.php';
<?php 

require_once 'ship.php';
use PHPUnit\Framework\TestCase;


class ShipTest extends TestCase
{

  public function setUp(): void {
      $sub = new Ship("Submarine", 1);
  }

  public function testShipInitialization() {
    $ship = new Ship("Destroyer", 4);
    $name = $ship->name;
    $length = $ship->length;
    $health = $ship->health;
    $expected_name = "Destroyer";
    $expected_length = 4;
    $expected_health = 4;
    $this->assertTrue($name == $expected_name);
    $this->assertTrue($length == $expected_length);
    $this->assertTrue($health == $expected_health);
  }

  public function testShipHit() {
    $ship = new Ship("Destroyer", 4);
    $ship->hit();
    $health = $ship->health;
    $expected_health = 3;
    $this->assertTrue($health == $expected_health);
  }

  public function testShipSunk() {
    $ship = new Ship("Destroyer", 4);
    $ship->hit();
    $ship->hit();
    $ship->hit();
    $ship->hit();
    $result = $ship->sunk();
    $this->assertTrue($result);
  }
}
