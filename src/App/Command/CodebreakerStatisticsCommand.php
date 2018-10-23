<?php

namespace App\Command;

use PcComponentes\Codebreaker\View\ConsoleView;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CodebreakerStatisticsCommand extends CodebreakerBaseCommand
{
    protected static $defaultName = 'codebreaker:stats';

    protected function configure()
    {
        $this->setDescription('Show statistics about the games played to codebreaker');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $view = new ConsoleView(new SymfonyStyle($input, $output));

        $this->game->showStats($view);
    }
}
