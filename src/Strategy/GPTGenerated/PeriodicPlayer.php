<?php

namespace Andywaite\Axelrod\Strategy\GPTGenerated;

use Andywaite\Axelrod\PlayChoices;
use Andywaite\Axelrod\Strategy;

class PeriodicPlayer implements Strategy
{
    protected array $movePattern = [PlayChoices::COOPERATE, PlayChoices::COOPERATE, PlayChoices::DEFECT];
    protected int $currentMove = 0;

    public function notifyOpponentChoice(PlayChoices $opponentChoice): void
    {
        // This strategy does not care about the opponent's choice.
    }

    public function getChoice(): PlayChoices
    {
        $choice = $this->movePattern[$this->currentMove];
        $this->currentMove = ($this->currentMove + 1) % count($this->movePattern);
        return $choice;
    }
}
