<?php 

require(__DIR__.'/../lib/Ship.php');
require(__DIR__.'/../lib/Cell.php');

use PHPUnit\Framework\TestCase;

class CellTest extends TestCase 
{

  public function test_cell_initialization() 
  {
    $cell = new Cell("A4");
    $coordinate = $cell->coordinate;
    $status = $cell->status;
    $ship = $cell->ship;
    $expected_coordinate = "A4";
    $expected_status = ".";
    $expected_ship = null;

    $this->assertTrue($coordinate == $expected_coordinate);
    $this->assertTrue($status == $expected_status);
    $this->assertTrue($ship== $expected_ship);
  }

  public function test_cell_emptiness() 
  {
    $cell = new Cell("A4");

    $this->assertTrue($cell->is_empty());
  }

  public function test_cell_place_ship() 
  {
    $cell = new Cell("A4");
    $tug = new Ship("Tug Boat", 1);
    $cell->place_ship($tug);

    $ship = $cell->ship;
    $status = $cell->status;
    $expected_status = "S";

    $expected_ship = $tug;

    $this->assertTrue($status == $expected_status);
    $this->assertTrue($ship== $expected_ship);
  }

  public function test_cell_is_fired_upon() 
  {
    $cell = new Cell("A4");

    $this->assertFalse($cell->is_fired_upon());

    $tug = new Ship("Tug Boat", 1);
    $cell->place_ship($tug);
    $cell->fire_upon();

    $this->assertTrue($cell->is_fired_upon());
  }

  public function test_fire_upon() 
  {
    $cell_1 = new Cell("A4");
    $cell_1->fire_upon();

    $this->assertTrue($cell_1->status == "M");

    $cell_2 = new Cell("B2");
    $tug = new Ship("Tug Boat", 1);
    $cell_2->place_ship($tug);
    $cell_2->fire_upon();

    $this->assertTrue($tug->is_sunk());
    $this->assertTrue($cell_2->status == 'X');

    $cell_3 = new Cell("A2");
    $sub = new Ship("Submarine", 2);
    $cell_3->place_ship($sub);
    $cell_3->fire_upon();

    $this->assertFalse($sub->is_sunk());
    $this->assertTrue($cell_3->status == 'H');
  }

  public function test_cell_render() 
  {
    // Verify that an empty cell renders as "."
    $cell_1 = new Cell("A4");

    $this->assertTrue($cell_1->render() == ".");

    // Verify that an empty cell renders as "M" after being fired upon
    $cell_1->fire_upon();

    $this->assertTrue($cell_1->render() == "M");

    // Verify that a cell with a ship in it renders as "." unless default is overridden
    $cell_2 = new Cell("B2");
    $tug = new Ship("Tug Boat", 1);
    $cell_2->place_ship($tug);

    $this->assertTrue($cell_2->render() == ".");
    $this->assertTrue($cell_2->render(true) == "S");
  
    // Verufy that cell with sunk ship renders as "X"
    $cell_2->fire_upon();

    $this->assertTrue($tug->is_sunk());
    $this->assertTrue($cell_2->status == 'X');

    // Verify that cell with unsunk ship renders as "H" after being hit
    $cell_3 = new Cell("A2");
    $sub = new Ship("Submarine", 2);
    $cell_3->place_ship($sub);
    $cell_3->fire_upon();

    $this->assertFalse($sub->is_sunk());
    $this->assertTrue($cell_3->status == 'H');
  }
}
