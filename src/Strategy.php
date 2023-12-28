<?php

namespace Andywaite\Axelrod;

enum PlayChoices {
    case COOPERATE;
    case DEFECT;
}

interface Strategy
{
    public function notifyOpponentChoice(PlayChoices $opponentChoice): void;
    public function getChoice(): PlayChoices;
}
