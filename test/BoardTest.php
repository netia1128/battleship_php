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
    $board = new Board(4);
    $board_array = $board->make_board_array();

    $this->assertTrue($board_array == null);
  }

  public function testIsValidPlacement() {
    $board = new Board(4);
    $coordinates = array("A1", "A2");
    $ship = new Ship("Submarine", 2);

    $this->assertTrue($board->is_valid_placement($coordinates, $ship));
  }
}

// phpunit ShipTest