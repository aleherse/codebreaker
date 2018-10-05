<?php

namespace PcComponentes\Codebreaker;

use PcComponentes\Codebreaker\View\ConsoleView;

class Codebreaker
{
    const CODE_SIZE = 4;

    public function execute()
    {
        $view = new ConsoleView();

        $code = [
            (string)random_int(1, 6),
            (string)random_int(1, 6),
            (string)random_int(1, 6),
            (string)random_int(1, 6)
        ];

        $view->welcome();

        $found = false;
        $try = 0;
        while (!$found && $try < 10) {
            $numbers = $view->readGuess();
            if (null === $numbers) {
                if ($view->doesReallyWantToExit()) {
                    exit(0);
                } else {
                    continue;
                }
            }

            $numbers = str_split($numbers, 1);
            if (4 !== count($numbers)) {
                $view->notAValidGuess();
                continue;
            }

            $error = false;
            foreach ($numbers as $value) {
                if (!is_numeric($value) || $value < 1 || $value > 6) {
                    $view->notAValidGuess();
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

            $guess = new Guess($numbers);
            $exact = $guess->findExactMatches($code, $times);
            $partial = $guess->findPartialMatches($times);

            $view->guessMatches($exact, $partial);

            if (4 === $exact) {
                $found = true;
            }

            $try++;
        }

        $view->endOfGame($found, $try, $code);
    }
}
