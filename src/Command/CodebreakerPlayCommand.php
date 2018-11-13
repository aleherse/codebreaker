<?php

namespace App\Command;

use App\Codebreaker\View\ConsoleView;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CodebreakerPlayCommand extends CodebreakerBaseCommand
{
    protected static $defaultName = 'codebreaker:play';

    protected function configure()
    {
        $this->setDescription('Play a game of codebreaker.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->games->play(
            new ConsoleView(new SymfonyStyle($input, $output)),
            $this->auth->currentPlayer()
        );
    }
}
