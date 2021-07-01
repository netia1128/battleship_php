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

  // public function attempt_auto_ship_placement($ship) {
  //   $pivot_point = set_random_pivot_point();
  // }

//   def attempt_auto_ship_placement(ship)
//     pivot_point = set_random_pivot_point
//     pivot_point_index = set_pivot_point_index(pivot_point)
//     movement_array = @evaluator.create_movement_array(pivot_point_index, @board_dimension)
//     wip_array = [pivot_point]
//     until board.place(wip_array, ship) && wip_array.include?(nil) == false
//       direction = set_direction(movement_array)
//       proposed_coordinate = pivot_point
//       proposed_coordinate_index = pivot_point_index
//       wip_array = [proposed_coordinate]
//       until wip_array.count == ship.length do
//         # require 'pry'; binding.pry
//         proposed_coordinate_index = update_proposed_coordinate_index(proposed_coordinate_index, direction)
//         proposed_coordinate = update_proposed_coordinate(proposed_coordinate_index)
//         wip_array << proposed_coordinate
//       end
//       movement_array.delete(direction)
//     end
//     wip_array
//   end

//   def auto_ship_placement
//     ships.each do |ship|
//       board.place(attempt_auto_ship_placement(ship), ship)
//     end
//   end

//   def auto_shot_selection(difficulty = "EASY")
//     hit_cells_arr = @board.make_hit_cells_arr
//     if difficulty == "HARD" && hit_cells_arr.count > 0
//         smart_shot(hit_cells_arr)
//     else
//         random_shot
//     end
//   end

//   def fire_upon(shot_coordinate)
//     if @board.valid_coordinate?(shot_coordinate)
//       if !@board.cells[shot_coordinate.to_sym].fired_upon?
//         @board.cells[shot_coordinate.to_sym].fire_upon
//       else
//         return false
//       end
//     else
//       return false
//     end
//   end

//   def random_shot
//     @last_shot_coordinate = @shots_available.sample
//     fire_upon(@last_shot_coordinate)
//     @shots_available.delete @last_shot_coordinate
//   end

//   def set_direction(movement_array)
//     movement_array.sample
//   end

public function setPivotPointIndex($pivot_point) {
  $cells = $this->board->cells;
  return array_search($pivot_point, array_keys($cells));
}

//   def set_pivot_point_index(pivot_point)
//     cells = @board.make_board_array
//     cells.index(pivot_point)
//   end

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

//   def update_proposed_coordinate_index(proposed_coordinate_index, direction)
//     proposed_coordinate_index += direction
//   end

//   def update_proposed_coordinate(proposed_coordinate_index)
//     proposed_coordinate = @board.make_board_array[proposed_coordinate_index]
//   end
// end
}

?>
