<?php

namespace Andywaite\Axelrod\Strategy\GPTGenerated;

use Andywaite\Axelrod\PlayChoices;
use Andywaite\Axelrod\Strategy;

class AnalyticalAdaptiveStrategy implements Strategy
{
    private array $opponentHistory = [];
    private int $roundCount = 0;
    private int $defectCount = 0;

    public function notifyOpponentChoice(PlayChoices $opponentChoice): void
    {
        $this->roundCount++;
        $this->opponentHistory[] = $opponentChoice;
        if ($opponentChoice === PlayChoices::DEFECT) {
            $this->defectCount++;
        }
    }

    public function getChoice(): PlayChoices
    {
        // Introduce randomness
        if ($this->randomDecision()) {
            return $this->randomChoice();
        }

        // Adapt based on opponent's behavior
        if ($this->isOpponentDefectingFrequently()) {
            return PlayChoices::DEFECT;
        }

        return $this->mirrorLastMove();
    }

    private function randomDecision(): bool
    {
        // Introduce a random decision 10% of the time
        return rand(0, 9) < 1;
    }

    private function randomChoice(): PlayChoices
    {
        return rand(0, 1) === 0 ? PlayChoices::COOPERATE : PlayChoices::DEFECT;
    }

    private function isOpponentDefectingFrequently(): bool
    {
        if ($this->roundCount < 10) {
            // Not enough data to make a decision
            return false;
        }

        // Consider opponent as frequently defecting if more than 50% of the moves are defects
        return ($this->defectCount / $this->roundCount) > 0.5;
    }

    private function mirrorLastMove(): PlayChoices
    {
        // Mirror the opponent's last move, default to COOPERATE on the first move
        return end($this->opponentHistory) === PlayChoices::DEFECT ? PlayChoices::DEFECT : PlayChoices::COOPERATE;
    }
}
