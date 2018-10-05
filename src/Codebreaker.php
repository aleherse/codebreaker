<?php

namespace PcComponentes\Codebreaker;

class Codebreaker
{
    const CODE_SIZE = 4;

    public function execute()
    {
        $code = [
            (string)random_int(1, 6),
            (string)random_int(1, 6),
            (string)random_int(1, 6),
            (string)random_int(1, 6)
        ];

        $this->printWelcomeMessage();

        $found = false;
        $try = 0;
        while (!$found && $try < 10) {
            $this->printAskForGuess();
            $guess = trim(fgets(STDIN));
            if (empty($guess)) {
                $this->printAskForExitConfirmation();
                $response = trim(fgets(STDIN));
                if ('y' === strtolower($response) || empty($response)) {
                    exit(0);
                } else {
                    continue;
                }
            }

            $guess = str_split($guess, 1);
            if (4 !== count($guess)) {
                $this->printNotAValidCode();
                continue;
            }

            $error = false;
            foreach ($guess as $value) {
                if (!is_numeric($value) || $value < 1 || $value > 6) {
                    $this->printNotAValidCode();
                    $error = true;
                    break;
                }
            }

            if ($error) {
                continue;
            }

            $times = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0];
            foreach ($code as $value) {
                $times[$value]++;
            }

            $exact = 0;
            for ($j = 0; $j < self::CODE_SIZE; $j++) {
                if ($code[$j] === $guess[$j]) {
                    $exact++;
                    $times[$guess[$j]]--;
                    $guess[$j] = null;
                }
            }

            $partial = 0;
            for ($j = 0; $j < 4; $j++) {
                if (null !== $guess[$j] && $times[$guess[$j]] > 0) {
                    $partial++;
                    $times[$guess[$j]]--;
                }
            }

            $this->printGuessMatches($exact, $partial);

            if (4 === $exact) {
                $found = true;
            }

            $try++;
        }

        $this->printEndOfGame($found, $code, $try);
    }

    public function printWelcomeMessage(): void
    {
        fwrite(STDOUT, "Welcome to codebreaker you need to figure out a code of 4 numbers that range from 1 to 6\n");
        fwrite(STDOUT, "Enter an empty code to exit.\n\n");
    }

    public function printAskForGuess(): void
    {
        fwrite(STDOUT, "Make a Guess: ");
    }

    public function printAskForExitConfirmation(): void
    {
        fwrite(STDOUT, "Are you sure you want to quit? (Y/n): ");
    }

    public function printNotAValidCode(): void
    {
        fwrite(STDOUT, "A valid code has 4 digits and numbers from 1 to 6\n");
    }

    public function printGuessMatches($exact, $partial): void
    {
        fwrite(STDOUT, "Result: ");
        fwrite(STDOUT, str_repeat('+', $exact));
        fwrite(STDOUT, str_repeat('-', $partial) . "\n");
    }

    public function printEndOfGame($found, $code, $try): void
    {
        if ($found) {
            fwrite(STDOUT, sprintf("You broke the code (%s) in %s attempts\n", implode($code), $try));
        } else {
            fwrite(STDOUT, sprintf("You didn't break the code (%s)\n", implode($code)));
        }
    }
}
