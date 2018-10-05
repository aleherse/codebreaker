<?php

namespace PcComponentes\Codebreaker;

class Guess
{
    /**
     * @var string[]
     */
    private $numbers;

    public function __construct(array $numbers)
    {
        $this->numbers = $numbers;
    }

    public function findPartialMatches(array &$times): int
    {
        $partial = 0;
        for ($j = 0; $j < 4; $j++) {
            if (null !== $this->numbers[$j] && $times[$this->numbers[$j]] > 0) {
                $partial++;
                $times[$this->numbers[$j]]--;
            }
        }

        return $partial;
    }

    public function findExactMatches(array $code, array &$times): int
    {
        $exact = 0;
        for ($j = 0; $j < Codebreaker::CODE_SIZE; $j++) {
            if ($code[$j] === $this->numbers[$j]) {
                $exact++;
                $times[$this->numbers[$j]]--;
                $guess[$j] = null;
            }
        }

        return $exact;
    }
}