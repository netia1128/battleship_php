<!-- require_relative 'evaluator'
require_relative 'cell' #added -->


<?php
require_once 'evaluator.php';

class Board {

  public function __construct($board_dimension) {
    $this->board_dimension = $board_dimension;
    // $this->cells = $this->make_board_hash;
    $this->evaluator = new Evaluator(array("A1", "A2"));
  }
  //   @cells = make_board_hash
  //   @evaluator = Evaluator.new(@cells)
  // end



  // public function make_board_hash() {
  //   $board_array = $this->make_board_array;
  //   $board_hash = array();
  //   foreach($board_array as $coordinate) {
  //     // find out how to add new KV pair to associative array
  //     // find out how to convert a string to a symbol, if even possible
  //     $board_hash($coordinate=>new Cell(coordinate);
  //       //   board_array.each do |coordinate|
  //       //     board_hash[coordinate.to_sym] = Cell.new(coordinate)
  //       //   end
  //   }
  //   return $board_hash
  // }

  public function make_board_array() {
    $board_array = array();
    $letters = range('A', 'Z');
    $letter_count = 0;
    $number_count = 1;
    $total_coordinates = $this->board_dimension ** 2;

    for($letter_count = 0; $letter_count < $this->board_dimension; $letter_count++) {
      for($num_count = 1; $num_count <= $this->board_dimension; $num_count++) {
        array_push($board_array, $letters[$letter_count] . strval($num_count));
      }
    }

    return $board_array;
  }

  // def make_board_array
  //   board_array = []
  //   letter_count = 0
  //   number_count = 1
  //   # require 'pry'; binding.prys
  //   total_coordinates = @board_dimension * @board_dimension

  //   @board_dimension.times do
  //     @board_dimension.times do
  //       board_array << letters[letter_count] + (number_count).to_s
  //       number_count += 1
  //     end
  //     letter_count += 1
  //     number_count = 1
  //   end
  //   board_array
  // end

  public function is_valid_placement($coordinates, $ship) {
    $valid_placement = $this->evaluator->coordinates_match_ship_length($coordinates, $ship);
    return $valid_placement;
  }
  // def valid_placement?(coordinates, ship)
  //   @evaluator.coordinates_match_ship_length?(coordinates, ship) &&
  //   @evaluator.coordinates_empty?(coordinates, @cells) &&
  //   @evaluator.no_duplicate_coordinates?(coordinates) &&
  //   @evaluator.is_consecutive?(coordinates, ship)
  // end

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
