<?php 

require_once 'board.php';

$board = new Board(2);

$evaluator = new Evaluator($board->cells);

$coordinates = ['A1', 'B2'];

$evaluator->user_coordinate_letters($coordinates)

?>