<?php

namespace Andywaite\Axelrod\Strategy;

use Andywaite\Axelrod\PlayChoices;
use Andywaite\Axelrod\Strategy;

class TitForTat implements Strategy
{
    protected bool $lastWasOpponentDefect = false;

    public function notifyOpponentChoice(PlayChoices $opponentChoice): void
    {
        $this->lastWasOpponentDefect = $opponentChoice === PlayChoices::DEFECT;
    }

    public function getChoice(): PlayChoices
    {
        return $this->lastWasOpponentDefect ? PlayChoices::DEFECT : PlayChoices::COOPERATE;
    }
}
