<?php

namespace App\Command;

use PcComponentes\Codebreaker\View\ConsoleView;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CodebreakerGamesCommand extends CodebreakerBaseCommand
{
    protected static $defaultName = 'codebreaker:games';

    protected function configure()
    {
        $this->setDescription('Shows the games played');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->game->playedGames(new ConsoleView(new SymfonyStyle($input, $output)));
    }
}
