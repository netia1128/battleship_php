<?php 

require('/home/netia/projects/battleship_php/lib/statement.php');
require('/home/netia/projects/battleship_php/lib/player.php');

class Game 
{

  private $statement;
  private $player;
  private $computron;

    public function __construct() 
    {
      $this->player = '';
      $this->computron = '';
    //   $this->board_dimension;
      $this->statement = new Statement;
    //   $this->difficulty_level = '';
    }

    public function main_menu()
    {
      system('clear');
      $this->statement->print_to_terminal($this->statement->battleship_graphic());
      $this->statement->print_to_terminal($this->statement->main_menu());
      $input = $this->statement->get_user_input();
      if($input === "P") {
        $this->introductions();
      } elseif($input === "Q") {
        $this->statement->print_to_terminal($this->statement->quit_game());
      } else {
        $this->statement->print_to_terminal($this->main_menu());
      }
    }

    public function introductions() 
    {
      system('clear');
      $this->statement->print_to_terminal($this->statement->ask_name());
      $player = $this->statement->get_name();
      system('clear');
      $this->statement->print_to_terminal($this->statement->introduction());
      $this->get_difficulty_level();
    }

    public function get_difficulty_level() 
    {
      $this->statement->print_to_terminal($this->statement->ask_difficulty_level());
      $difficulty_level = $this->statement->get_user_input();
      $this->difficulty_level_evaluation($difficulty_level);
      $this->get_board_dimensions();
    }

    public function difficulty_level_evaluation($difficulty_level) 
    {
      if($difficulty_level != "HARD" && $difficulty_level != "EASY") {
        system('clear');
        $this->statement->print_to_terminal($this->statement->difficulty_level_error());
        $difficulty_level = $this->statement->get_user_input();
        $this->difficulty_level_evaluation($difficulty_level);
      }
    }
  public function get_board_dimensions() 
    {
      system('clear');
      $this->statement->print_to_terminal($this->statement->ask_board_dimensions());
      $board_dimension = $this->statement->get_user_input();
      $this->board_dimension_evaluation($board_dimension);
    }

    public function board_dimension_evaluation($board_dimension)
    {
      if($board_dimension < 4 || $board_dimension > 9) {
        $this->statement->print_to_terminal($this->statement->board_dimension_error());
        $board_dimension = $this->statement->get_user_input();
        $this->board_dimension_evaluation($board_dimension);
      }
      $this->initialize_game($board_dimension);
    }

  public function initialize_game($board_dimension)
  {
    $this->player = new Player($board_dimension);
    $this->computron = new Player($board_dimension);
    $this->ship_placement_explanation();
  }

  public function ship_placement_explanation() 
  {
    system('clear');
    $this->statement->print_to_terminal($this->statement->ship_placement_explanation($this->player));
    // ship_placement
  }

//   def ship_placement
//     @computron.auto_ship_placement
//     system 'clear'
//     @statement.print_to_terminal(@statement.ship_placement_explanation(@player))
//     @player.ships.each do |ship|
//       @statement.print_to_terminal(@statement.place_specific_ship(ship))
//       ship_placement_evaluation(ship)
//       system 'clear'
//       @statement.print_to_terminal(@statement.ship_placement_success(ship, @player))
//     end
//     take_turn_explanation
//   end

// def ship_placement_evaluation(ship)
//   user_coordinates = @statement.get_user_input.upcase.split(" ")
//   until (@player.board.place(user_coordinates, ship))
//     system 'clear'
//     @statement.print_to_terminal(@statement.ship_placement_error(player, ship))
//     user_coordinates = @statement.get_user_input.upcase.split(" ")
//   end
//   @player.board.place(user_coordinates, ship)
// end

// def take_turn_explanation
//   system 'clear'
//   @statement.print_to_terminal(@statement.turn_explanation)
//   take_turn
//   end

//   def take_turn
//     until end_of_game?
//       @statement.print_to_terminal(@statement.take_turn(@player, @computron))
//       take_turn_evaluation
//     end
//     end_of_game
//   end

//   def take_turn_evaluation
//     shot_coordinate = @statement.get_user_input.upcase
//     until @computron.fire_upon(shot_coordinate)
//       system 'clear'
//       @statement.print_to_terminal(@statement.take_turn_error(@player, @computron))
//       shot_coordinate = @statement.get_user_input.upcase
//     end
//     @computron.fire_upon(shot_coordinate)
//     @player.auto_shot_selection(@difficulty_level)
//     system 'clear'
//     @statement.print_to_terminal(@statement.shot_report(player, computron, shot_coordinate))
//   end

//   def end_of_game
//     system 'clear'
//      @statement.print_to_terminal(@statement.game_over)
//      if player_won?
//        @statement.print_to_terminal(@statement.you_won)
//      else
//        @statement.print_to_terminal(@statement.computron_won)
//      end
//   end

//   def end_of_game?
//     player_won? || computron_won?
//   end

//   def player_won?
//     @computron.ships.all? do |ship|
//       ship.sunk?
//     end
//   end

//   def computron_won?
//     @player.ships.all? do |ship|
//       ship.sunk?
//     end
//   end
}
?>
