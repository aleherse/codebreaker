<?php

namespace PcComponentes\Codebreaker;

use Doctrine\Common\Collections\ArrayCollection;

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
     * @var AttemptedGuess[]|ArrayCollection
     */
    private $results;

    public function __construct(Code $secretCode)
    {
        $this->secret = $secretCode;
        $this->results = new ArrayCollection();
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
        $result = (new GuessChecker($this->secret, $guess))->result();

        $this->found = $this->secret->size() === $result->exact();
        $this->attempts++;

        $this->results->add($result);
    }

    public function lastResult(): AttemptedGuess
    {
        return $this->results->last();
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

    /**
     * @return AttemptedGuess[]|ArrayCollection
     */
    public function results(): ArrayCollection
    {
        return $this->results;
    }

    public function __toString()
    {
        return sprintf("id: %s, attempts: %s, found: %s", $this->id, $this->attempts, $this->found ? 'yes' : 'no');
    }
}
