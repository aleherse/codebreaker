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
}
