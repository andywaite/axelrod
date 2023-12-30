# Axelrod

Axelrod is a simulator for the game Prisoner's dilemma, designed to test different competing strategies.

## Installation
`composer install`

## Usage
`php run.php`

## Why have you made this?
Christmas break project - I felt inspired to try making this after watching this [Veritasium video called "What The Prisoner's Dilemma Reveals About Life, The Universe, and Everything"](https://www.youtube.com/watch?v=mScpHTIi-kM). I wanted to try my hand at creating some of the strategies mentioned in the study, as well as formulating my own. I encourage you to watch the video, it's very interesting and will provide some context for this project.

This project is named after [Robert Axelrod](https://en.wikipedia.org/wiki/Robert_Axelrod), who is a professor of political science at the University of Michigan. He is the author of the book [The Evolution of Cooperation](https://en.wikipedia.org/wiki/The_Evolution_of_Cooperation), which is a study of the Prisoner's dilemma and how it relates to global politics.

## What is the Prisoner's dilemma game?
The Prisoner's dilemma is a game where two players are given the choice to either cooperate or defect. If both players cooperate, they both get 3 points. If both players defect, they both get 1 point. If one player cooperates and the other defects, the defector gets 5 points and the cooperator gets 0 points.

The game is called the Prisoner's dilemma because it's a good analogy for the situation two prisoners are in when they're being interrogated by the police. If they both stay silent, they both get a light sentence. If they both confess, they both get a heavy sentence. If one confesses and the other stays silent, the confessor gets a light sentence and the other gets a heavy sentence.

## Why is it interesting?

While the game is fun to play as a one-off, it gets more interesting when you play it multiple times. You can start to build up a reputation with the other player, and you can start to exploit their behaviour.

Many studies have been done on the Prisoner's dilemma, and many strategies have been developed to try and win the game. This project is a simulator for the game, so you can test different strategies against each other.

Academics have drawn parallels between these strategies and global politics, and have used the Prisoner's dilemma to try and understand how countries interact with each other. 

## How it works
This project contains a number of game strategies. Each strategy is pitted against each other strategy around 10,000 times (the exact number is slightly randomised, to avoid strategies exploiting a known number of turns).

The strategies are scored based on the number of points they get in total after playing all the other opponents.

The strategies are then ranked based on their score and output, so you can see how they performed.

## Adding a strategy
Strategies are stored in `src/Strategy`. Every strategy must implement the `StrategyInterface` interface.

The interface has two methods: `getChoice` and `notifyOpponentChoice`. The first one is called every turn to get the choice of the strategy. The second one is called every turn to notify the strategy of the opponent's choice in the previous game.

See `src/Strategy/TitForTat.php` and the other files in this folder for examples of a strategies.

Once you've added a strategy, add it to the array in `run.php` file to test it.

## Using GPT to play the game
I've also added a strategy that uses [GPT-3](https://en.wikipedia.org/wiki/GPT-3) to play the game. It's not very good at the game, but it's interesting to see how it plays.

To use it, you'll need to create a `.env` file with your OpenAI API key in it. See `.env.example` for an example. You'll then need to add the GPT strategy to the array in `run.php` file to test it.

What I've noticed is it tends to begin by cooperating for around 5-8 turns. It then tries to defect, and has a handful of turns where it seems to be testing its opponent. However, it then seems to settle on a strategy of defecting every turn (which is not usually optimal). I'm not sure why this is, but it's interesting to see.

You may wish to play with the prompt in `src/Strategy/GPT.php` to see if you can get it to play better.
