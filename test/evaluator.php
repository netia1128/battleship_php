<!-- require_relative 'board' -->

<?php 

class Evaluator {
  // attr_reader :cellsX

  public function __construct($cells) {
    $this->cells = $cells;
  }

  public function is_consecutive($coordinates, $ship) {
    $coordinate_numbers = $this->user_coordinate_numbers($coordinates);
    $coordinate_letters = $this->user_coordinate_letters($coordinates);

    if($this->is_horizontal($coordinates) == true) {
      if((end($coordinate_numbers) - reset($coordinate_numbers)) + 1 == $ship->length) {
        return true;
      }
    } elseif($this->is_vertical($coordinates) == true) {
      if((ord(end($coordinate_letters)) - ord(reset($coordinate_letters))) + 1 == $ship->length) {
        return true;
      }
    } else {
      return false;
    }
  }

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

  public function user_coordinate_numbers($coordinates) {
    $coordinate_numbers = [];

    foreach($coordinates as $coordinate) {
      array_push($coordinate_numbers, str_split($coordinate)[1]);
    }

    sort($coordinate_numbers);

    return $coordinate_numbers;
  }

  public function user_coordinate_letters($coordinates) {
    $coordinate_letters = [];

    foreach($coordinates as $coordinate) {
      array_push($coordinate_letters, str_split($coordinate)[0]);
    }

    sort($coordinate_letters);

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

  public function is_horizontal($coordinates) {
    $unique_letter_count = count(array_unique($this->user_coordinate_letters($coordinates)));
    if($unique_letter_count == 1) {
      return true;
    }
  }

  public function is_vertical($coordinates) {
    $unique_number_count = count(array_unique($this->user_coordinate_numbers($coordinates)));
    if($unique_number_count == 1) {
      return true;
    }
  }

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
