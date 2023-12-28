<?php

    include 'vendor/autoload.php';

    use Andywaite\Axelrod\Strategy\AlwaysNice;
    use Andywaite\Axelrod\Strategy\AlwaysNasty;
    use Andywaite\Axelrod\Strategy\DoubleDefectRetaliate;
use Andywaite\Axelrod\Strategy\Friedman;
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
        new NormanLovett()
    ];

    $matrixer = StrategyTester::createGameMatrixer($strategies, rand(9876, 10102));
    $matrixer->run();


