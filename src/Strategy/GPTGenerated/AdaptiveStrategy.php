<?php

namespace Andywaite\Axelrod\Strategy\GPTGenerated;

use Andywaite\Axelrod\PlayChoices;
use Andywaite\Axelrod\Strategy;

class AdaptiveStrategy implements Strategy
{
    protected int $opponentCooperateCount = 0;
    protected int $totalRounds = 0;

    public function notifyOpponentChoice(PlayChoices $opponentChoice): void
    {
        if ($opponentChoice === PlayChoices::COOPERATE) {
            $this->opponentCooperateCount++;
        }
        $this->totalRounds++;
    }

    public function getChoice(): PlayChoices
    {
        if ($this->totalRounds === 0) {
            return PlayChoices::COOPERATE;
        }

        // Cooperate if the opponent's cooperation rate is above 50%
        return ($this->opponentCooperateCount / $this->totalRounds) > 0.5 ? PlayChoices::COOPERATE : PlayChoices::DEFECT;
    }
}
