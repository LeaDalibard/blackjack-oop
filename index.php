<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require 'Suit.php';
require 'Card.php';
require 'Deck.php';
require 'Player.php';
require 'Blackjack.php';

session_start();

$blackjack=new Blackjack($player, $dealer,$deck);

$_SESSION["blackjack"] =$blackjack;

//$test=$deck ->getCards();
//var_dump($test);


