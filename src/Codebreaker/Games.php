<?php

namespace App\Codebreaker;

use App\Entity\Codebreaker;
use App\Entity\Player;
use App\Repository\CodebreakerRepository;
use App\Security\Authentication;

class Games
{
    /**
     * @var CodebreakerRepository
     */
    protected $codebreakers;

    /**
     * @var Authentication
     */
    protected $auth;

    public function __construct(CodebreakerRepository $codebreakers, Authentication $auth)
    {
        $this->codebreakers = $codebreakers;
        $this->auth = $auth;
    }

    public function resume(View $view)
    {
        if (null === $player = $this->auth->currentPlayer()) {
            $view->anonymousForbidden();
            return;
        }

        $game = $view->chooseGame(
            $this->codebreakers->continuableGames($player)
        );

        if (null !== $game) {
            $this->playGame($game, $view);
        }
    }

    public function new(Player $player): Codebreaker
    {
        return $this->codebreakers->new($player);
    }

    public function showStats(View $view)
    {
        $stats = $this->codebreakers->stats();

        $view->showStats($stats);
    }

    public function playedGames(View $view)
    {
        if (null === $player = $this->auth->currentPlayer()) {
            $view->anonymousForbidden();
            return;
        }

        // @TODO: Add pagination
        $games = $this->codebreakers->finishedGames($player, 1);

        $view->showPlayedGames($games);
    }

    protected function playGame(Codebreaker $codebreaker, View $view)
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
