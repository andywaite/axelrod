<?php

namespace Andywaite\Axelrod\Strategy;

use Andywaite\Axelrod\PlayChoices;
use Andywaite\Axelrod\Strategy;

class Random implements Strategy
{

    public function getChoice(): PlayChoices
    {
        return rand(0, 1) ? PlayChoices::COOPERATE : PlayChoices::DEFECT;
    }

    public function notifyOpponentChoice(PlayChoices $opponentChoice): void
    {
        // Nothing, it's random!
    }
}
