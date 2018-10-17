<?php

namespace PcComponentes\Codebreaker;

use PcComponentes\Codebreaker\View\ConsoleView;

class Games
{
    /**
     * @var CodebreakerRepository
     */
    private $codebreakers;

    public function __construct(CodebreakerRepository $codebreakers)
    {
        $this->codebreakers = $codebreakers;
    }

    public function play(ConsoleView $view)
    {
        $codebreaker = $this->codebreakers->new();

        $view->welcome();

        while ($codebreaker->canPlay()) {
            $numbers = $view->readGuess();
            if (null === $numbers) {
                exit(0);
            }

            try {
                $guess = Code::fromGuess($numbers);
            } catch (\InvalidArgumentException $e) {
                $view->notAValidGuess();
                continue;
            }

            $codebreaker->check($guess);

            $this->codebreakers->save($codebreaker);

            $view->guessMatches($codebreaker);
        }

        $view->endOfGame($codebreaker);
    }
}
