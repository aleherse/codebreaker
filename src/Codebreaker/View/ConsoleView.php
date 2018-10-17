<?php

namespace PcComponentes\Codebreaker\View;

use PcComponentes\Codebreaker\Codebreaker;
use Symfony\Component\Console\Style\OutputStyle;

class ConsoleView
{
    /**
     * @var OutputStyle
     */
    private $io;

    public function __construct(OutputStyle $io)
    {
        $this->io = $io;
    }

    public function welcome(): void
    {
        $this->io->title("WELCOME TO CODEBREAKER");
        $this->io->text("You need to figure out a code of 4 numbers that range from 1 to 6");
        $this->io->text("Enter an empty code to exit.\n");
    }

    public function readGuess(): ?string
    {
        do {
            $response = $this->io->ask("Make a Guess");
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
        $this->io->text(sprintf(
            "Result: %s%s",
            str_repeat('+', $codebreaker->lastResult()->exact()),
            str_repeat('-', $codebreaker->lastResult()->partial())
        ));
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
}
