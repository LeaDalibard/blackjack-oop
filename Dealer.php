<?php
declare(strict_types=1);

class Dealer extends Player
{
    public function hit($deck)
    {
         do{
            parent::hit($deck);
        }while ($this->getScore() < 15);
    }

}
