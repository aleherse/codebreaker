<?php

namespace App\Codebreaker;

use App\Entity\Player;

class CommandGames extends Games
{
    public function play(View $view, Player $player = null)
    {
        $this->playGame(
            $this->codebreakers->new($player),
            $view
        );
    }

    public function resume(View $view, Player $player)
    {
        $games = $this->codebreakers->pendingGames($player);
        $game = $view->chooseGame($games);

        if (null !== $game) {
            $this->playGame($game, $view);
        }
    }
}
