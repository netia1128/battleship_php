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

    if($this->isHorizontal($coordinates) == true) {
      if((end($coordinate_numbers) - reset($coordinate_numbers)) + 1 == $ship->length) {
        return true;
      }
    } elseif($this->isVertical($coordinates) == true) {
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

  public function isHorizontal($coordinates) {
    $unique_letter_count = count(array_unique($this->user_coordinate_letters($coordinates)));
    return($unique_letter_count == 1);
  }

  public function isVertical($coordinates) {
    $unique_number_count = count(array_unique($this->user_coordinate_numbers($coordinates)));
    return($unique_number_count == 1);
  }

  public function isHorizontalOrVertical($coordinates) {
    return($this->isVertical($coordinates) || $this->isHorizontal($coordinates));
  }

  public function isVerticalStartRow($pivot_point_index, $board_dimension) {
    return($pivot_point_index % $board_dimension == 0);
  }

  public function isVerticalEndRow($pivot_point_index, $board_dimension) {
    return($pivot_point_index % $board_dimension == $board_dimension - 1);
  }

  public function isHorizontalStartRow($pivot_point_index, $board_dimension) {
    return($pivot_point_index / $board_dimension < 1);
  }

  public function isHorizontalEndRow($pivot_point_index, $board_dimension) {
    return(floor($pivot_point_index / $board_dimension) == $board_dimension - 1);
  }

  public function createMovementArray($pivot_point_index, $board_dimension) {
    $movement_array = [];
    
    if(!$this->isHorizontalStartRow($pivot_point_index, $board_dimension)) {
      array_push($movement_array, ($board_dimension * -1));
    }
    if(!$this->isHorizontalEndRow($pivot_point_index, $board_dimension)) {
      array_push($movement_array, $board_dimension);
    }
    if(!$this->isVerticalStartRow($pivot_point_index, $board_dimension)) {
      array_push($movement_array, -1);
    }
    if(!$this->isVerticalEndRow($pivot_point_index, $board_dimension)) {
      array_push($movement_array, 1);
    }

    return $movement_array;
  }
}
?>
