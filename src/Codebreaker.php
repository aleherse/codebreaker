<?php

namespace PcComponentes\Codebreaker;

use PcComponentes\Codebreaker\View\ConsoleView;

class Codebreaker
{
    /**
     * @var ConsoleView
     */
    private $view;

    public function __construct()
    {
        $this->view = new ConsoleView();
    }

    public function execute(SecretCode $code)
    {
        $checker = new GuessChecker($code);

        $this->view->welcome();

        while ($checker->canPlay()) {
            $numbers = $this->view->readGuess();
            if (null === $numbers) {
                exit(0);
            }

            try {
                $guess = new Guess($numbers);
            } catch(\InvalidArgumentException $e) {
                $this->view->notAValidGuess();
                continue;
            }

            $checkResult = $checker->check($guess);

            $this->view->guessMatches($checkResult);
        }

        $this->view->endOfGame($checker);
    }
}
