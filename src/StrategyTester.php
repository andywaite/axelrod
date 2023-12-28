<?php

namespace Andywaite\Axelrod;

class StrategyTester
{
    protected $scoreByStrategy = [];

    public static function createGameMatrixer(array $strategies, int $iterations): self
    {
        return new StrategyTester($iterations, $strategies);
    }

    public function __construct(protected int $iterations, protected array $strategies)
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

        echo "\n\nSet up game for {$this->iterations} iterations, {$strategy1Name} initial score {$player1->getPoints()} and {$strategy2Name} initial score {$player2->getPoints()}";

        $game = Game::createGame($player1, $player2);

        for ($i = 0; $i < $this->iterations; $i++) {
            $game->play();
        }

        if (!isset($this->scoreByStrategy[$strategy1Name])) {
            $this->scoreByStrategy[$strategy1Name] = 0;
        }

        if (!isset($this->scoreByStrategy[$strategy2Name])) {
            $this->scoreByStrategy[$strategy2Name] = 0;
        }

        $this->scoreByStrategy[$strategy1Name] += $player1->getPoints();
        $this->scoreByStrategy[$strategy2Name] += $player2->getPoints();

        echo "\nAfter {$this->iterations} iterations, {$strategy1Name} scored {$player1->getPoints()} and {$strategy2Name} scored {$player2->getPoints()}";
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

        echo "\n\nFinal scores:\n";
        foreach ($this->scoreByStrategy as $strategy => $score) {
            echo "\n{$strategy} scored {$score}";
        }
    }
}
