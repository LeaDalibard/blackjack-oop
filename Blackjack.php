<?php
declare(strict_types=1);

//require ('Player.php');
//require ('Deck.php');

Class Blackjack {
    private $player;
    private $dealer;
    private $deck;

    public function __construct($player, $dealer, $deck)
    {
        $this->player = $player;
        $this->dealer = $dealer;
        $deck =new Deck;
        $deck->shuffle();
    }


    public function getDealer()
    {
        return $this->dealer;
    }

    public function getPlayer()
    {
        return $this->player;
    }

    public function getDeck()
    {
        return $this->deck;
    }


}