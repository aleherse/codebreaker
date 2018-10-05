<?php

namespace PcComponentes\Codebreaker;

class Guess
{
    const CODE_SIZE = 4;

    /**
     * @var string[]
     */
    private $numbers;

    /**
     * @var array
     */
    private $code;

    /**
     * @var int
     */
    private $exact;

    /**
     * @var int
     */
    private $partial;

    public function __construct(array $numbers, array $code)
    {
        $this->numbers = $numbers;
        $this->code = $code;

        $times = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0];
        foreach ($code as $value) {
            $times[$value]++;
        }

        $this->exact = $this->findExactMatches($code, $times);
        $this->partial = $this->findPartialMatches($times);
    }

    private function findPartialMatches(array &$times): int
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

    private function findExactMatches(array $code, array &$times): int
    {
        $exact = 0;
        for ($j = 0; $j < self::CODE_SIZE; $j++) {
            if ($code[$j] === $this->numbers[$j]) {
                $exact++;
                $times[$this->numbers[$j]]--;
                $guess[$j] = null;
            }
        }

        return $exact;
    }

    public function exact(): int
    {
        return $this->exact;
    }

    public function partial(): int
    {
        return $this->partial;
    }
}
