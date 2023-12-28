<?php

namespace Andywaite\Axelrod;

class Game
{
    public static function createGame(Player $player1, Player $player2): self
    {
        return new self($player1, $player2);
    }

    public function __construct(protected Player $player1, protected Player $player2)
    {
    }

    public function play(): void
    {
        $player1Choice = $this->player1->getChoice();
        $player2Choice = $this->player2->getChoice();

        if ($player1Choice === PlayChoices::COOPERATE && $player2Choice === PlayChoices::COOPERATE) {
            $this->player1->addPoints(3);
            $this->player2->addPoints(3);
        } elseif ($player1Choice === PlayChoices::COOPERATE && $player2Choice === PlayChoices::DEFECT) {
            $this->player2->addPoints(5);
        } elseif ($player1Choice === PlayChoices::DEFECT && $player2Choice === PlayChoices::COOPERATE) {
            $this->player1->addPoints(5);
        } elseif ($player1Choice === PlayChoices::DEFECT && $player2Choice === PlayChoices::DEFECT) {
            $this->player1->addPoints(1);
            $this->player2->addPoints(1);
        }

        $this->player1->notifyGameResult($player2Choice);
        $this->player2->notifyGameResult($player1Choice);
    }
}
