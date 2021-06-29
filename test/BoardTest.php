<?php 

require_once 'board.php';
require_once 'ship.php';
use PHPUnit\Framework\TestCase;


class BoardTest extends TestCase
{

  public function testBoardInitialization() {
    $board = new Board(4);
    
    $this->assertTrue($board->board_dimension == 4);
  }

  public function testMakeBoardArray() {
    $board1 = new Board(2);
    $board_array1 = $board1->make_board_array();
    $expected_board_array1 = array('A1', 'A2', 'B1', 'B2');

    $this->assertTrue($board_array1 == $expected_board_array1);

    $board2 = new Board(3);
    $board_array2 = $board2->make_board_array();
    $expected_board_array2 = array('A1', 'A2', 'A3', 'B1', 'B2', 'B3', 'C1', 'C2', 'C3');

    $this->assertTrue($board_array2 == $expected_board_array2);
  }

  // public function testIsValidPlacement() {
  //   $board = new Board(4);
  //   $coordinates = array("A1", "A2");
  //   $ship = new Ship("Submarine", 2);

  //   $this->assertTrue($board->is_valid_placement($coordinates, $ship));
  // }
}

// phpunit ShipTest