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
    protected $games;

    /**
     * @var Authentication
     */
    protected $auth;

    public function __construct(CommandGameHandler $games, Authentication $authentication)
    {
        parent::__construct(null);
        $this->games = $games;
        $this->auth = $authentication;
    }
}
