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

class CodebreakerResumeCommand extends Command
{
    protected static $defaultName = 'codebreaker:resume';

    /**
     * @var Games
     */
    private $game;

    public function __construct(Games $game)
    {
        parent::__construct(null);
        $this->game = $game;
    }

    protected function configure()
    {
        $this->setDescription('Resume any of the unfinished games.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $view = new ConsoleView(new SymfonyStyle($input, $output));

        $this->game->play(
            $view,
            $this->game->chooseGameToResume($view)
        );
    }
}
