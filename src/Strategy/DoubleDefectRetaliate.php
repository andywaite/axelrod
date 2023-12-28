<?php

namespace Andywaite\Axelrod\Strategy;

use Andywaite\Axelrod\PlayChoices;
use Andywaite\Axelrod\Strategy;

class DoubleDefectRetaliate implements Strategy
{
    protected bool $lastWasOpponentDefect = false;
    protected bool $secondLastWasOpponentDefect = false;

    public function notifyOpponentChoice(PlayChoices $opponentChoice): void
    {
        $this->secondLastWasOpponentDefect = $this->lastWasOpponentDefect;
        $this->lastWasOpponentDefect = $opponentChoice === PlayChoices::DEFECT;
    }

    public function getChoice(): PlayChoices
    {
        return $this->lastWasOpponentDefect && $this->secondLastWasOpponentDefect ? PlayChoices::DEFECT : PlayChoices::COOPERATE;
    }
}
