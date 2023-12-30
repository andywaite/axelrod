<?php

namespace Andywaite\Axelrod;

use Andywaite\Axelrod\Logger\Logger;

class StrategyTester
{
    protected $scoreByStrategy = [];

    public static function createStrategyTester(array $strategies, int $iterations, Logger $logger): self
    {
        return new StrategyTester($iterations, $strategies, $logger);
    }

    public function __construct(protected int $iterations, protected array $strategies, protected Logger $logger)
    {
    }

    protected function playGames(Strategy $strategy1, Strategy $strategy2): void
    {
        $strategy1Name = get_class($strategy1);
        $strategy2Name = get_class($strategy2);

        // Clone the strategy to avoid any history affecting subsequent games
        $cloneStrategy1 = clone $strategy1;
        $cloneStrategy2 = clone $strategy2;

        $player1 = Player::createPlayer($cloneStrategy1);
        $player2 = Player::createPlayer($cloneStrategy2);

        $this->logger->log('Set up game', [
            'iterations' => $this->iterations,
            'strategy1' => $strategy1Name,
            'score1' => $player1->getPoints(),
            'strategy2' => $strategy2Name,
            'score2' => $player2->getPoints(),
        ]);

        $this->logger->log('Underscore is cooperate, hash is defect');

        $game = Game::createGame($player1, $player2, $this->logger);

        for ($i = 0; $i < $this->iterations; $i++) {
            $game->playRound();
        }

        if (!isset($this->scoreByStrategy[$strategy1Name])) {
            $this->scoreByStrategy[$strategy1Name] = 0;
        }

        if (!isset($this->scoreByStrategy[$strategy2Name])) {
            $this->scoreByStrategy[$strategy2Name] = 0;
        }

        $this->scoreByStrategy[$strategy1Name] += $player1->getPoints();
        $this->scoreByStrategy[$strategy2Name] += $player2->getPoints();

        $this->logger->log('Game complete', [
            'iterations' => $this->iterations,
            'strategy1' => $strategy1Name,
            'score1' => $player1->getPoints(),
            'strategy2' => $strategy2Name,
            'score2' => $player2->getPoints(),
        ]);
    }

    // Every player must play every other player
    public function run(): void
    {
        for ($i = 0; $i < count($this->strategies); $i++) {
            $strategy1 = $this->strategies[$i];

            for ($j = $i + 1; $j < count($this->strategies); $j++) {
                $strategy2 = $this->strategies[$j];
                $this->playGames($strategy1, $strategy2);
            }
        }

        arsort($this->scoreByStrategy);

        $this->logger->log('Final scores', $this->scoreByStrategy);
    }
}
