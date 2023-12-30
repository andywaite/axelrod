<?php

namespace Andywaite\Axelrod\Strategy;

use Andywaite\Axelrod\PlayChoices;
use Andywaite\Axelrod\Strategy;
use OpenAI;

class GPT implements Strategy
{
    /**
     * @var array of PlayChoices
     */
    protected array $choices = [];

    public static function create(): self
    {
        if (!getenv('OPEN_AI_KEY')) {
            throw new \Exception('Cannot run GPT Strategy, OPEN_AI_KEY environment variable not set. See README for details');
        }

        $yourApiKey = getenv('OPEN_AI_KEY');
        $client = OpenAI::client($yourApiKey);
        return new self($client);
    }

    public function __construct(protected OpenAI\Client $openAI)
    {
    }

    public function notifyOpponentChoice(PlayChoices $opponentChoice): void
    {
        $this->choices[count($this->choices) - 1]['opponent'] = $opponentChoice;
    }

    protected function getPredictionFromOpenAi()
    {
        $request = [
            'model' => 'gpt-4-1106-preview',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are playing a series of games of the Prisoner\'s dilemma. The aim is to get the highest overall score possible after approximately 100 rounds. '.
                        'You should not be nice to your opponent, you are playing only to get the highest score for for yourself. '.
                        'Getting the highest score for yourself may involve cooperating with your opponent, but it may also involve defecting against your opponent. '.
                        'Try to take into account the historic moves of your opponent, but do not assume that they will always behave in the same way. '.
                        'As each response you must reply only with DEFECT or COOPERATE. '.
                        'You don\'t know what your opponent will do, but you do know that they are also playing this game. '.
                        'You will be scored on the total number of points you accumulate over the series of games. '.
                        'You & your opponent both get 3 points if you both COOPERATE. If you both DEFECT you will each get 1 point. '.
                        'If you COOPERATE and your opponent DEFECTS you will get 0 points and your opponent will get 5 points. '.
                        'If you DEFECT and your opponent COOPERATES you will get 5 points and your opponent will get 0 points. '.
                        'You can see the history of your opponent\'s moves below. You can also see the history of your own moves, but you cannot change them. '.
                        'You can also see the total number of points you have accumulated so far. '.
                        'You can also see the total number of games you have played so far. '.
                        'The game will be played for approximately 100 rounds, but the exact number is randomised to prevent you from knowing when the game will end.'
                ]
            ]
        ];

        $myRunningScore = 0;
        $opponentRunningScore = 0;

        foreach ($this->choices as $choice) {

            if ($choice['me'] === PlayChoices::COOPERATE && $choice['opponent'] === PlayChoices::COOPERATE) {
                $myRunningScore += 3;
                $opponentRunningScore += 3;
            } elseif ($choice['me'] === PlayChoices::DEFECT && $choice['opponent'] === PlayChoices::DEFECT) {
                $myRunningScore += 1;
                $opponentRunningScore += 1;
            } elseif ($choice['me'] === PlayChoices::COOPERATE && $choice['opponent'] === PlayChoices::DEFECT) {
                $opponentRunningScore += 5;
            } elseif ($choice['me'] === PlayChoices::DEFECT && $choice['opponent'] === PlayChoices::COOPERATE) {
                $myRunningScore += 5;
            }

            $request['messages'][] = [
                'role' => 'assistant',
                'content' => $choice['me'] === PlayChoices::COOPERATE ? 'COOPERATE' : 'DEFECT',
            ];

            $opponentChoice = $choice['opponent'] === PlayChoices::COOPERATE ? 'COOPERATE' : 'DEFECT';
            $request['messages'][] = [
                'role' => 'user',
                'content' => 'Your opponent chose '.$opponentChoice.
                    '. Your score is '.$myRunningScore.'. Your opponent\'s score is '.$opponentRunningScore
            ];
        }

        if (count($this->choices) === 0) {
            $request['messages'][] = [
                'role' => 'user',
                'content' => 'You have not yet made a move. Please reply only with either COOPERATE or DEFECT',
            ];
        } else {
            $request['messages'][] = [
                'role' => 'user',
                'content' => 'Please make your next move by replying only COOPERATE or DEFECT',
            ];
        }

        $response = $this->openAI->chat()->create($request);

        if ($response['object'] === 'error') {
            throw new \Exception('OpenAI error: '.$response['error']['message']);
        }

        $prediction = $response['choices'][0]['message']['content'];

        if (!in_array($prediction, ['COOPERATE', 'DEFECT'])) {
            throw new \Exception('OpenAI error: unexpected response: '.$prediction);
        }

        return strtoupper($prediction) === 'COOPERATE' ? PlayChoices::COOPERATE : PlayChoices::DEFECT;
    }

    public function getChoice(): PlayChoices
    {
        $myChoice = $this->getPredictionFromOpenAi();

        $this->choices[] = [
            'me' => $myChoice,
        ];

        return $myChoice;
    }
}
