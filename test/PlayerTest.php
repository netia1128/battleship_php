<?php 

require_once 'player.php';
require_once 'ship_generator.php';
require_once 'evaluator.php';
require_once 'board.php';
require_once 'ship.php';

use PHPUnit\Framework\TestCase;


class PlayerTest extends TestCase {

  public function testPlayerConstruct() {
    $player = new Player(4);
    
    $this->assertTrue($player->board_dimension == 4);
    $this->assertTrue(is_a($player->board, 'Board'));
    $this->assertTrue(is_a($player->evaluator, 'Evaluator'));
    $this->assertTrue(count($player->ships) == 3);
    $this->assertTrue(is_a($player->ships[0], 'Ship'));
    $this->assertTrue($player->last_shot_coordinate == '');
  }
}
