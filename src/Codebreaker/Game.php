<?php

namespace PcComponentes\Codebreaker;

use PcComponentes\Codebreaker\View\ConsoleView;

class Game
{
    public function execute(ConsoleView $view)
    {
        $code = SecretCode::random();
        $codebreaker = new Codebreaker($code);

        $view->welcome();

        while ($codebreaker->canPlay()) {
            $numbers = $view->readGuess();
            if (null === $numbers) {
                exit(0);
            }

            try {
                $guess = new Guess($numbers);
            } catch (\InvalidArgumentException $e) {
                $view->notAValidGuess();
                continue;
            }

            $codebreaker->check($guess);

            $view->guessMatches($codebreaker);
        }

        $view->endOfGame($codebreaker);
    }
}
