<?php 

class Cell 
{
  public $coordinate;
  public $status;
  public $ship;

  public function __construct($coordinate) 
  {
    $this->coordinate = $coordinate;
    $this->status = ".";
    $this->ship = null;
  }

  public function is_empty() 
  {
    return($this->status == ".");
  }

  public function place_ship($ship) 
  {
    $this->status = 'S';
    $this->ship = $ship;
  }

  public function is_fired_upon() 
  {
    return($this->status === "X" || $this->status === "M" || $this->status === "H");
  }

  public function fire_upon() 
  {
    if($this->is_fired_upon() == true) {
      return false;
    }
    if($this->status === ".") {
      $this->status = "M";
    } elseif($this->status === "S" && $this->ship->health > 1) {
      $this->ship->hit();
      $this->status = "H";
    } else {
      $this->ship->hit();
      $this->status = "X";
    }
  }

  public function render($show_ships = false) 
  {
    $render_status = '';

    if($show_ships == false && $this->status === "S") {
      $render_status = ".";
    } elseif($this->ship != null && $this->ship->is_sunk()) {
      $render_status = "X";
    } else {
      $render_status = $this->status;
    }

    return $render_status;
  }
}
