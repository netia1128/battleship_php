<?php

class Ship {

  public function __construct($name, $length) {
    $this->name = $name;
    $this->length = $length;
    $this->health = $length;
  }

  public function sunk() {
    if($this->health == 0) {
      return true;
    }
  }

  public function hit() {
    $this->health -= 1;
  }
}

?>
