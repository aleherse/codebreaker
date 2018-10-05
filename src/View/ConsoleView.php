<?php

namespace PcComponentes\Codebreaker\View;

class ConsoleView
{
    public function welcome(): void
    {
        fwrite(STDOUT, "Welcome to codebreaker you need to figure out a code of 4 numbers that range from 1 to 6\n");
        fwrite(STDOUT, "Enter an empty code to exit.\n\n");
    }

    public function askForGuess(): void
    {
        fwrite(STDOUT, "Make a Guess: ");
    }

    public function askForExitConfirmation(): void
    {
        fwrite(STDOUT, "Are you sure you want to quit? (Y/n): ");
    }

    public function notAValidGuess(): void
    {
        fwrite(STDOUT, "A valid code has 4 digits and numbers from 1 to 6\n");
    }

    public function guessMatches(int $exact, int $partial): void
    {
        fwrite(STDOUT, "Result: ");
        fwrite(STDOUT, str_repeat('+', $exact));
        fwrite(STDOUT, str_repeat('-', $partial) . "\n");
    }

    public function endOfGame(bool $found, int $try, array $code): void
    {
        if ($found) {
            fwrite(STDOUT, sprintf("You broke the code (%s) in %s attempts\n", implode($code), $try));
        } else {
            fwrite(STDOUT, sprintf("You didn't break the code (%s)\n", implode($code)));
        }
    }
}
