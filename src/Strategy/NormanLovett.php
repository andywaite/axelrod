<?php

namespace Andywaite\Axelrod\Strategy;

use Andywaite\Axelrod\PlayChoices;
use Andywaite\Axelrod\Strategy;

class NormanLovett implements Strategy
{
    private array $history = [];

    public function getChoice(): PlayChoices
    {
        if (count($this->history) === 99_999) {
            return PlayChoices::DEFECT;
        }
        return count($this->history) ? end($this->history) : PlayChoices::COOPERATE;
    }

    public function notifyOpponentChoice(PlayChoices $opponentChoice): void
    {
        $this->history[] = $opponentChoice;
    }
}

