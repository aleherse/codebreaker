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
     * @var int
     */
    private $exact;

    /**
     * @var int
     */
    private $partial;

    /**
     * @var int[]
     */
    private $times;

    public function __construct(array $numbers, array $code)
    {
        $this->numbers = $numbers;

        $this->times = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0];
        foreach ($code as $value) {
            $this->times[$value]++;
        }

        $this->exact = $this->findExactMatches($code);
        $this->partial = $this->findPartialMatches();
    }

    private function findExactMatches(array $code): int
    {
        $exact = 0;
        for ($j = 0; $j < self::CODE_SIZE; $j++) {
            if ($code[$j] === $this->numbers[$j]) {
                $exact++;
                $this->times[$this->numbers[$j]]--;
                $guess[$j] = null;
            }
        }

        return $exact;
    }

    private function findPartialMatches(): int
    {
        $partial = 0;
        for ($j = 0; $j < 4; $j++) {
            if (null !== $this->numbers[$j] && $this->times[$this->numbers[$j]] > 0) {
                $partial++;
                $this->times[$this->numbers[$j]]--;
            }
        }

        return $partial;
    }

    public function exact(): int
    {
        return $this->exact;
    }

    public function partial(): int
    {
        return $this->partial;
    }

    public function isFound(): bool
    {
        return self::CODE_SIZE === $this->exact;
    }
}
