<?php

namespace App\Command;

use PcComponentes\Codebreaker\Games;
use PcComponentes\Codebreaker\View\ConsoleView;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CodebreakerResumeCommand extends CodebreakerBaseCommand
{
    protected static $defaultName = 'codebreaker:resume';

    protected function configure()
    {
        $this->setDescription('Resume any of the unfinished games.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->game->resume(new ConsoleView(new SymfonyStyle($input, $output)));
    }
}
