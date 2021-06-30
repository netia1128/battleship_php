<!-- require_relative 'board' -->

<?php 

class Evaluator {
  // attr_reader :cellsX

  public function __construct($cells) {
    $this->cells = $cells;
  }

  // public function is_consecutive($coordinates, $ship) {
  //   if is_horizontal?(coordinates)
  //     return ((user_coordinate_numbers(coordinates).last - user_coordinate_numbers(coordinates).first) + 1 == ship.length)
  //   elsif is_vertical?(coordinates)
  //     return ((user_coordinate_letters(coordinates).last.ord - user_coordinate_letters(coordinates).first.ord) + 1 == ship.length)
  //   else
  //     return false
  //   end
  // }

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

  public function split_user_coordinates($coordinates) {
    $split_coordinates = [];

    foreach($coordinates as $coordinate) {
      // echo str_split($coordinate);
      array_push($split_coordinates, str_split($coordinate)[0]);
    }
    var_dump(array_merge($split_coordinates));
    // foreach($splist_coordinates as $character) {
    //   echo "$chsaracter <br>";
    // }
    

    return $split_coordinates;
  }

  // public function extract_coordinate_letters($coordinates) {
  //   foreach($coordinates as $coordinate) {
  //     explode('', $coordinate)
  //   }
  // }

  public function user_coordinate_numbers($coordinates) {
    $coordinate_numbers = [];

    foreach($coordinates as $coordinate) {
      array_push($coordinate_numbers, str_split($coordinate)[1]);
    }

    return $coordinate_numbers;
  }

  public function user_coordinate_letters($coordinates) {
    $coordinate_letters = [];

    foreach($coordinates as $coordinate) {
      array_push($coordinate_letters, str_split($coordinate)[0]);
    }

    return $coordinate_letters;
  }

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

  // public function is_horizontal($coordinates) {
  //   user_coordinate_letters($coordinates).uniq.count == 1
  // }

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
