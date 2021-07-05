<?php 

require('/home/netia/projects/battleship_php/lib/Evaluator.php');
require('/home/netia/projects/battleship_php/lib/Ship.php');
require('/home/netia/projects/battleship_php/lib/Board.php');

use PHPUnit\Framework\TestCase;

class EvaluatorTest extends TestCase
{
  private $evaluator;

  protected function setUp(): void
  {
      $this->evaluator = new Evaluator();
  }

  public function test_coordinates_match_ship_length() 
  {
    $board = new Board(2);
    $ship = new Ship("Submarine", 2);
    $coordinates1 = ['A1', 'A2'];

    $this->assertTrue($this->evaluator->coordinates_match_ship_length($coordinates1, $ship));

    $ship = new Ship("Destroyer", 4);
    $coordinates2 = ['A1', 'A2'];

    $this->assertTrue($this->evaluator->coordinates_match_ship_length($coordinates2, $ship) == null);
  }

  public function test_no_duplicate_coordinates() 
  {
    $board = new Board(2);
    $ship = new Ship("Submarine", 2);
    $coordinates = ['A1', 'A2'];

    $this->assertTrue($this->evaluator->no_duplicate_coordinates($coordinates));

    $coordinates = ['A1', 'A1'];

    $this->assertTrue($this->evaluator->no_duplicate_coordinates($coordinates) == null);
  }

  public function test_coordinates_empty() 
  {
    $board = new Board(2);
    $coordinates = ['A1', 'A2'];
    
    $this->assertTrue($this->evaluator->coordinates_empty($coordinates, $board->cells));
    
    $ship = new Ship("Submarine", 2);
    $board->cells['A1']->place_ship($ship);

    $this->assertTrue($this->evaluator->coordinates_empty($coordinates, $board->cells) == null);
  }

  public function test_user_coordinate_letters() 
  {
    $board = new Board(2);

    $coordinates1 = ['A1', 'A2'];
    $expected_letter_coordinates1 = ['A', 'A'];
    $letter_coordinates1 = $this->evaluator->user_coordinate_letters($coordinates1);
    
    $this->assertTrue($expected_letter_coordinates1 == $letter_coordinates1);
    
    $coordinates2 = ['A1', 'B1'];
    $expected_letter_coordinates2 = ['A', 'B'];
    $letter_coordinates2 = $this->evaluator->user_coordinate_letters($coordinates2);
    
    $this->assertTrue($expected_letter_coordinates2 == $letter_coordinates2);
  }

  public function test_user_coordinate_numbers() 
  {
    $board = new Board(2);

    $coordinates1 = ['A1', 'A2'];
    $expected_number_coordinates1 = [1, 2];
    $number_coordinates1 = $this->evaluator->user_coordinate_numbers($coordinates1);
    
    $this->assertTrue($expected_number_coordinates1 == $number_coordinates1);
    
    $coordinates2 = ['A1', 'B1'];
    $expected_number_coordinates2 = [1, 1];
    $number_coordinates2 = $this->evaluator->user_coordinate_numbers($coordinates2);
    
    $this->assertTrue($expected_number_coordinates2 == $number_coordinates2);
  }

  public function test_is_horizontal() 
  {
    $board = new Board(2);

    $coordinates1 = ['A1', 'A2'];
    
    $this->assertTrue($this->evaluator->is_horizontal($coordinates1));
    
    $coordinates2 = ['A1', 'B1'];
    
    $this->assertTrue($this->evaluator->is_horizontal($coordinates2) == null);
  }

  public function test_is_vertical() 
  {
    $board = new Board(2);

    $coordinates1 = ['A1', 'A2'];
    
    $this->assertTrue($this->evaluator->is_vertical($coordinates1) == null);
    
    $coordinates2 = ['A1', 'B1'];
    
    $this->assertTrue($this->evaluator->is_vertical($coordinates2));
  }

  public function test_is_consecutive() 
  {
    $board = new Board(2);
    $ship = new Ship("Submarine", 2);

    $coordinates1 = ['A1', 'A2'];
    
    $this->assertTrue($this->evaluator->is_consecutive($coordinates1, $ship));
    
    $coordinates2 = ['A1', 'C1'];
    
    $this->assertTrue($this->evaluator->is_consecutive($coordinates2, $ship) == null);

    $coordinates3 = ['A1', 'B1'];
    
    $this->assertTrue($this->evaluator->is_consecutive($coordinates3, $ship));
  }

  public function test_is_horizontal_start_row() 
  {
    $board = new Board(2);

    $this->assertTrue($this->evaluator->is_horizontal_start_row(0, 2));
    $this->assertFalse($this->evaluator->is_horizontal_start_row(2, 2));
  }

  public function test_is_horizontal_end_row() 
  {
    $board = new Board(2);

    $this->assertTrue($this->evaluator->is_horizontal_end_row(14, 4));
    $this->assertFalse($this->evaluator->is_horizontal_end_row(0, 2));
  }

  public function test_is_vertical_start_row() 
  {
    $board = new Board(2);

    $this->assertTrue($this->evaluator->is_vertical_start_row(4, 4));
    $this->assertFalse($this->evaluator->is_vertical_start_row(6, 4));
  }

  public function test_is_vertical_end_row() 
  {
    $board = new Board(2);

    $this->assertTrue($this->evaluator->is_vertical_end_row(3, 4));
    $this->assertFalse($this->evaluator->is_vertical_end_row(5, 4));
  }

  public function test_create_movement_array() 
  {
    $board = new Board(4);
    
    $this->assertTrue($this->evaluator->create_movement_array(1, 4) == [4, -1, 1]);
    $this->assertTrue($this->evaluator->create_movement_array(14, 4) == [-4, -1, 1]);
    $this->assertTrue($this->evaluator->create_movement_array(4, 4) == [-4, 4, 1]);
    $this->assertTrue($this->evaluator->create_movement_array(7, 4) == [-4, 4, -1]);
    $this->assertTrue($this->evaluator->create_movement_array(3, 4) == [4, -1]);
  }

  public function test_is_horizontal_or_vertical() 
  {
    $board = new Board(4);

    $this->assertTrue($this->evaluator->is_horizontal_or_vertical(['A1', 'A2']));
    $this->assertTrue($this->evaluator->is_horizontal_or_vertical(['A1', 'B1']));
    $this->assertFalse($this->evaluator->is_horizontal_or_vertical(['A1', 'B2']));
  }
}
