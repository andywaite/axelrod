<?php

namespace Andywaite\Axelrod\Strategy;

use Andywaite\Axelrod\PlayChoices;
use Andywaite\Axelrod\Strategy;

class Friedman implements Strategy
{
    protected $hasGrudge = false;

    public function getChoice(): PlayChoices
    {
        return $this->hasGrudge ? PlayChoices::DEFECT : PlayChoices::COOPERATE;
    }

    public function notifyOpponentChoice(PlayChoices $opponentChoice): void
    {
        if ($opponentChoice === PlayChoices::DEFECT) {
            $this->hasGrudge = true;
        }
    }
}
