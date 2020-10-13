<?php
declare(strict_types=1);


class Blackjack
{
    private $player;
    private $dealer;
    private $deck;

    public function __construct()
    {
        $deck = new Deck;
        $deck->shuffle();
        $this->deck=$deck;
        $this->player = new Player($deck);
        $this->dealer = new Player($deck);
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