<?php

namespace App\Codebreaker;

use App\Entity\Codebreaker;
use App\Entity\Player;

class CommandGameHandler
{
    /**
     * @var GameService
     */
    private $games;

    public function __construct(GameService $games)
    {
        $this->games = $games;
    }

    public function play(View $view, Player $player = null)
    {
        $this->playGame(
            $this->games->new($player),
            $view
        );
    }

    public function resume(View $view, Player $player)
    {
        $games = $this->games->pendingGames($player);
        $game = $view->chooseGame($games);

        if (null !== $game) {
            $this->playGame($game, $view);
        }
    }

    protected function playGame(Codebreaker $codebreaker, View $view)
    {
        $view->welcome($codebreaker);

        while ($codebreaker->canPlay()) {
            $numbers = $view->readGuess($codebreaker);
            if (null === $numbers) {
                return;
            }

            try {
                $this->games->playGameAttempt($codebreaker, $numbers);
            } catch (\InvalidArgumentException $e) {
                continue;
            }

            $view->guessMatches($codebreaker);
        }

        $view->endOfGame($codebreaker);
    }

    public function playedGames(View $view, Player $player)
    {
        // @TODO: Add pagination
        $games = $this->games->finishedGames($player, 1);

        $view->showPlayedGames($games);
    }

    public function stats(View $view)
    {
        $view->showStats(
            $this->games->stats()
        );
    }
}
