<?php

namespace App\Command;

use App\Codebreaker\View\ConsoleView;
use App\Security\Authentication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CodebreakerLoginCommand extends Command
{
    protected static $defaultName = 'codebreaker:login';

    /**
     * @var Authentication
     */
    private $authentication;

    public function __construct(Authentication $authentication)
    {
        parent::__construct();
        $this->authentication = $authentication;
    }

    protected function configure()
    {
        $this->setDescription('logs a player');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $view = new ConsoleView(new SymfonyStyle($input, $output));

        $player = $this->authentication->player(
            $view->askForUsername(),
            $view->askForPassword()
        );

        $view->showLoginResult(null === $player ? false : true);
    }
}
