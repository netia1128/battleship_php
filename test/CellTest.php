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
    $result = $cell->is_empty();

    $this->assertTrue($result);
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
    $result = $cell->is_fired_upon();

    $this->assertFalse($result);
  }

  public function testCellFireUpon() {
    $cell = new Cell("A4");
    $cell->fire_upon();
    $status = $cell->status;

    $this->assertTrue($status == "M");

    $cell2 = new(Cell("B2"));
  }
}

// phpunit CellTest