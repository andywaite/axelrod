<?php

namespace Andywaite\Axelrod\Strategy;

use Andywaite\Axelrod\PlayChoices;
use Andywaite\Axelrod\Strategy;

class AlwaysNice implements Strategy
{
    public function notifyOpponentChoice(PlayChoices $opponentChoice): void
    {
        // We don't care
    }

    public function getChoice(): PlayChoices
    {
        return PlayChoices::COOPERATE;
    }
}
