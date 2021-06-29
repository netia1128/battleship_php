<!-- require_relative 'board' -->

<?php 

class Evaluator {
  // attr_reader :cellsX

  public function __construct($cells) {
    $this->cells = $cells;
  }

  // def is_consecutive?(coordinates, ship)
  //   if is_horizontal?(coordinates)
  //     return ((user_coordinate_numbers(coordinates).last - user_coordinate_numbers(coordinates).first) + 1 == ship.length)
  //   elsif is_vertical?(coordinates)
  //     return ((user_coordinate_letters(coordinates).last.ord - user_coordinate_letters(coordinates).first.ord) + 1 == ship.length)
  //   else
  //     return false
  //   end
  // end

  public function coordinates_match_ship_length($coordinates, $ship) {
    if(count($coordinates) == $ship->length) {
      return true;
    }
  }

  public function no_duplicate_coordinates($coordinates) {
    if(count(array_unique($coordinates)) == count($coordinates)) {
      return true;
    }
  }

  // def split_user_coordinates(coordinates)
  //   coordinates.map do |coordinate|
  //     coordinate.split("")
  //   end
  // end

  // def user_coordinate_numbers(coordinates)
  //   split_user_coordinates(coordinates).map do |sub_arr|
  //     sub_arr[1].to_i
  //   end.sort
  // end

  // def user_coordinate_letters(coordinates)
  //   split_user_coordinates(coordinates).map do |sub_arr|
  //     sub_arr[0]
  //   end.sort
  // end

  public function coordinates_empty($coordinates, $cells) {
    $empty_coordinates = 0;

    foreach($coordinates as $coordinate) {
      if($cells[$coordinate]->ship == null) {
        $empty_coordinates += 1;
      }
    }

    if($empty_coordinates == count($coordinates)) {
      return true;
    }
  }

  // def is_horizontal?(coordinates)
  //   user_coordinate_letters(coordinates).uniq.count == 1
  // end

  // def is_vertical?(coordinates)
  //   user_coordinate_numbers(coordinates).uniq.count == 1
  // end

  // def is_horizontal_or_vertical?(coordinates)
  //   user_coordinate_letters(coordinates).uniq.count == 1 || user_coordinate_numbers(coordinates).uniq.count == 1
  // end

  // def vertical_start_row?(pivot_point_index, board_dimension)
  //   pivot_point_index % board_dimension == 0
  // end

  // def vertical_end_row?(pivot_point_index, board_dimension)
  //   pivot_point_index % board_dimension == board_dimension - 1
  // end

  // def horizontal_start_row?(pivot_point_index, board_dimension)
  //   pivot_point_index / board_dimension < 1
  // end

  // def horizontal_end_row?(pivot_point_index, board_dimension)
  //   pivot_point_index / board_dimension == board_dimension - 1
  // end

  // def create_movement_array(pivot_point_index, board_dimension)
  //   movement_array = []
  //   # require 'pry'; binding.pry
  //   if !horizontal_start_row?(pivot_point_index, board_dimension)
  //     movement_array. << board_dimension * - 1
  //   end
  //   if !horizontal_end_row?(pivot_point_index, board_dimension)
  //     movement_array. << board_dimension
  //   end
  //   if !vertical_start_row?(pivot_point_index, board_dimension)
  //     movement_array << -1
  //   end
  //   if !vertical_end_row?(pivot_point_index, board_dimension)
  //     movement_array << 1
  //   end
  //   movement_array
  // end
}
?>
