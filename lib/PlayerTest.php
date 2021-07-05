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

  public function testset_random_pivot_point() {
    $player = new Player(2);
    $pivot_point = $player->set_random_pivot_point();

    $this->assertTrue(in_array($pivot_point, ['A1', 'A2', 'B1', 'B2']));
  }

  public function testset_pivot_point_index() {
    $player = new Player(2);

    $this->assertTrue($player->set_pivot_point_index('A2') == 1);
  }

  public function test_attempt_auto_ship_placement() {
    $player = new Player(4);
    $ship = $player->ships[0];


    $wip_array = $player->attempt_auto_ship_placement($ship);

    $this->assertTrue(count($wip_array) == 3);

    $cell1 = $player->board->cells[$wip_array[0]];
    $cell2 = $player->board->cells[$wip_array[1]];
    $cell3 = $player->board->cells[$wip_array[2]];

    $this->assertTrue($cell1->ship === $ship);
    $this->assertTrue($cell2->ship === $ship);
    $this->assertTrue($cell3->ship === $ship);
  }

  public function testset_direction() {
    $player = new Player(4);
    $movement_array = [-1, 4];

    $this->assertTrue($player->set_direction($movement_array) == -1 || 4);
  }

  public function testupdate_proposed_coordinate_index() {
    $player = new Player(4);
    
    $this->assertTrue($player->update_proposed_coordinate_index(4, -1) == 3);
  }

  public function testupdate_proposed_coordinate() {
    $player = new Player(4);

    $this->assertTrue($player->update_proposed_coordinate(0) == 'A1');
    $this->assertTrue($player->update_proposed_coordinate(4) == 'B1');
  }

  public function test_fire_upon() {
    $player = new Player(2);

    $cell_status = $player->board->cells['A1']->status;
    $this->assertTrue($cell_status === '.');


    $player->fire_upon('A1');

    $cell_status = $player->board->cells['A1']->status;

    $this->assertTrue($cell_status === 'M');
    $this->assertFalse($player->fire_upon('A1'));
  }

  public function test_random_shot() {
    $player = new Player(1);

    $this->assertTrue($player->shots_available === ['A1']);

    $player->random_shot();

    $this->assertTrue($player->shots_available === []);
  }

  public function test_auto_ship_placement() {
    $player = new Player(4);
    $cells = $player->board->cells;
    $cells_with_ships = 0;

    $player->auto_ship_placement();

    foreach($cells as $cell) {
      if($cell->status === 'S') {
        $cells_with_ships += 1;
      }
    }

    $this->assertTrue($cells_with_ships === 6);
  }

  public function test_auto_shot_selection() {
    $player = new Player(4);
    
    $player->auto_shot_selection();

    $this->assertTrue(count($player->shots_available) === 15);

    $player->auto_shot_selection("HARD");
    
    $this->assertTrue(count($player->shots_available) === 14);
  }

  public function testsmart_shot() {
    $player = new Player(4);
    $player->board->cells['A1']->status = 'H';
    $player->auto_shot_selection("HARD");
    
    $cell_a2_status = $player->board->cells['A2']->status;
    $cell_b1_status = $player->board->cells['B1']->status;

    $this->assertTrue(count($player->shots_available) === 15);
    $this->assertTrue($cell_a2_status || $cell_b1_status === 'M');
  }
}
