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

  public function place_ship($ship) {
    $this->status = 'S';
    $this->ship = $ship;
  }

  public function is_fired_upon() {
    if($this->status == "X" || $this->status == "M" || $this->status == "H") {
      return true;
    } else {
      return false;
    }
  }

  public function fire_upon() {
    if($this->is_fired_upon() == true) {
      return false;
    }
    if($this->status == ".") {
      $this->status = "M";
    } elseif($this->status == "S" && $ship->health > 1) {
      $ship->hit;
      $this->status = "H";
    } else {
      $ship->hit;
      $this->status = "X";
    }
  }

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
