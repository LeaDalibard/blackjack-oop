<?php
declare(strict_types=1);

class Player
{
    private array $cards = array();
    private bool $lost = FALSE;

    public function __construct( Deck $deck)
    {$this->cards=[];
        for ($i = 0; $i < 2; $i++) {
            array_push($this->cards, $deck->drawCard());
        }
    }

    public function isLost()
    {
        return $this->lost;
    }




    public function getCards()
    {
        return $this->cards;
    }

    public function setCards($cards)
    {
        $this->cards = $cards;
    }


    public function hit($deck)
    {
        array_push($this->cards, $deck->drawCard());
        if(  $this->getScore()>21){
            $this->hasLost();
        }
        return $this->cards;
    }


    public function surrender()
    {
    }

    public function getScore()
    {
        $score=0;
        foreach($this->cards AS $card) {
            $score+=$card->getValue();
        }
        return $score;
    }

    public function hasLost()
    {
        $this->lost=true;
    }

}

