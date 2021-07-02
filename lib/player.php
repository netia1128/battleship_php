<?php

require_once 'ship_generator.php';
require_once 'evaluator.php';
require_once 'board.php';
require_once 'ship.php';

class Player {

  
  public function __construct($board_dimension) {
    $this->board_dimension = $board_dimension;
    $this->board = new Board($board_dimension);
    $this->shots_available = array_keys($this->board->cells);
    $this->evaluator = new Evaluator($this->board->cells);
    $ship_generator = new ShipGenerator;
    $this->ships = $ship_generator->ships;
  }

  public function attemptAutoShipPlacement($ship) {
    $pivot_point = $this->setRandomPivotPoint();
    $pivot_point_index = $this->setPivotPointIndex($pivot_point);
    $movement_array = $this->evaluator->createMovementArray($pivot_point_index, $this->board_dimension);
    $wip_array = [];
    do {
      $direction = $this->setDirection($movement_array);
      $proposed_coordinate = $pivot_point;
      $proposed_coordinate_index = $pivot_point_index;
      $wip_array = [];
      array_push($wip_array, $proposed_coordinate);
      while(count($wip_array) != $ship->length) {
        $proposed_coordinate_index = $this->updateProposedCoordinateIndex($proposed_coordinate_index, $direction);
        $proposed_coordinate = $this->updateProposedCoordinate($proposed_coordinate_index);
        array_push($wip_array, $proposed_coordinate);
      }
      unset($movement_array[array_search($direction, $movement_array)]);
    }  while(!$this->board->place($wip_array, $ship));
    
    return $wip_array;
  }

  public function autoShipPlacement() {
    foreach($this->ships as $ship) {
      $this->attemptAutoShipPlacement($ship);
    }
  }

  public function autoShotSelection($difficulty = "EASY") {
    $hit_cells_arr = $this->board->make_hit_cells_arr();
    if($difficulty === "HARD" && count($hit_cells_arr) > 0) {
      $this->smartShot($hit_cells_arr);
    } else {
      $this->randomShot();
    }
  }

  public function fireUpon($shot_coordinate) {
    if($this->board->is_valid_coordinate($shot_coordinate)) {
      $cell = $this->board->cells[$shot_coordinate];
      if(!$this->board->cells[$shot_coordinate]->is_fired_upon()) {
        $cell->fire_upon();
      } else {
        return false;
      }
      return false;
    }
  }

  public function randomShot() {
    $shot_coordinate = $this->shots_available[array_rand($this->shots_available)];
    $this->fireUpon($shot_coordinate);
    unset($this->shots_available[array_search($shot_coordinate, $this->shots_available)]);
  }

  public function setDirection($movement_array) {
    if(empty($movement_array)) {
      return false;
    } else {
      $random_array_position = array_rand($movement_array, 1);
      $direction = $movement_array[$random_array_position];
      return $direction;
    }
  }

  public function setPivotPointIndex($pivot_point) {
    $cells = $this->board->cells;
    return array_search($pivot_point, array_keys($cells));
  }

  public function setRandomPivotPoint() {
    $pivot_point = $this->shots_available[array_rand($this->shots_available)];
    while($this->evaluator->coordinates_empty([$pivot_point], $this->board->cells) == false) {
      $pivot_point = $this->shots_available[array_rand($this->shots_available)];
    }
    return $pivot_point;
  }

  public function smartShot($hit_cells_arr) {
    $cells = array_keys($this->board->cells);
    $pivot_point = $hit_cells_arr[0];
    $pivot_point_index = $this->setPivotPointIndex($pivot_point);
    $movement_array = $this->evaluator->createMovementArray($pivot_point_index, $this->board_dimension);
    $direction = $this->setDirection($movement_array);
    $proposed_coordinate = $cells[$pivot_point_index + $direction];
    while($this->fireUpon($proposed_coordinate)) {
      unset($movement_array[array_search($direction, $movement_array)]);
      $direction = $this->setDirection($movement_array);
      if($direction === null) {
        $pivot_point = $hit_cells_arr[1];
        $pivot_point_index = $this->setPivotPointIndex($pivot_point);
        $movement_array = $this->evaluator->createMovementArray($pivot_point_index, $this->board_dimension);
        $direction = $this->setDirection($movement_array);
      }
      $proposed_coordinate_index = $this->updateProposedCoordinateIndex($pivot_point_index, $direction);
      $proposed_coordinate = $this->updateProposedCoordinate($proposed_coordinate_index);
    }
    $this->fireUpon($proposed_coordinate);
    $this->last_shot_coordinate = $proposed_coordinate;
    unset($this->shots_available[array_search($proposed_coordinate, $this->shots_available)]);
  }
  
  public function updateProposedCoordinateIndex($proposed_coordinate_index, $direction) {
    $new_proposed_coordinate_index = $proposed_coordinate_index += $direction;
    if($new_proposed_coordinate_index > -1 && $new_proposed_coordinate_index < count($this->board->cells)) {
      return($new_proposed_coordinate_index);
    } else {
      return null;
    }
  }

  public function updateProposedCoordinate($proposed_coordinate_index) {
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