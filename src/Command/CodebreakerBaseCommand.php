<?php

namespace App\Command;

use App\Codebreaker\CommandGameHandler;
use App\Security\Authentication;
use Symfony\Component\Console\Command\Command;

abstract class CodebreakerBaseCommand extends Command
{
    /**
     * @var CommandGameHandler
     */
    protected $game;

    /**
     * @var Authentication
     */
    protected $auth;

    public function __construct(CommandGameHandler $game, Authentication $authentication)
    {
        parent::__construct(null);
        $this->game = $game;
        $this->auth = $authentication;
    }
}
