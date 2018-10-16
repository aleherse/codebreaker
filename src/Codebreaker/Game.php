<?php

namespace PcComponentes\Codebreaker;

use PcComponentes\Codebreaker\View\ConsoleView;

class Game
{
    /**
     * @var ConsoleView
     */
    private $view;

    public function __construct()
    {
        $this->view = new ConsoleView();
    }

    public function execute()
    {
        $code = SecretCode::random();
        $codebreaker = new Codebreaker($code);

        $this->view->welcome();

        while ($codebreaker->canPlay()) {
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

            $codebreaker->check($guess);

            $this->view->guessMatches($codebreaker);
        }

        $this->view->endOfGame($codebreaker);
    }
}
