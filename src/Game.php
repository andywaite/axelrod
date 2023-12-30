<?php

namespace Andywaite\Axelrod;

use Andywaite\Axelrod\Logger\Logger;

class Game
{
    public static function createGame(Player $player1, Player $player2, Logger $logger): self
    {
        return new self($player1, $player2, $logger);
    }

    public function __construct(protected Player $player1, protected Player $player2, protected Logger $logger)
    {
    }

    protected function getCharForPlayChoice(PlayChoices $playChoice): string
    {
        return match ($playChoice) {
            PlayChoices::COOPERATE => '_',
            PlayChoices::DEFECT => '#',
        };
    }

    protected function logRoundOutcome(PlayChoices $player1Choice, PlayChoices $player2Choice): void
    {
        $this->logger->log($this->getCharForPlayChoice($player1Choice) .' '. $this->getCharForPlayChoice($player2Choice));
    }

    public function playRound(): void
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

        $this->logRoundOutcome($player1Choice, $player2Choice);

        $this->player1->notifyGameResult($player2Choice);
        $this->player2->notifyGameResult($player1Choice);
    }
}
