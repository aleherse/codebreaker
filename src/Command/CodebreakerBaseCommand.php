<?php

namespace App\Command;

use App\Codebreaker\Games;
use Symfony\Component\Console\Command\Command;

abstract class CodebreakerBaseCommand extends Command
{
    /**
     * @var Games
     */
    protected $game;

    public function __construct(Games $game)
    {
        parent::__construct(null);
        $this->game = $game;
    }
}
