<?php

include 'vendor/autoload.php';

// Load env
if (file_exists('.env')) {
    $env = parse_ini_file('.env');
    foreach ($env as $key => $value) {
        putenv("$key=$value");
    }
}

use Andywaite\Axelrod\Logger\Console;
use Andywaite\Axelrod\Strategy\AlwaysNice;
use Andywaite\Axelrod\Strategy\AlwaysNasty;
use Andywaite\Axelrod\Strategy\DoubleDefectRetaliate;
use Andywaite\Axelrod\Strategy\Friedman;
use Andywaite\Axelrod\Strategy\GPT;
use Andywaite\Axelrod\Strategy\GPTGenerated\AdaptiveStrategy;
use Andywaite\Axelrod\Strategy\GPTGenerated\AnalyticalAdaptiveStrategy;
use Andywaite\Axelrod\Strategy\GPTGenerated\ForgivingTitForTat;
use Andywaite\Axelrod\Strategy\GPTGenerated\PeriodicPlayer;
use Andywaite\Axelrod\Strategy\GPTGenerated\ProactiveAdaptiveStrategy;
use Andywaite\Axelrod\Strategy\GPTGenerated\RandomTitForTat;
use Andywaite\Axelrod\Strategy\Hannah;
use Andywaite\Axelrod\Strategy\Joss;
use Andywaite\Axelrod\Strategy\CollusionSacrificial;
use Andywaite\Axelrod\Strategy\CollusionWinner;
use Andywaite\Axelrod\Strategy\NormanLovett;
use Andywaite\Axelrod\Strategy\Random;
use Andywaite\Axelrod\Strategy\Tester;
use Andywaite\Axelrod\Strategy\TitForTat;
use Andywaite\Axelrod\StrategyTester;

$strategies = [
    new AlwaysNice(),
    new AlwaysNasty(),
    new TitForTat(),
    new Random(),
    new DoubleDefectRetaliate(),
    new Friedman(),
    new Joss(),
    new Tester(),
    new Hannah(),
    new CollusionSacrificial(),
    new CollusionWinner(),
    new NormanLovett(),
    new AdaptiveStrategy(),
    new AnalyticalAdaptiveStrategy(),
    new ForgivingTitForTat(),
    new PeriodicPlayer(),
    new RandomTitForTat(),
    new ProactiveAdaptiveStrategy()
//    GPT::create() // See readme.md for details. Note - this can create a large bill with OpenAI
];

$targetNumberOfGames = 10000;
$actualNumberOfGames = rand($targetNumberOfGames * 0.9, $targetNumberOfGames * 1.1); // Randomise the number of games within a 10% margin to prevent strategies from knowing when the game will end

$output = new Console();

$tester = StrategyTester::createStrategyTester($strategies, $actualNumberOfGames, $output);
$tester->run();


