<?php

namespace PcComponentes\Codebreaker;

use PcComponentes\Codebreaker\View\ConsoleView;

class Codebreaker
{
    public function execute()
    {
        $view = new ConsoleView();
        $code = SecretCode::random();
        $checker = new GuessChecker($code);

        $view->welcome();

        while ($checker->canPlay()) {
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
        }

        $view->endOfGame($checker);
    }
}
