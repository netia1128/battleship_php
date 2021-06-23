<?php 

class Cell {

  public function __construct($coordinate) {
    $this->coordinate = $coordinate;
    $this->status = ".";
    $this->ship = null;
  }

  public function is_empty() {
    if($this->status == ".") {
      return true;
    }
  }

//   def place_ship(ship)
//     @status = 'S'
//     @ship = ship
//   end

//   def fired_upon?
//     @status == "X" || @status == "M" || @status == "H"
//   end

//   def fire_upon
//     if self.fired_upon?
//       return false
//     end
//     if @status == "."
//       @status = "M"
//     elsif @status == "S" && @ship.health > 1
//       @ship.hit
//       @status = "H"
//     else
//       @ship.hit
//       @status = "X"
//     end
//   end

//   def render(show_ships = false)
//     if show_ships == false && @status == "S"
//       "."
//     elsif !@ship.nil? && @ship.sunk?
//       "X"
//     else
//       @status
//     end
//   end
// end
}
?>
