<?php

namespace App\Command;

use App\Codebreaker\CommandGames;
use App\Security\Authentication;
use Symfony\Component\Console\Command\Command;

abstract class CodebreakerBaseCommand extends Command
{
    /**
     * @var CommandGames
     */
    protected $game;

    /**
     * @var Authentication
     */
    protected $auth;

    public function __construct(CommandGames $game, Authentication $authentication)
    {
        parent::__construct(null);
        $this->game = $game;
        $this->auth = $authentication;
    }
}
