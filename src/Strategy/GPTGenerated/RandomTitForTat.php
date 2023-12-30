<?php

namespace Andywaite\Axelrod\Strategy\GPTGenerated;

use Andywaite\Axelrod\PlayChoices;
use Andywaite\Axelrod\Strategy;

class RandomTitForTat implements Strategy
{
    protected bool $lastWasOpponentDefect = false;
    protected int $randomSwitchThreshold = 10; // Switch behavior every 10 rounds

    public function notifyOpponentChoice(PlayChoices $opponentChoice): void
    {
        $this->lastWasOpponentDefect = $opponentChoice === PlayChoices::DEFECT;
    }

    public function getChoice(): PlayChoices
    {
        if (rand(0, 100) < $this->randomSwitchThreshold) {
            return rand(0, 1) === 0 ? PlayChoices::COOPERATE : PlayChoices::DEFECT;
        }
        return $this->lastWasOpponentDefect ? PlayChoices::DEFECT : PlayChoices::COOPERATE;
    }
}
