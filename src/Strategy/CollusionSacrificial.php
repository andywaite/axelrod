<?php

namespace Andywaite\Axelrod\Strategy;

use Andywaite\Axelrod\PlayChoices;

class CollusionSacrificial extends AbstractCollusion
{
    protected PlayChoices $defaultWhenMatched = PlayChoices::COOPERATE;
}
