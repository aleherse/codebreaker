<?php

namespace PcComponentes\Codebreaker;

class GuessChecker
{
    /**
     * @var Code
     */
    private $code;

    /**
     * @var int[]
     */
    private $occurrences;

    /**
     * @var int[]
     */
    private $guessNumbers;

    /**
     * @var CheckResult
     */
    private $result;

    public function __construct(Code $secret, Code $guess)
    {
        $this->code = $secret;
        $this->occurrences = $this->codeNumbersOccurrence($secret);
        $this->guessNumbers = $guess->numbers();

        $this->result = new CheckResult(
            $this->findExactMatches(),
            $this->findPartialMatches()
        );
    }

    private function codeNumbersOccurrence(Code $code)
    {
        $times = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0];
        for ($i = 0; $i < $code->size(); $i++) {
            $times[$code->in($i)]++;
        }

        return $times;
    }

    private function findExactMatches(): int
    {
        $exact = 0;
        for ($j = 0; $j < $this->code->size(); $j++) {
            if ($this->code->in($j) === $this->guessNumbers[$j]) {
                $exact++;
                $this->occurrences[$this->guessNumbers[$j]]--;
                $this->guessNumbers[$j] = null;
            }
        }

        return $exact;
    }

    private function findPartialMatches(): int
    {
        $partial = 0;
        for ($j = 0; $j < $this->code->size(); $j++) {
            if (null !== $this->guessNumbers[$j] && $this->occurrences[$this->guessNumbers[$j]] > 0) {
                $partial++;
                $this->occurrences[$this->guessNumbers[$j]]--;
            }
        }

        return $partial;
    }

    public function result(): CheckResult
    {
        return $this->result;
    }
}
