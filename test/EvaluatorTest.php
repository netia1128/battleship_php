<?php 

require_once 'evaluator.php';
require_once 'board.php';
require_once 'ship.php';

use PHPUnit\Framework\TestCase;


class EvaluatorTest extends TestCase
{

  public function testEvaluatorInitialization() {
    $board = new Board(2);
    $evaluator = new Evaluator($board->cells);
    $evaluator_cell1 = $evaluator->cells['A1'];
    
    $this->assertTrue(count($evaluator->cells) == 4);
    $this->assertTrue(is_a($evaluator_cell1, 'Cell'));
    
  }

  public function testCoordinatesMatchShipLength() {
    $board = new Board(2);
    $evaluator = new Evaluator($board->cells);
    $ship = new Ship("Submarine", 2);
    $coordinates1 = ['A1', 'A2'];

    $this->assertTrue($evaluator->coordinates_match_ship_length($coordinates1, $ship));

    $ship = new Ship("Destroyer", 4);
    $coordinates2 = ['A1', 'A2'];

    $this->assertTrue($evaluator->coordinates_match_ship_length($coordinates2, $ship) == null);
  }

  public function testNoDuplicateCoordinates() {
    $board = new Board(2);
    $evaluator = new Evaluator($board->cells);
    $ship = new Ship("Submarine", 2);
    $coordinates = ['A1', 'A2'];

    $this->assertTrue($evaluator->no_duplicate_coordinates($coordinates));

    $coordinates = ['A1', 'A1'];

    $this->assertTrue($evaluator->no_duplicate_coordinates($coordinates) == null);
  }

  public function testCoordinatesEmpty() {
    $board = new Board(2);
    $evaluator = new Evaluator($board->cells);
    $coordinates = ['A1', 'A2'];
    
    $this->assertTrue($evaluator->coordinates_empty($coordinates, $evaluator->cells));
    
    $ship = new Ship("Submarine", 2);
    $evaluator->cells['A1']->place_ship($ship);

    $this->assertTrue($evaluator->coordinates_empty($coordinates, $evaluator->cells) == null);
  }

  public function testUserCoordinateLetters() {
    $board = new Board(2);
    $evaluator = new Evaluator($board->cells);

    $coordinates1 = ['A1', 'A2'];
    $expected_letter_coordinates1 = ['A', 'A'];
    $letter_coordinates1 = $evaluator->user_coordinate_letters($coordinates1);
    
    $this->assertTrue($expected_letter_coordinates1 == $letter_coordinates1);
    
    $coordinates2 = ['A1', 'B1'];
    $expected_letter_coordinates2 = ['A', 'B'];
    $letter_coordinates2 = $evaluator->user_coordinate_letters($coordinates2);
    
    $this->assertTrue($expected_letter_coordinates2 == $letter_coordinates2);
  }

  public function testUserCoordinateNumbers() {
    $board = new Board(2);
    $evaluator = new Evaluator($board->cells);

    $coordinates1 = ['A1', 'A2'];
    $expected_number_coordinates1 = [1, 2];
    $number_coordinates1 = $evaluator->user_coordinate_numbers($coordinates1);
    
    $this->assertTrue($expected_number_coordinates1 == $number_coordinates1);
    
    $coordinates2 = ['A1', 'B1'];
    $expected_number_coordinates2 = [1, 1];
    $number_coordinates2 = $evaluator->user_coordinate_numbers($coordinates2);
    
    $this->assertTrue($expected_number_coordinates2 == $number_coordinates2);
  }

  public function testIsHorizontal() {
    $board = new Board(2);
    $evaluator = new Evaluator($board->cells);

    $coordinates1 = ['A1', 'A2'];
    
    $this->assertTrue($evaluator->isHorizontal($coordinates1));
    
    $coordinates2 = ['A1', 'B1'];
    
    $this->assertTrue($evaluator->isHorizontal($coordinates2) == null);
  }

  public function testIsVertical() {
    $board = new Board(2);
    $evaluator = new Evaluator($board->cells);

    $coordinates1 = ['A1', 'A2'];
    
    $this->assertTrue($evaluator->isVertical($coordinates1) == null);
    
    $coordinates2 = ['A1', 'B1'];
    
    $this->assertTrue($evaluator->isVertical($coordinates2));
  }

  public function testIsConsecutive() {
    $board = new Board(2);
    $evaluator = new Evaluator($board->cells);
    $ship = new Ship("Submarine", 2);

    $coordinates1 = ['A1', 'A2'];
    
    $this->assertTrue($evaluator->is_consecutive($coordinates1, $ship));
    
    $coordinates2 = ['A1', 'C1'];
    
    $this->assertTrue($evaluator->is_consecutive($coordinates2, $ship) == null);

    $coordinates3 = ['A1', 'B1'];
    
    $this->assertTrue($evaluator->is_consecutive($coordinates3, $ship));
  }

  public function testIsHorizontalStartRow() {
    $board = new Board(2);
    $evaluator = new Evaluator($board->cells);

    $this->assertTrue($evaluator->isHorizontalStartRow(0, 2));
    $this->assertFalse($evaluator->isHorizontalStartRow(2, 2));
  }

  public function testIsHorizontalEndRow() {
    $board = new Board(2);
    $evaluator = new Evaluator($board->cells);

    $this->assertTrue($evaluator->isHorizontalEndRow(14, 4));
    $this->assertFalse($evaluator->isHorizontalEndRow(0, 2));
  }

  public function testIsVerticalStartRow() {
    $board = new Board(2);
    $evaluator = new Evaluator($board->cells);

    $this->assertTrue($evaluator->isVerticalStartRow(4, 4));
    $this->assertFalse($evaluator->isVerticalStartRow(6, 4));
  }

  public function testIsVerticalEndRow() {
    $board = new Board(2);
    $evaluator = new Evaluator($board->cells);

    $this->assertTrue($evaluator->isVerticalEndRow(3, 4));
    $this->assertFalse($evaluator->isVerticalEndRow(5, 4));
  }

  public function testCreateMovementArray() {
    $board = new Board(4);
    $evaluator = new Evaluator($board->cells);

    $this->assertTrue($evaluator->createMovementArray(1, 4) == [-4]);
    $this->assertTrue($evaluator->createMovementArray(14, 4) == [4]);
    $this->assertTrue($evaluator->createMovementArray(4, 4) == [-1]);
    $this->assertTrue($evaluator->createMovementArray(7, 4) == [1]);
    $this->assertTrue($evaluator->createMovementArray(3, 4) == [-4, 1]);
  }

  public function testIsHorizontalOrVertical() {
    $board = new Board(4);
    $evaluator = new Evaluator($board->cells);

    $this->assertTrue($evaluator->isHorizontalOrVertical(['A1', 'A2']));
    $this->assertTrue($evaluator->isHorizontalOrVertical(['A1', 'B1']));
    $this->assertFalse($evaluator->isHorizontalOrVertical(['A1', 'B2']));
  }
}
