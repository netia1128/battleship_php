<?php 

require('/home/netia/projects/battleship_php/lib/statement.php');
require('/home/netia/projects/battleship_php/lib/ship.php');
require('/home/netia/projects/battleship_php/lib/player.php');

use PHPUnit\Framework\TestCase;

class StatementTest extends TestCase
{
  private $statement;

  protected function setUp(): void
  {
      $this->statement = new Statement;
      $this->statement->name = "Netia";
  }

 public function test_ask_board_dimensions() 
 {
  $this->assertTrue($this->statement->ask_board_dimensions() ==="To start, we will create a square board to play with.\n" .
      "Your board can be anywhere between 4 and 9 cells wide.\n" .
      "How many cells would you like in each row? \n");
 }

  public function ask_difficulty_level() 
  {
    $this->assertTrue($statement->ask_difficulty_level() ==="What level of difficulty would you like to play? \n" . "Please select 'hard', or 'easy'? \n");
  }

  public function test_ask_name()
  {
    $this->assertTrue($this->statement->ask_name() === "What is your name? \n");
  }

  public function test_battleshilp_graphic() 
  {
    $this->assertTrue($this->statement->battleship_graphic() ===
    " _____     _____   _______  _______  _        _______  _______  _     _  _______  _____   \n" .
    "|  __  \\  /  _  \\ |__   __||__   __|| |      |  _____||  ____ || |   | ||__   __||  __  \\ \n" .
    "| |  \\  ||  / \\  |   | |      | |   | |      | |      | |   |_|| |   | |   | |   | |  \\  |\n" .
    "| |__/  || |___| |   | |      | |   | |      | |___   | |_____ | |___| |   | |   | |__/  |\n" .
    "|      / |  ___  |   | |      | |   | |      |  ___|  |______ ||  ___  |   | |   |  ____/ \n" .
    "|  __  \\ | |   | |   | |      | |   | |      | |            | || |   | |   | |   | |      \n" .
    "| |  \\  || |   | |   | |      | |   | |      | |       _    | || |   | |   | |   | |      \n" .
    "| |__/  || |   | |   | |      | |   | |_____ | |_____ | |___| || |   | | __| |__ | |      \n" .
    "|______/ |_|   |_|   |_|      |_|   |_______||_______||_______||_|   |_||_______||_|      " .
    " \n" .
    " \n");
  }

  public function test_board_dimension_error()
  {
    $this->assertTrue($this->statement->board_dimension_error() === 
      "Sorry Netia, that is not a valid board size.\n" .
      "Please choose a board size between 4 and 9 cells wide. \n");
  }

  public function test_computron_won() 
  {
    $this->assertTrue($this->statement->computron_won() === "Computron sunk all of your ships! \n:" .
    "Computron won!");
  }

  public function test_difficulty_level_error()
  {
    $this->assertTrue($this->statement->difficulty_level_error() === "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX \n" .
           " \n" .
           "I'm sorry Netia, that is not a valid option. \n" .
           "Please select either 'easy' or 'hard'. \n" .
           " \n" .
           "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX \n");
  }

  public function test_game_over()
  {
    $this->assertTrue($this->statement->game_over() === "GAMEOVER!");
  }

  public function test_introduction() 
  {
    $this->assertTrue($this->statement->introduction() === "Hi Netia. \n" .
    "My name is Computron. I will be your opponent. ");
  }

  public function test_main_menu() 
  {
    $this->assertTrue($this->statement->main_menu() === "Welcome to Battleship! \n" .
      "Enter P to play or Q to quit \n");
  }

  public function test_place_specific_ship()
  {
    $ship = new Ship("Tug Boat", 1);
    $this->assertTrue($this->statement->place_specific_ship($ship) === "We are now placing the Tug Boat.\n" .
        "The Tug Boat is 1 cell(s) long.\n" .
        "Please provide 1 coordinate(s): \n");
  }

  public function test_quit_game()
  {
    $this->assertTrue($this->statement->quit_game() === "Thanks for playing \n");
  }

  public function test_ship_placement_error()
  {
    $ship = new Ship("Tug Boat", 1);
    $player = new Player(4);

    $this->assertTrue($this->statement->ship_placement_error($player, $ship) === "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX \n" .
        " \n" .
        "Sorry Netia, your placement is not valid.\n" .
        "For a valid placement each of the following must be true:\n" .
        "- Please provide a number of coordinates equal to the ship length\n" .
        "- The coordinates must be consecuitive\n" .
        "- The coordinates must run horizontally or vertically\n" .
        "- You cannot already have a ship in a proposed coordinate\n" .
        "- You must enter each coordinate with just a space in between.\n" .
        "      For example:\n" .
        "      A1 A2 A3 \n" .
        " \n" .
         "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX\n" .
        " \n" .
        "Please try again. Here is your board: \n" .
        " \n" .
        $player->board->render(true) .
        " \n" .
        "Please provide #{ship.length} coordinate(s): \n");
  }

  public function test_ship_placement_explanation()
  {
    $player = new Player(4);
    $this->assertTrue($this->statement->ship_placement_explanation($player) === "Great! Now let's place your ships.\n" .
      " \n" .
      "We each have three ships.\n" .
      "    -The Cruiser, which is three cells long.\n" .
      "    -The Submarine, which is two cells long.\n" .
      "    -The Tug Boat, which is one cell.\n" .
      " \n" .
      "I have already placed my ships. Now it's your turn. \n" .
      " \n" .
      "Let's start. Here is your board: \n" .
      " \n" .
      $player->board->render(true) .
      " \n" .
      "You will choose cells to put the ships in.\n" .
      "Please provide the coordinate of each cell" .
      " with just a space in between.\n" .
      "For example: \n" .
      "   A1 A2 A3\n" .
      " \n");
  }
  public function test_ship_placement_success()
  {
      $ship = new Ship("Tug Boat", 1);
      $player = new Player(4);
    
      $this->assertTrue($this->statement->ship_placement_success($ship, $player) === "Great job Netia, you've placed your $ship->name!\n" .
      "Here is what your board looks like now.\n" .
      "S means there is a ship in a cell. \n" .
      " \n" .
      $player->board->render(true) .
      " \n");
  }

  public function test_take_turn()
  {
    $player = new Player(4);
    $computron = new Player(4);

    $this->assertTrue($this->statement->take_turn($player, $computron) === " \n" .
        "=============COMPUTRON BOARD============= \n" .
        " \n" .
        $computron->board->render() .
        " \n" .
        "==============PLAYER BOARD============== \n" .
        " \n" .
        $player->board->render(true) .
        " \n" .
        "Please pick a coordinate on Computron's board to fire upon:\n");
  }

  public function test_take_turn_error()
  {
    $player = new Player(4);
    $computron = new Player(4);

    $this->assertTrue($this->statement->take_turn_error($player, $computron) === 
        "\nXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" .
        " \n" .
        "\nSorry Netia " .
        "Your shot coordinate is not valid.\n" .
        "To have a valid shot placement all of the following must be true:\n" .
        "- The coordinate must be on the board.\n" .
        "- You cannot already have fired upon the coordinate.\n" .
        "\nXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX\n" .
        "\n" .
        '=============COMPUTRON BOARD=============' .
        " \n" .
        $computron->board->render() .
        " \n" .
        '==============PLAYER BOARD==============' .
        " \n" .
        $player->board->render(true) .
        " \n" .
        "Please try again.\n");
  }

  public function test_turn_explanation()
  {
    $this->assertTrue($this->statement->turn_explanation() === "Great work, all your ships have been placed. \n" .
        "Let me quickly explain how to play. \n" .
        " \n" .
        "To play you will choose a cell on my board to fire upon.\n" .
        "To do this, provide the coordinate of the cell you wish to fire upon.\n" .
        "For example: A1\n" .
        "When you are done, I will fire upon your board.\n" .
        " \n" .
        "After we each take our turn, I will summarize what happened and update " .
        "the board as follows: \n" .
        "  - . represents a cell that has not been fired on yet\n" .
        "  - S represents your ships (we cannot see each others ships)\n" .
        "  - M represents a miss\n" .
        "  - H represents a hit\n" .
        "  - X represents a sunk ship \n" .
        " \n" .
        "We will take turns until all of someone's ships have been sunk.\n" .
        " \n" .
        "Now let's play \n");
  }

  public function you_won()
  {
    $this->assertTrue($this->statement->you_won() === "You sunk all of Computron's ships! \n" .
      "You won!");
  }
}
