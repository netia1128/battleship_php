<?php 

require(__DIR__.'/../lib/Ship.php');

use PHPUnit\Framework\TestCase;

class ShipTest extends TestCase
{
  public function test_ship_initialization() 
  {
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

  public function test_ship_hit() 
  {
    $ship = new Ship("Destroyer", 4);
    $ship->hit();
    $health = $ship->health;
    $expected_health = 3;
    $this->assertTrue($health == $expected_health);
  }

  public function test_ship_sunk() 
  {
    $ship = new Ship("Destroyer", 4);

    $this->assertFalse($ship->is_sunk());

    $ship->hit();
    $ship->hit();
    $ship->hit();
    $ship->hit();

    $this->assertTrue($ship->is_sunk());
  }
}