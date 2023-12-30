<?php

namespace Andywaite\Axelrod\Strategy\GPTGenerated;

use Andywaite\Axelrod\PlayChoices;
use Andywaite\Axelrod\Strategy;

class ForgivingTitForTat implements Strategy
{
    protected bool $lastWasOpponentDefect = false;

    public function notifyOpponentChoice(PlayChoices $opponentChoice): void
    {
        $this->lastWasOpponentDefect = $opponentChoice === PlayChoices::DEFECT;
    }

    public function getChoice(): PlayChoices
    {
        if ($this->lastWasOpponentDefect) {
            // 10% chance of forgiving a defection
            return rand(0, 9) < 1 ? PlayChoices::COOPERATE : PlayChoices::DEFECT;
        }
        return PlayChoices::COOPERATE;
    }
}
