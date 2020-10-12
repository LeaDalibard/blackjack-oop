<?php
declare(strict_types=1);

class Player
{
    private array $cards;
    private bool $lost = FALSE;

    public function __construct($deck)
    {
        for ($i = 0; $i < 2; $i++) {
            array_push($this->cards, $deck->drawCard());
        }
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

