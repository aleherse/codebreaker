<?php

namespace App\Command;

use PcComponentes\Codebreaker\Game;
use PcComponentes\Codebreaker\View\ConsoleView;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CodebreakerPlayCommand extends Command
{
    protected static $defaultName = 'codebreaker:play';
    /**
     * @var Game
     */
    private $game;

    public function __construct(?string $name = null, Game $game)
    {
        parent::__construct($name);
        $this->game = $game;
    }

    protected function configure()
    {
        $this->setDescription('Play a game of codebreaker');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->game->execute(new ConsoleView(new SymfonyStyle($input, $output)));
    }
}
