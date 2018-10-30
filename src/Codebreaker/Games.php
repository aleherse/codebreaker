<?php

namespace PcComponentes\Codebreaker;

use PcComponentes\Codebreaker\View\View;

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

    public function resume(View $view)
    {
        $game = $view->chooseGame(
            $this->codebreakers->continuableGames()
        );

        if (null !== $game) {
            $this->playGame($game, $view);
        }
    }

    public function play(View $view)
    {
        $this->playGame(
            $this->codebreakers->new(),
            $view
        );
    }

    public function showStats(View $view)
    {
        $stats = $this->codebreakers->stats();

        $view->showStats($stats);
    }

    public function playedGames(View $view)
    {
        // @TODO: Add pagination
        $games = $this->codebreakers->finishedGames(1);

        $view->showPlayedGames($games);
    }

    private function playGame(Codebreaker $codebreaker, View $view)
    {
        if (null === $codebreaker) {
            $codebreaker = $this->codebreakers->new();
        }

        $view->welcome($codebreaker);

        while ($codebreaker->canPlay()) {
            $numbers = $view->readGuess($codebreaker);
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
