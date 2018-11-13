<?php

namespace App\Command;

use App\Codebreaker\View\ConsoleView;
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
        $view = new ConsoleView(new SymfonyStyle($input, $output));

        if (null === $player = $this->auth->currentPlayer()) {
            $view->anonymousForbidden();
            return;
        }

        $this->games->playedGames($view, $player);
    }
}
