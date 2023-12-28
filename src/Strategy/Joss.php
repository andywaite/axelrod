<?php

namespace Andywaite\Axelrod\Strategy;

use Andywaite\Axelrod\PlayChoices;
use Andywaite\Axelrod\Strategy;

class Joss implements Strategy
{
    protected bool $lastWasOpponentDefect = false;

    public function getChoice(): PlayChoices
    {
        if (rand(0, 9) === 0) {
            return PlayChoices::DEFECT;
        }

        return $this->lastWasOpponentDefect ? PlayChoices::DEFECT : PlayChoices::COOPERATE;
    }

    public function notifyOpponentChoice(PlayChoices $opponentChoice): void
    {
        $this->lastWasOpponentDefect = $opponentChoice === PlayChoices::DEFECT;
    }
}
