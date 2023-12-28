<?php

namespace Andywaite\Axelrod\Strategy;

use Andywaite\Axelrod\PlayChoices;
use Andywaite\Axelrod\Strategy;

class AlwaysNasty implements Strategy
{

    public function getChoice(): PlayChoices
    {
        return PlayChoices::DEFECT;
    }

    public function notifyOpponentChoice(PlayChoices $opponentChoice): void
    {
        // We don't care
    }
}
