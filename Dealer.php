<?php
declare(strict_types=1);

class Dealer extends Player
{
    public function hit($deck)
    {
        if ($this->getScore() < 15) {
            parent::hit($deck);
        }
    }

}
