<?php

namespace App\Command;

use App\Codebreaker\View\ConsoleView;
use Symfony\Component\Console\Input\InputInterface;
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
