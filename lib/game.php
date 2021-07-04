<?php 

require('/home/netia/projects/battleship_php/lib/statement.php');
require('/home/netia/projects/battleship_php/lib/player.php');

class Game 
{

  private $statement;
  private $player;
  private $computron;
  private $difficulty_level;

    public function __construct() 
    {
      $this->player = '';
      $this->computron = '';
      $this->statement = new Statement;
      $this->difficulty_level = '';
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
      $this->difficulty_level = $this->statement->get_user_input();
      $this->difficulty_level_evaluation($this->difficulty_level);
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
        system('clear');
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
    $this->ship_placement();
  }

  public function ship_placement()
  {
    $this->computron->auto_ship_placement();
    system('clear');
    $this->statement->print_to_terminal($this->statement->ship_placement_explanation($this->player));
    $ships = $this->player->ships;
    foreach($ships as $ship) {
      $this->statement->print_to_terminal($this->statement->place_specific_ship($ship));
      $user_coordinates = explode(" ",$this->statement->get_user_input());
      $this->ship_placement_evaluation($user_coordinates, $ship);
      system('clear');
      $this->statement->print_to_terminal($this->statement->ship_placement_success($ship, $this->player));
    }
    $this->take_turn_explanation();
  }

  public function ship_placement_evaluation($user_coordinates, $ship)
  {
    while($this->player->board->place($user_coordinates, $ship) == false) {
      system ('clear');
      $this->statement->print_to_terminal($this->statement->ship_placement_error($this->player, $ship));
      $user_coordinates = explode(" ",$this->statement->get_user_input());
    }
    $this->player->board->place($user_coordinates, $ship);
  }

  public function take_turn_explanation()
  {
    system('clear');
    $this->statement->print_to_terminal($this->statement->turn_explanation());
    $this->take_turn();
  }

  public function take_turn()
  {
    while(!$this->is_end_of_game()) {
      $this->statement->print_to_terminal($this->statement->take_turn($this->player, $this->computron));
      $this->take_turn_evaluation();
    }
    $this->end_of_game();
  }

  public function take_turn_evaluation()
  {
    $shot_coordinate = $this->statement->get_user_input();
    while($this->computron->fire_upon($shot_coordinate) === false) {
      system('clear');
      $this->statement->print_to_terminal($this->statement->take_turn_error($this->player, $this->computron));
      $shot_coordinate = $this->statement->get_user_input();
    }
    $this->player->auto_shot_selection($this->difficulty_level);
    system('clear');
    $this->statement->print_to_terminal($this->statement->shot_report($this->player, $this->computron, $shot_coordinate));
  }

  public function end_of_game()
  {
    system('clear');
     $this->statement->print_to_terminal($this->statement->game_over());
     if($this->player_won()) {
       $this->statement->print_to_terminal($this->statement->you_won());
     } else {
       $this->statement->print_to_terminal($this->statement->computron_won());
     }
  }

  public function is_end_of_game() 
  {
    if($this->player_won() || $this->computron_won()) {
      return true;
    }
  }

  public function player_won() 
  {
    $ships = $this->computron->ships;
    $count = 0;
    foreach($ships as $ship) {
      if($ship->is_sunk()) {
        $count += 1;
      }
    }
    return($count === 3);
  }

  public function computron_won() 
  {
    $ships = $this->player->ships;
    $count = 0;
    foreach($ships as $ship) {
      if($ship->is_sunk()) {
        $count += 1;
      }
    }
    return($count === 3);
  }
}
