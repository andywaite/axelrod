<?php

namespace Andywaite\Axelrod\Strategy;

use Andywaite\Axelrod\PlayChoices;
use Andywaite\Axelrod\Strategy;

class AbstractCollusion implements Strategy
{
    const ID_SEQUENCE = [
        PlayChoices::COOPERATE,
        PlayChoices::COOPERATE,
        PlayChoices::DEFECT,
        PlayChoices::DEFECT,
        PlayChoices::COOPERATE,
        PlayChoices::DEFECT,
        PlayChoices::DEFECT,
        PlayChoices::DEFECT,
        PlayChoices::COOPERATE,
        PlayChoices::DEFECT,
    ];

    protected PlayChoices $defaultWhenMatched = PlayChoices::DEFECT;

    protected array $opponentChoices = [];
    protected ?bool $isMatchedWithFriend = null;

    public function notifyOpponentChoice(PlayChoices $opponentChoice): void
    {
        $this->opponentChoices[] = $opponentChoice;

        if ($this->isMatchedWithFriend === null) {
            $currentOpponentChoicesIndex = count($this->opponentChoices) - 1;

            // No match, then we must be matched with someone else
            if ($opponentChoice !== self::ID_SEQUENCE[$currentOpponentChoicesIndex]) {
                $this->isMatchedWithFriend = false;
            } else if (count($this->opponentChoices) === count(self::ID_SEQUENCE)) {
                $this->isMatchedWithFriend = true;
            }
        }
    }

    public function getChoice(): PlayChoices
    {
        // Just do tit-for-tat by default
        if ($this->isMatchedWithFriend === false) {
            return $this->opponentChoices[count($this->opponentChoices) - 1];
        }

        if ($this->isMatchedWithFriend === true) {
            return $this->defaultWhenMatched;
        }

        return self::ID_SEQUENCE[count($this->opponentChoices)];
    }
}
