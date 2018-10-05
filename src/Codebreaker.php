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
                exit(0);
            }

            try {
                $guess = new Guess($numbers);
            } catch(\InvalidArgumentException $e) {
                $view->notAValidGuess();
                continue;
            }

            $checkResult = $checker->check($guess);
            $view->guessMatches($checkResult);

            if ($checkResult->hasBeenFound()) {
                $found = true;
            }

            $try++;
        }

        $view->endOfGame($found, $try, $code);
    }
}
