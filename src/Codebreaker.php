<?php

namespace PcComponentes\Codebreaker;

use PcComponentes\Codebreaker\View\ConsoleView;

class Codebreaker
{
    const CODE_SIZE = 4;

    public function execute()
    {
        $view = new ConsoleView();

        $code = [
            (string)random_int(1, 6),
            (string)random_int(1, 6),
            (string)random_int(1, 6),
            (string)random_int(1, 6)
        ];

        $view->welcome();

        $found = false;
        $try = 0;
        while (!$found && $try < 10) {
            $guess = $view->readGuess();
            if (null === $guess) {
                if ($view->doesReallyWantToExit()) {
                    exit(0);
                } else {
                    continue;
                }
            }

            $guess = str_split($guess, 1);
            if (4 !== count($guess)) {
                $view->notAValidGuess();
                continue;
            }

            $error = false;
            foreach ($guess as $value) {
                if (!is_numeric($value) || $value < 1 || $value > 6) {
                    $view->notAValidGuess();
                    $error = true;
                    break;
                }
            }

            if ($error) {
                continue;
            }

            $times = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0];
            foreach ($code as $value) {
                $times[$value]++;
            }

            $exact = $this->findExactMatches($code, $guess, $times);
            $partial = $this->findPartialMatches($guess, $times);

            $view->guessMatches($exact, $partial);

            if (4 === $exact) {
                $found = true;
            }

            $try++;
        }

        $view->endOfGame($found, $try, $code);
    }

    public function findPartialMatches(array $guess, array &$times): int
    {
        $partial = 0;
        for ($j = 0; $j < 4; $j++) {
            if (null !== $guess[$j] && $times[$guess[$j]] > 0) {
                $partial++;
                $times[$guess[$j]]--;
            }
        }

        return $partial;
    }

    public function findExactMatches(array $code, array $guess, array &$times): int
    {
        $exact = 0;
        for ($j = 0; $j < self::CODE_SIZE; $j++) {
            if ($code[$j] === $guess[$j]) {
                $exact++;
                $times[$guess[$j]]--;
                $guess[$j] = null;
            }
        }

        return $exact;
    }
}
