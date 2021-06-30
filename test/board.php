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

  // def place(coordinates, ship)
  //   coordinates.each do |coordinate|
  //     if !valid_coordinate?(coordinate)
  //       return false
  //     end
  //   end
  //   if !valid_placement?(coordinates, ship)
  //     return false
  //   end
  //   coordinates.each do |coordinate|
  //     @cells[coordinate.to_sym].place_ship(ship)
  //   end
  // end

  public function is_valid_coordinate($coordinate) {
    if($coordinate == null) {
      return false;
    } elseif(in_array($coordinate, array_keys($this->cells))) {
      return true;
    } else {
      return false;
    }
  }

  // def valid_coordinate?(coordinate)
  //   if coordinate == nil
  //     return false
  //   else
  //     @cells.keys.to_a.include? coordinate.to_sym
  //   end
  // end

  // def render(show_ships = false)
  //   string = top_row
  //   @cells.each do |key, value|
  //     if key.to_s[1] == "1"
  //       string += "#{key.to_s[0]} #{value.render(show_ships)} "
  //     elsif key.to_s[1].to_i == @board_dimension
  //       string += "#{value.render(show_ships)} \n"
  //     else
  //      string += "#{value.render(show_ships)} "
  //     end
  //   end
  //   string
  // end

  // def top_row
  //   return "  #{board_numbers.join(' ')} \n"
  // end

  // def board_numbers
  //   (1..@board_dimension).to_a
  // end

  // def make_hit_cells_arr
  //   hit_cells_arr = []
  //   @cells.each do |key, value|
  //       if @cells[key].render == "H"
  //         hit_cells_arr << cells[key].coordinate
  //     end
  //   end
  //   hit_cells_arr
  // end
}
?>
