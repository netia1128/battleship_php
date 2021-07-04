<?php

require_once 'ship_generator.php';
require_once 'evaluator.php';
require_once 'board.php';
require_once 'ship.php';

class Player {

  public $last_shot_coordinate;
  
  public function __construct($board_dimension) {
    $this->board_dimension = $board_dimension;
    $this->board = new Board($board_dimension);
    $this->shots_available = array_keys($this->board->cells);
    $this->evaluator = new Evaluator($this->board->cells);
    $ship_generator = new ShipGenerator;
    $this->ships = $ship_generator->ships;
    $this->last_shot_coordinate = '';
  }

  public function attempt_auto_ship_placement($ship) {
    $pivot_point = $this->set_random_pivot_point();
    $pivot_point_index = $this->set_pivot_point_index($pivot_point);
    $movement_array = $this->evaluator->createMovementArray($pivot_point_index, $this->board_dimension);
    $wip_array = [];
    do {
      $direction = $this->set_direction($movement_array);
      $proposed_coordinate = $pivot_point;
      $proposed_coordinate_index = $pivot_point_index;
      $wip_array = [];
      array_push($wip_array, $proposed_coordinate);
      while(count($wip_array) != $ship->length) {
        $proposed_coordinate_index = $this->update_proposed_coordinate_index($proposed_coordinate_index, $direction);
        $proposed_coordinate = $this->update_proposed_coordinate($proposed_coordinate_index);
        array_push($wip_array, $proposed_coordinate);
      }
      unset($movement_array[array_search($direction, $movement_array)]);
    }  while(!$this->board->place($wip_array, $ship));
    
    return $wip_array;
  }

  public function auto_ship_placement() {
    foreach($this->ships as $ship) {
      $this->attempt_auto_ship_placement($ship);
    }
  }

  public function auto_shot_selection($difficulty = "EASY") {
    $hit_cells_arr = $this->board->make_hit_cells_arr();
    if($difficulty === "HARD" && count($hit_cells_arr) > 0) {
      $this->smart_shot($hit_cells_arr);
    } else {
      $this->random_shot();
    }
  }

  public function fire_upon($shot_coordinate) {
    if($this->board->is_valid_coordinate($shot_coordinate)) {
      $cell = $this->board->cells[$shot_coordinate];
      if(!$this->board->cells[$shot_coordinate]->is_fired_upon()) {
        $cell->fire_upon();
      } else {
        return false;
      } 
    } else {
      return false;
    }
  }

  public function random_shot() {
    $this->last_shot_coordinate = $this->shots_available[array_rand($this->shots_available)];
    $this->fire_upon($this->last_shot_coordinate);
    unset($this->shots_available[array_search($this->last_shot_coordinate, $this->shots_available)]);
  }

  public function set_direction($movement_array) {
    if(empty($movement_array)) {
      return false;
    } else {
      $random_array_position = array_rand($movement_array, 1);
      $direction = $movement_array[$random_array_position];
      return $direction;
    }
  }

  public function set_pivot_point_index($pivot_point) {
    $cells = $this->board->cells;
    return array_search($pivot_point, array_keys($cells));
  }

  public function set_random_pivot_point() {
    $pivot_point = $this->shots_available[array_rand($this->shots_available)];
    while($this->evaluator->coordinates_empty([$pivot_point], $this->board->cells) == false) {
      $pivot_point = $this->shots_available[array_rand($this->shots_available)];
    }
    return $pivot_point;
  }

  public function smart_shot($hit_cells_arr) {
    $cells = array_keys($this->board->cells);
    $pivot_point = $hit_cells_arr[0];
    $pivot_point_index = $this->set_pivot_point_index($pivot_point);
    $movement_array = $this->evaluator->createMovementArray($pivot_point_index, $this->board_dimension);
    $direction = $this->set_direction($movement_array);
    $proposed_coordinate = $cells[$pivot_point_index + $direction];
    while($this->fire_upon($proposed_coordinate) === false) {
      unset($movement_array[array_search($direction, $movement_array)]);
      $direction = $this->set_direction($movement_array);
      if(!is_int($direction)) {
        $pivot_point = $hit_cells_arr[1];
        $pivot_point_index = $this->set_pivot_point_index($pivot_point);
        $movement_array = $this->evaluator->createMovementArray($pivot_point_index, $this->board_dimension);
        $direction = $this->set_direction($movement_array);
      }
      $proposed_coordinate_index = $this->update_proposed_coordinate_index($pivot_point_index, $direction);
      $proposed_coordinate = $this->update_proposed_coordinate($proposed_coordinate_index);
    }
    $this->last_shot_coordinate = $proposed_coordinate;
    unset($this->shots_available[array_search($proposed_coordinate, $this->shots_available)]);
  }
  
  public function update_proposed_coordinate_index($proposed_coordinate_index, $direction) {
    $new_proposed_coordinate_index = $proposed_coordinate_index += $direction;
    if($new_proposed_coordinate_index > -1 && $new_proposed_coordinate_index < count($this->board->cells)) {
      return($new_proposed_coordinate_index);
    } else {
      return null;
    }
  }

  public function update_proposed_coordinate($proposed_coordinate_index) {
    if($proposed_coordinate_index >= 0 && is_int($proposed_coordinate_index)) {
      $cells = $this->board->cells;
      $cell_coordinates = array_keys($cells);
      $new_coordinate = array_keys($cells)[$proposed_coordinate_index];
      return $new_coordinate;
    } else {
      return null;
    }
  }
}

?>
