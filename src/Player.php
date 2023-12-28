<?php

namespace Andywaite\Axelrod;

class Player
{
    protected int $points = 0;

    public static function createPlayer(Strategy $strategy): self
    {
        return new static($strategy);
    }

    public function __construct(protected Strategy $strategy)
    {
    }

    public function getChoice(): PlayChoices
    {
        return $this->strategy->getChoice();
    }

    public function notifyGameResult(PlayChoices $opponentChoice): void
    {
        $this->strategy->notifyOpponentChoice($opponentChoice);
    }

    public function addPoints(int $points): void
    {
        $this->points += $points;
    }

    public function getPoints(): int
    {
        return $this->points;
    }
}
