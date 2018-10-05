<?php

namespace PcComponentes\Codebreaker;

use PcComponentes\Codebreaker\View\ConsoleView;

class Codebreaker
{
    const TRIES = 10;

    public function execute()
    {
        $view = new ConsoleView();
        $code = SecretCode::random();
        $checker = new GuessChecker($code);

        $view->welcome();

        $found = false;
        $try = 0;
        while (!$found && $try < self::TRIES) {
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

            $checkResult = $checker->check($numbers);
            $view->guessMatches($checkResult);

            if ($checkResult->hasBeenFound()) {
                $found = true;
            }

            $try++;
        }

        $view->endOfGame($found, $try, $code);
    }
}
