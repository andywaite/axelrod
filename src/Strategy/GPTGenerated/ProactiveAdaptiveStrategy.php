<?php

namespace Andywaite\Axelrod\Strategy\GPTGenerated;

use Andywaite\Axelrod\PlayChoices;
use Andywaite\Axelrod\Strategy;

class ProactiveAdaptiveStrategy implements Strategy
{
    protected array $opponentHistory = [];
    protected int $totalRounds = 0;
    protected int $cooperativeMoves = 3; // Start with 3 cooperative moves
    protected bool $isTestingPhase = false;

    public function notifyOpponentChoice(PlayChoices $opponentChoice): void
    {
        $this->opponentHistory[] = $opponentChoice === PlayChoices::DEFECT ? 'DEFECT' : 'COOPERATE';
        $this->totalRounds++;
    }

    public function getChoice(): PlayChoices
    {
        // Start with initial cooperative moves
        if ($this->totalRounds < $this->cooperativeMoves) {
            return PlayChoices::COOPERATE;
        }

        // Introduce a testing phase after a certain number of rounds
        if ($this->totalRounds == 10) {
            $this->isTestingPhase = true;
            return PlayChoices::DEFECT;
        }

        if ($this->isTestingPhase) {
            $this->isTestingPhase = false; // Reset testing phase
            return PlayChoices::COOPERATE; // Cooperate after testing
        }

        // Adapt based on recent opponent behavior
        return $this->adaptToOpponent();
    }

    private function adaptToOpponent(): PlayChoices
    {
        $recentMoves = array_slice($this->opponentHistory, -5); // Consider the last 5 moves
        $defections = array_count_values($recentMoves)['DEFECT'] ?? 0;

        // If the opponent defects frequently in recent moves, retaliate with defection
        if ($defections > 2) {
            return PlayChoices::DEFECT;
        }

        // If alternating pattern detected, try to break it
        if ($this->detectsAlternatingPattern($recentMoves)) {
            return PlayChoices::COOPERATE;
        }

        // Default to cooperation
        return PlayChoices::COOPERATE;
    }

    private function detectsAlternatingPattern(array $moves): bool
    {
        if (count($moves) < 4) {
            return false;
        }

        for ($i = 0; $i < count($moves) - 1; $i++) {
            if ($moves[$i] === $moves[$i + 1]) {
                return false;
            }
        }

        return true;
    }
}
