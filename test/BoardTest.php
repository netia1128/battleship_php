<?php 

require_once 'board.php';
require_once 'ship.php';
use PHPUnit\Framework\TestCase;


class BoardTest extends TestCase
{

  public function testBoardInitialization() {
    $board = new Board(4);
    
    $this->assertTrue($board->board_dimension == 4);
    $this->assertTrue(count($board->cells) == 16);
  }

  public function testMakeBoardArray() {
    $board1 = new Board(2);
    $board1_array = $board1->make_board_array();
    $board1_array_keys = array_keys($board1_array);
    $board1_cell1 = $board1_array['A1'];
    $expected_board1_keys = array('A1', 'A2', 'B1', 'B2');

    $this->assertTrue($board1_array_keys == $expected_board1_keys);
    $this->assertTrue(is_a($board1_cell1, 'Cell'));
  }

  public function testIsValidPlacement() {
    $board = new Board(4);
    $ship = new Ship("Submarine", 2);
    
    // valid placement
    $coordinates1 = array("A1", "A2");
    $this->assertTrue($board->is_valid_placement($coordinates1, $ship));

    // invalid placement - non-consecutive cellscoordinates
    $coordinates2 = array("A1", "A3");
    $this->assertTrue($board->is_valid_placement($coordinates2, $ship) == null);

    // invalid placement - too-many coordinates
    $coordinates3 = array("A1", "A3", "A2");
    $this->assertTrue($board->is_valid_placement($coordinates3, $ship) == null);

    // invalid placement - duplicate coordinates
    $coordinates4 = array("A1", "A1");
    $this->assertTrue($board->is_valid_placement($coordinates4, $ship) == null);

    // invalid placement - coordinates not empty
    $coordinates4 = array("A1", "A2");
    $board->cells['A1']->place_ship($ship);
    $this->assertTrue($board->is_valid_placement($coordinates4, $ship) == null);
  }
}

// phpunit ShipTest