<?php 

require_once 'cell.php';
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
}

// phpunit ShipTest