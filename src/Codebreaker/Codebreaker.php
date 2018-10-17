<?php

namespace PcComponentes\Codebreaker;

class Codebreaker
{
    const TRIES = 10;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var Code
     */
    protected $secret;

    /**
     * @var int
     */
    protected $attempts = 0;

    /**
     * @var bool
     */
    protected $found = false;

    /**
     * @var CheckResult
     */
    private $result;

    public function __construct(Code $secretCode)
    {
        $this->secret = $secretCode;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function secretCode(): Code
    {
        return $this->secret;
    }

    public function check(Code $guess): void
    {
        $this->result = (new GuessChecker($this->secret, $guess))->result();

        $this->found = $this->secret->size() === $this->result->exact();
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

    public function __toString()
    {
        return sprintf("id: %s, attempts: %s, found: %s", $this->id, $this->attempts, $this->found ? 'yes' : 'no');
    }
}
