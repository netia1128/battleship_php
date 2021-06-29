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
}

// phpunit ShipTest