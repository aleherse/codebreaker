<?php

namespace PcComponentes\Codebreaker;

class Codebreaker
{
    const TRIES = 10;

    /**
     * @var SecretCode
     */
    private $code;

    /**
     * @var int
     */
    private $attempts = 0;

    /**
     * @var bool
     */
    private $found = false;

    /**
     * @var CheckResult
     */
    private $result;

    public function __construct(SecretCode $secretCode)
    {
        $this->code = $secretCode;
    }

    public function secretCode(): SecretCode
    {
        return $this->code;
    }

    public function check(Guess $guess): void
    {
        $this->result = (new GuessChecker($this->code, $guess))->result();

        $this->found = $this->code->size() === $this->result->exact();
        $this->attempts++;
    }

    public function lastResult(): CheckResult
    {
        return $this->result;
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
