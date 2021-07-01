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
    $this->assertTrue($player->last_shot_coordinate == '');
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
}
