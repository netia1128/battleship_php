<?php 

require_once 'player.php';
require_once 'ship_generator.php';
require_once 'evaluator.php';
require_once 'board.php';
require_once 'ship.php';

use PHPUnit\Framework\TestCase;


class PlayerTest extends TestCase {

  public function testPlayerConstruct() {
    $player = new Player(2);
    
    $this->assertTrue($player->board_dimension == 2);
    $this->assertTrue(is_a($player->board, 'Board'));
    $this->assertTrue($player->shots_available == ['A1', 'A2', 'B1', 'B2']);
    $this->assertTrue(is_a($player->evaluator, 'Evaluator'));
    $this->assertTrue(count($player->ships) == 3);
    $this->assertTrue(is_a($player->ships[0], 'Ship'));
  }

  public function testSetRandomPivotPoint() {
    $player = new Player(2);
    $pivot_point = $player->setRandomPivotPoint();

    $this->assertTrue(in_array($pivot_point, ['A1', 'A2', 'B1', 'B2']));
  }

  public function testSetPivotPointIndex() {
    $player = new Player(2);

    $this->assertTrue($player->setPivotPointIndex('A2') == 1);
  }

  public function testAttemptAutoShipPlacement() {
    $player = new Player(4);
    $ship = $player->ships[0];


    $wip_array = $player->attemptAutoShipPlacement($ship);

    $this->assertTrue(count($wip_array) == 3);

    $cell1 = $player->board->cells[$wip_array[0]];
    $cell2 = $player->board->cells[$wip_array[1]];
    $cell3 = $player->board->cells[$wip_array[2]];

    $this->assertTrue($cell1->ship === $ship);
    $this->assertTrue($cell2->ship === $ship);
    $this->assertTrue($cell3->ship === $ship);
  }

  public function testSetDirection() {
    $player = new Player(4);
    $movement_array = [-1, 4];

    $this->assertTrue($player->setDirection($movement_array) == -1 || 4);
  }

  public function testUpdateProposedCoordinateIndex() {
    $player = new Player(4);
    
    $this->assertTrue($player->updateProposedCoordinateIndex(4, -1) == 3);
  }

  public function testUpdateProposedCoordinate() {
    $player = new Player(4);

    $this->assertTrue($player->updateProposedCoordinate(0) == 'A1');
    $this->assertTrue($player->updateProposedCoordinate(4) == 'B1');
  }

  public function testFireUpon() {
    $player = new Player(2);

    $cell_status = $player->board->cells['A1']->status;
    $this->assertTrue($cell_status === '.');


    $player->fireUpon('A1');

    $cell_status = $player->board->cells['A1']->status;

    $this->assertTrue($cell_status === 'M');
    $this->assertFalse($player->fireUpon('A1'));
  }

  public function testRandomShot() {
    $player = new Player(1);

    $this->assertTrue($player->shots_available === ['A1']);

    $player->randomShot();

    $this->assertTrue($player->shots_available === []);
  }

  public function testAutoShipPlacement() {
    $player = new Player(4);
    $cells = $player->board->cells;
    $cells_with_ships = 0;

    $player->autoShipPlacement();

    foreach($cells as $cell) {
      if($cell->status === 'S') {
        $cells_with_ships += 1;
      }
    }

    $this->assertTrue($cells_with_ships === 6);
  }

  public function testAutoShotSelection() {
    $player = new Player(4);
    
    $player->autoShotSelection();

    $this->assertTrue(count($player->shots_available) === 15);

    $player->autoShotSelection("HARD");
    
    $this->assertTrue(count($player->shots_available) === 14);
  }

  public function testSmartShot() {
    $player = new Player(4);
    $player->board->cells['A1']->status = 'H';
    $player->autoShotSelection("HARD");
    
    $cell_a2_status = $player->board->cells['A2']->status;
    $cell_b1_status = $player->board->cells['B1']->status;

    $this->assertTrue(count($player->shots_available) === 15);
    $this->assertTrue($cell_a2_status || $cell_b1_status === 'M');
  }
}