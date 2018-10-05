<?php

namespace PcComponentes\Codebreaker;

class GuessChecker
{
    /**
     * @var SecretCode
     */
    private $code;

    /**
     * @var int[]
     */
    private $times;

    /**
     * @var int[]
     */
    private $numbers;

    public function __construct(SecretCode $secretCode)
    {
        $this->code = $secretCode;
    }

    public function check(array $numbers): CheckResult
    {
        $this->times = $this->code->times();
        $this->numbers = $numbers;

         return new CheckResult(
            $this->findExactMatches(),
            $this->findPartialMatches(),
            $this->code->size()
        );
    }

    private function findExactMatches(): int
    {
        $exact = 0;
        for ($j = 0; $j < $this->code->size(); $j++) {
            if ($this->code->in($j) == $this->numbers[$j]) {
                $exact++;
                $this->times[$this->numbers[$j]]--;
                $this->numbers[$j] = null;
            }
        }

        return $exact;
    }

    private function findPartialMatches(): int
    {
        $partial = 0;
        for ($j = 0; $j < $this->code->size(); $j++) {
            if (null !== $this->numbers[$j] && $this->times[$this->numbers[$j]] > 0) {
                $partial++;
                $this->times[$this->numbers[$j]]--;
            }
        }

        return $partial;
    }
}
