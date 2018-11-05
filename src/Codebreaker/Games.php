<?php

namespace App\Codebreaker;

use App\Entity\Codebreaker;
use App\Repository\CodebreakerRepository;
use App\Security\Authentication;

class Games
{
    /**
     * @var CodebreakerRepository
     */
    private $codebreakers;

    /**
     * @var Authentication
     */
    private $auth;

    public function __construct(CodebreakerRepository $codebreakers, Authentication $auth)
    {
        $this->codebreakers = $codebreakers;
        $this->auth = $auth;
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
            $this->codebreakers->new($this->auth->currentPlayer()),
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
