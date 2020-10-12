<?php
declare(strict_types=1);
//require('Deck.php');

class Player
{
    private array $cards;
    private bool $lost = FALSE;

    public function __construct(array $cards, bool $lost, $deck)
    {
        for ($i = 0; $i < 2; $i++) {
            array_push($cards, $deck[$i]);
            $deck->drawCards();
        }
        $this->lost = $lost;
    }


    public function hit()
    {
    }

    public function surrender()
    {
    }

    public function getScore()
    {
    }

    public function hasLost()
    {
    }
}

