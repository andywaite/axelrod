<?php

namespace Andywaite\Axelrod\Strategy;

use Andywaite\Axelrod\PlayChoices;
use Andywaite\Axelrod\Strategy;

class Tester implements Strategy
{
    protected array $opponentLog = [];

    public function notifyOpponentChoice(PlayChoices $opponentChoice): void
    {
        $this->opponentLog[] = $opponentChoice;
    }

    public function getChoice(): PlayChoices
    {
        // First go we test with defection
        if (count($this->opponentLog) === 0) {
            return PlayChoices::DEFECT;
        }

        // Second go we cooperate regardless
        if (count($this->opponentLog) <= 2) {
            return PlayChoices::COOPERATE;
        }

        // What did the opponent do after we detected on first turn? If they defected, we apologise and play tit-for-tat
        if ($this->opponentLog[1] === PlayChoices::DEFECT) {
            return $this->opponentLog[count($this->opponentLog) - 1] === PlayChoices::DEFECT ? PlayChoices::DEFECT : PlayChoices::COOPERATE;
        }

        // In that case, defect on odd turns
        return count($this->opponentLog) % 2 ?  PlayChoices::DEFECT : PlayChoices::COOPERATE;
    }
}
