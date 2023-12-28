<?php

namespace Andywaite\Axelrod\Strategy;

use Andywaite\Axelrod\PlayChoices;
use Andywaite\Axelrod\Strategy;

class Hannah implements Strategy
{
    protected bool $firstGo = true;

    public function getChoice(): PlayChoices
    {
        if ($this->firstGo) {
            return PlayChoices::DEFECT;
        }

        if (rand(0, 9) < 7) {
            return PlayChoices::DEFECT;
        }

        return PlayChoices::COOPERATE;
    }

    public function notifyOpponentChoice(PlayChoices $opponentChoice): void
    {
        $this->firstGo = false;
    }
}
