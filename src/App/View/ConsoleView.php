<?php

namespace App\View;

use Knp\Component\Pager\Pagination\AbstractPagination;
use PcComponentes\Codebreaker\AttemptedGuess;
use PcComponentes\Codebreaker\Codebreaker;
use PcComponentes\Codebreaker\GameStats;
use PcComponentes\Codebreaker\View\View;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Style\OutputStyle;

class ConsoleView implements View
{
    /**
     * @var OutputStyle
     */
    private $io;

    public function __construct(OutputStyle $io)
    {
        $this->io = $io;
    }

    public function welcome(Codebreaker $codebreaker): void
    {
        $this->io->title("WELCOME TO CODEBREAKER");
        $this->io->text("You need to figure out a code of 4 numbers that range from 1 to 6");
        $this->io->text("Enter an empty code to exit.\n");

        $this->showPreviousAttempts($codebreaker);
    }

    private function showPreviousAttempts(Codebreaker $codebreaker)
    {
        $previousAttempts = [];
        foreach ($codebreaker->attemptedGuesses() as $attempt) {
            $previousAttempts[] = [
                (string) $attempt->guess(),
                $this->matches($attempt)
            ];
        }

        if (!empty($previousAttempts)) {
            $this->io->table(['Guesses', 'Matches'], $previousAttempts);
        }
    }

    public function readGuess(Codebreaker $codebreaker): ?string
    {
        do {
            $response = $this->io->ask(
                sprintf("Make a Guess (%s/%s)", $codebreaker->attempts() + 1, Codebreaker::TRIES)
            );
            if (empty($response) && $this->doYouReallyWantToExit()) {
                return null;
            }
        } while (empty($response));

        return $response;
    }

    private function doYouReallyWantToExit(): bool
    {
        return $this->io->confirm('Are you sure you want to quit?', true);
    }

    public function notAValidGuess(): void
    {
        $this->io->error("A valid code has 4 digits and numbers from 1 to 6");
    }

    public function guessMatches(Codebreaker $codebreaker): void
    {
        $this->io->text(sprintf("Result: %s", $this->matches($codebreaker->lastResult())));
    }

    private function matches(AttemptedGuess $attempt)
    {
        return sprintf(
            "%s%s",
            str_repeat('+', $attempt->exact()),
            str_repeat('-', $attempt->partial())
        );
    }

    public function endOfGame(Codebreaker $codebreaker): void
    {
        if ($codebreaker->hasBeenFound()) {
            $this->io->success(
                sprintf(
                    "You broke the code (%s) in %s attempts\n",
                    $codebreaker->secretCode(),
                    $codebreaker->attempts()
                )
            );
        } else {
            $this->io->error(sprintf("You didn't break the code (%s)\n", $codebreaker->secretCode()));
        }
    }

    public function chooseGame(array $games): ?Codebreaker
    {
        $this->io->title("RESUME A GAME");

        if (0 >= count($games)) {
            return null;
        }

        $gameOptions = [];
        $options = [];
        foreach ($games as $game) {
            $options[$game->id()] = (string) $game;
            $gameOptions[(string) $game] = $game;
        }

        return $gameOptions[$this->io->choice("Select a game", $options, (string) $games[0])];
    }

    public function showStats(GameStats $stats)
    {
        $this->io->table(
            [
            'average',
            'minimum',
            'win',
            'lost',
            'played',
            'not finished',
            'total'
        ],
            [
                [
                    $stats->average(),
                    $stats->minimum(),
                    $stats->win(),
                    $stats->lost(),
                    $stats->played(),
                    $stats->notFinished(),
                    $stats->total()
                ]
            ]
        );
    }

    public function showPlayedGames(AbstractPagination $games)
    {
        // @TODO: Make a nice table

        $this->io->table([
            array_map(function (Codebreaker $codebreaker) { return new TableCell('Game ' . $codebreaker->id(), ['colspan' => 2]); }, $games->getItems()),
            ['Guess', 'Match']
        ], [['a']]);
    }
}
