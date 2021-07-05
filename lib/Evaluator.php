<?php 

class Evaluator 
{
  public function is_consecutive($coordinates, $ship) 
  {
    $coordinate_numbers = $this->user_coordinate_numbers($coordinates);
    $coordinate_letters = $this->user_coordinate_letters($coordinates);

    if($this->is_horizontal($coordinates)) {
      if((end($coordinate_numbers) - reset($coordinate_numbers)) + 1 === $ship->length) {
        return true;
      }
    } elseif($this->is_vertical($coordinates)) {
        if((ord(end($coordinate_letters)) - ord(reset($coordinate_letters))) + 1 == $ship->length) {
          return true;
      }
    } else {
        return false;
    }
  }

  public function coordinates_match_ship_length($coordinates, $ship) 
  {
    return(count($coordinates) === $ship->length);
  }

  public function no_duplicate_coordinates($coordinates) 
  {
    return(count(array_unique($coordinates)) == count($coordinates));
  }

  public function user_coordinate_numbers($coordinates) 
  {
    $coordinate_numbers = [];

    foreach($coordinates as $coordinate) {
      array_push($coordinate_numbers, str_split($coordinate)[1]);
    }

    sort($coordinate_numbers);

    return $coordinate_numbers;
  }

  public function user_coordinate_letters($coordinates) 
  {
    $coordinate_letters = [];

    foreach($coordinates as $coordinate) {
      array_push($coordinate_letters, str_split($coordinate)[0]);
    }

    sort($coordinate_letters);

    return $coordinate_letters;
  }

  public function coordinates_empty($coordinates, $cells) 
  {
    $empty_coordinates = 0;

    foreach($coordinates as $coordinate) {
      if($cells[$coordinate]->ship == null) {
        $empty_coordinates += 1;
      }
    }

    return($empty_coordinates === count($coordinates));
  }

  public function is_horizontal($coordinates) {
    $unique_letter_count = count(array_unique($this->user_coordinate_letters($coordinates)));
    return($unique_letter_count == 1);
  }

  public function is_vertical($coordinates) 
  {
    $unique_number_count = count(array_unique($this->user_coordinate_numbers($coordinates)));
    return($unique_number_count === 1);
  }

  public function is_horizontal_or_vertical($coordinates) 
  {
    return($this->is_vertical($coordinates) || $this->is_horizontal($coordinates));
  }

  public function is_vertical_start_row($pivot_point_index, $board_dimension) 
  {
    return($pivot_point_index % $board_dimension == 0);
  }

  public function is_vertical_end_row($pivot_point_index, $board_dimension) 
  {
    return($pivot_point_index % $board_dimension == $board_dimension - 1);
  }

  public function is_horizontal_start_row($pivot_point_index, $board_dimension) 
  {
    return($pivot_point_index / $board_dimension < 1);
  }

  public function is_horizontal_end_row($pivot_point_index, $board_dimension) 
  {
    return(floor($pivot_point_index / $board_dimension) == $board_dimension - 1);
  }

  public function create_movement_array($pivot_point_index, $board_dimension) 
  {
    $movement_array = [];
    
    if(!$this->is_horizontal_start_row($pivot_point_index, $board_dimension)) {
      array_push($movement_array, ($board_dimension * -1));
    }
    if(!$this->is_horizontal_end_row($pivot_point_index, $board_dimension)) {
      array_push($movement_array, $board_dimension);
    }
    if(!$this->is_vertical_start_row($pivot_point_index, $board_dimension)) {
      array_push($movement_array, -1);
    }
    if(!$this->is_vertical_end_row($pivot_point_index, $board_dimension)) {
      array_push($movement_array, 1);
    }

    return $movement_array;
  }
}
