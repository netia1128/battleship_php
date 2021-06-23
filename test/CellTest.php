<?php 

require_once 'cell.php';
require_once 'ship.php';

use PHPUnit\Framework\TestCase;


class CellTest extends TestCase {

  public function testCellInitialization() {
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

  public function testCellEmptiness() {
    $cell = new Cell("A4");

    $this->assertTrue($cell->is_empty());
  }

  public function testCellPlaceShip() {
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

  public function testCellIsFiredUpon() {
    $cell = new Cell("A4");

    $this->assertFalse($cell->is_fired_upon());

    $tug = new Ship("Tug Boat", 1);
    $cell->place_ship($tug);
    $cell->fire_upon();

    $this->assertTrue($cell->is_fired_upon());
  }

  public function testCellFireUpon() {
    $cell_1 = new Cell("A4");
    $cell_1->fire_upon();
    // $cell_1_status = $cell_1->status;

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
}

// phpunit CellTest