<?php

namespace PcComponentes\Codebreaker;

class GuessChecker
{
    const TRIES = 10;

    /**
     * @var SecretCode
     */
    private $code;

    /**
     * @var int[]
     */
    private $occurrencesOfNumbers;

    /**
     * @var int[]
     */
    private $guessNumbers;

    /**
     * @var int
     */
    private $attempts = 0;

    /**
     * @var bool
     */
    private $found = false;

    public function __construct(SecretCode $secretCode)
    {
        $this->code = $secretCode;
    }

    public function secretCode(): SecretCode
    {
        return $this->code;
    }

    public function check(Guess $guess): CheckResult
    {
        $this->occurrencesOfNumbers = $this->code->occurrencesOfNumbers();
        $this->guessNumbers = $guess->numbers();

        $exact = $this->findExactMatches();
        $partial = $this->findPartialMatches();

        $this->found = $this->code->size() === $exact;
        $this->attempts++;

        return new CheckResult($exact, $partial);
    }

    private function findExactMatches(): int
    {
        $exact = 0;
        for ($j = 0; $j < $this->code->size(); $j++) {
            if ($this->code->in($j) === $this->guessNumbers[$j]) {
                $exact++;
                $this->occurrencesOfNumbers[$this->guessNumbers[$j]]--;
                $this->guessNumbers[$j] = null;
            }
        }

        return $exact;
    }

    private function findPartialMatches(): int
    {
        $partial = 0;
        for ($j = 0; $j < $this->code->size(); $j++) {
            if (null !== $this->guessNumbers[$j] && $this->occurrencesOfNumbers[$this->guessNumbers[$j]] > 0) {
                $partial++;
                $this->occurrencesOfNumbers[$this->guessNumbers[$j]]--;
            }
        }

        return $partial;
    }

    public function attempts(): int
    {
        return $this->attempts;
    }

    public function hasMoreAttempts(): bool
    {
        return $this->attempts < self::TRIES;
    }

    public function hasBeenFound(): bool
    {
        return $this->found;
    }

    public function canPlay(): bool
    {
        return !$this->hasBeenFound() && $this->hasMoreAttempts();
    }
}
