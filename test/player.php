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
    $this->last_shot_coordinate = '';
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

//   def auto_ship_placement
//     ships.each do |ship|
//       board.place(attempt_auto_ship_placement(ship), ship)
//     end
//   end

//   def auto_shot_selection(difficulty = "EASY")
//     hit_cells_arr = @board.make_hit_cells_arr
//     if difficulty == "HARD" && hit_cells_arr.count > 0
//         smart_shot(hit_cells_arr)
//$     else
//         random_shot
//     end
//   end

public function fireUpon($shot_coordinate) {
  if($this->board->is_valid_coordinate($shot_coordinate)) {
    if(!$this->board->cells[$shot_coordinate]->is_fired_upon()){
      $this->board->cells[$shot_coordinate]->fire_upon();
    } else {
      return false;
    }
    return false;
  }
}

public function randomShot() {
  $this->last_shot_cooridinate = $this->shots_available[array_rand($this->shots_available)];
  $this->fireUpon($this->last_shot_coordinate);
  unset($this->shots_available[array_search($this->last_shot_coordinate, $this->shots_available)]);
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

//   def smart_shot(hit_cells_arr)
//     cells = @board.make_board_array
//     pivot_point = hit_cells_arr[0]
//     pivot_point_index = set_pivot_point_index(pivot_point)
//     movement_array = @evaluator.create_movement_array(pivot_point_index, @board_dimension)
//     direction = set_direction(movement_array)
//     proposed_coordinate = cells[pivot_point_index + direction]
//     until fire_upon(proposed_coordinate)
//       movement_array.delete(direction)
//       direction = set_direction(movement_array)
//       if direction == nil
//         pivot_point = hit_cells_arr[1]
//         pivot_point_index = set_pivot_point_index(pivot_point)
//         movement_array = @evaluator.create_movement_array(pivot_point_index, @board_dimension)
//         direction = set_direction(movement_array)
//       end
//       proposed_coordinate_index = update_proposed_coordinate_index(pivot_point_index, direction)
//       proposed_coordinate = update_proposed_coordinate(proposed_coordinate_index)
//     end
//     fire_upon(proposed_coordinate)
//     @last_shot_coordinate = proposed_coordinate
//     @shots_available.delete(proposed_coordinate)
//   end

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
