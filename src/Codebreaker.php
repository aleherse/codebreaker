<?php

namespace PcComponentes\Codebreaker;

use PcComponentes\Codebreaker\View\ConsoleView;

class Codebreaker
{
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

            $guess = new Guess($numbers, $code);
            $view->guessMatches(
                $guess->exact(),
                $guess->partial()
            );

            if ($guess->isFound()) {
                $found = true;
            }

            $try++;
        }

        $view->endOfGame($found, $try, $code);
    }
}
