<?php

require_once 'cell.php';
require_once 'evaluator.php';

class Board {

  public function __construct($board_dimension) {
    $this->board_dimension = $board_dimension;
    $this->cells = $this->make_board_array();
    $this->evaluator = new Evaluator($this->cells);
  }

  public function make_board_array() {
    $board_array = array();
    $letters = range('A', 'Z');
    $letter_count = 0;
    $number_count = 1;
    $total_coordinates = $this->board_dimension ** 2;

    for($letter_count = 0; $letter_count < $this->board_dimension; $letter_count++) {
      for($num_count = 1; $num_count <= $this->board_dimension; $num_count++) {
        $coordinate = $letters[$letter_count] . strval($num_count);
        $board_array[$coordinate] = new Cell($coordinate);
      }
    }

    return $board_array;
  }

  public function is_valid_placement($coordinates, $ship) {
    if($this->evaluator->coordinates_match_ship_length($coordinates, $ship) == true &&
       $this->evaluator->coordinates_empty($coordinates, $this->cells) == true &&
       $this->evaluator->no_duplicate_coordinates($coordinates, $ship) == true &&
       $this->evaluator->is_consecutive($coordinates, $ship) == true) {
         return true;
       }
  }
  
  public function place($coordinates, $ship) {
    foreach($coordinates as $coordinate) {
      if($this->is_valid_coordinate($coordinate) == false) {
        return false;
      }
    }
    if($this->is_valid_placement($coordinates, $ship) == false) {
      return false;
    }
    foreach($coordinates as $coordinate) {
      $this->cells[$coordinate]->place_ship($ship);
    }
  }

  public function is_valid_coordinate($coordinate) {
    if($coordinate == null) {
      return false;
    } elseif(in_array($coordinate, array_keys($this->cells))) {
      return true;
    } else {
      return false;
    }
  }

  public function render($show_ships = false) {
    $string = "  " . $this->top_row() . " \n";
    $cells = $this->cells;
    foreach($cells as $key => $value){
      if($key[1] == 1) {
        $string = ($string . $key[0] . " " . $value->render($show_ships) . " ");
      } elseif($key[1] == $this->board_dimension) {
        $string = ($string . $value->render($show_ships) . " \n");
      } else {
        $string = ($string . $value->render($show_ships) . " ");
      }
    }
    return $string;
  }

  public function top_row() {
    $board_numbers = range(1, $this->board_dimension);
    return join(' ', $board_numbers);
  }

  public function make_hit_cells_arr() {
    $hit_cells_arr = [];
    foreach($this->cells as $key => $value) {
      if($value->render() == 'H') {
        array_push($hit_cells_arr, $key);
      }
    }
    return $hit_cells_arr;
  }
}
?>
