<?php

namespace PcComponentes\Codebreaker\View;

use PcComponentes\Codebreaker\CheckResult;
use PcComponentes\Codebreaker\GuessChecker;

class ConsoleView
{
    public function welcome(): void
    {
        fwrite(STDOUT, "Welcome to codebreaker you need to figure out a code of 4 numbers that range from 1 to 6\n");
        fwrite(STDOUT, "Enter an empty code to exit.\n\n");
    }

    public function readGuess(): ?string
    {
        fwrite(STDOUT, "Make a Guess: ");

        do {
            $response = trim(fgets(STDIN));
            if (empty($response) && $this->doYouReallyWantToExit()) {
                return null;
            }
        } while (empty($response));

        return $response;
    }

    private function doYouReallyWantToExit(): bool
    {
        fwrite(STDOUT, "Are you sure you want to quit? (Y/n): ");
        $response = trim(fgets(STDIN));

        return 'y' === strtolower($response) || empty($response);
    }

    public function notAValidGuess(): void
    {
        fwrite(STDOUT, "A valid code has 4 digits and numbers from 1 to 6\n");
    }

    public function guessMatches(CheckResult $result): void
    {
        fwrite(STDOUT, "Result: ");
        fwrite(STDOUT, str_repeat('+', $result->exact()));
        fwrite(STDOUT, str_repeat('-', $result->partial()) . "\n");
    }

    public function endOfGame(GuessChecker $checker): void
    {
        if ($checker->hasBeenFound()) {
            fwrite(STDOUT, sprintf("You broke the code (%s) in %s attempts\n", $checker->secretCode(), $checker->attempts()));
        } else {
            fwrite(STDOUT, sprintf("You didn't break the code (%s)\n", $checker->secretCode()));
        }
    }
}
