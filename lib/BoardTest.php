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

  public function testIsValidCoordinate() {
    $board = new Board(4);
    $coordinate1 = 'A1';
    $coordinate2 = 'Z1';

    $this->assertTrue($board->is_valid_coordinate($coordinate1));
  }

  public function testPlace() {
    $board = new Board(4);
    $ship = new Ship("Submarine", 2);
    $coordinates1 = ['A1', 'A2'];
    $coordinates2 = ['B1', 'Z1'];

    $board->place($coordinates1, $ship);

    $this->assertTrue($board->cells['A1']->ship == $ship);
    $this->assertTrue($board->cells['A2']->ship == $ship);
    
    $this->assertTrue($board->cells['B1']->ship == null);
    $this->assertFalse($board->place($coordinates2, $ship));
  }

  public function testTopRow() {
    $board1 = new Board(2);
    $board2 = new Board(4);
    $board3 = new Board(7);

    $this->assertTrue($board1->top_row() == '1 2');
    $this->assertTrue($board2->top_row() == '1 2 3 4');
    $this->assertTrue($board3->top_row() == '1 2 3 4 5 6 7');
  }

  public function testRender() {
    $board = new Board(4);
    $cruiser = new Ship("Crusier", 3);
    $board->place(["A1", "A3", "A2"], $cruiser);

    // it renders the starting board with all . s
    $this->assertTrue($board->render() == "  1 2 3 4 \nA . . . . \nB . . . . \nC . . . . \nD . . . . \n");

  //   it 'renders the board with ships hidden if show_ships = false'
    $this->assertTrue($board->render() == "  1 2 3 4 \nA . . . . \nB . . . . \nC . . . . \nD . . . . \n");

  //   it 'renders the board with ships shown if show_ships = true'
    $this->assertTrue($board->render(true) == "  1 2 3 4 \nA S S S . \nB . . . . \nC . . . . \nD . . . . \n");
 
  //   it 'renders the board with M where applicable'
    $board->cells['A4']->fire_upon();
    $this->assertTrue($board->render() == "  1 2 3 4 \nA . . . M \nB . . . . \nC . . . . \nD . . . . \n");

  //   it 'renders the board with H where applicable'
    $board->cells['A1']->fire_upon();
    $this->assertTrue($board->render() == "  1 2 3 4 \nA H . . M \nB . . . . \nC . . . . \nD . . . . \n");

  //   it 'renders the board with X where applicable' do
  $board->cells['A2']->fire_upon();
  $board->cells['A3']->fire_upon();
  $this->assertTrue($board->render() == "  1 2 3 4 \nA X X X M \nB . . . . \nC . . . . \nD . . . . \n");
  }

  public function testMakeHitCellsArr() {
    $board = new Board(4);
    $cruiser = new Ship("Cruiser", 3);
    $tug = new Ship("Tug Boat", 1);
    $board->place(['A1', 'A2', 'A3'], $cruiser);
    $board->place(['A4'], $tug);

    // it 'returns an empty array if no ships have been hit without being sunk' do
    $this->assertTrue($board->make_hit_cells_arr() == []);

    //   it 'returns an empty array if the only ships hit have been sunk' do
    $board->cells['A4']->fire_upon();
    $this->assertTrue($board->make_hit_cells_arr() == []);

    //   it 'returns an array of cells containing ships that have been hit but not sunk' do
    $board->cells['A1']->fire_upon();
    $board->cells['A2']->fire_upon();
    $this->assertTrue($board->make_hit_cells_arr() == ['A1', 'A2']);
  }
}
