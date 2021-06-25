<?php

class Ship {

  public function __construct($name, $length) {
    $this->name = $name;
    $this->length = $length;
    $this->health = $length;
  }

  public function is_sunk() {
    if($this->health == 0) {
      return true;
    } else {
      return false;
    }
  }

  public function hit() {
    $this->health -= 1;
  }
}

?>
