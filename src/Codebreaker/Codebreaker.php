<?php

namespace PcComponentes\Codebreaker;

use Doctrine\Common\Collections\ArrayCollection;

class Codebreaker
{
    const TRIES = 10;

    /**
     * @var int
     */
    private $id;

    /**
     * @var Code
     */
    private $secret;

    /**
     * @var int
     */
    private $attempts = 0;

    /**
     * @var bool
     */
    private $found = false;

    /**
     * @var AttemptedGuess[]|ArrayCollection
     */
    private $attemptedGuesses;

    public function __construct(Code $secretCode)
    {
        $this->secret = $secretCode;
        $this->attemptedGuesses = new ArrayCollection();
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
        $result = (new GuessChecker($this, $guess))->result();

        $this->found = $this->secret->size() === $result->exact();
        $this->attempts++;

        $this->attemptedGuesses->add($result);
    }

    public function lastResult(): AttemptedGuess
    {
        return $this->attemptedGuesses->last();
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
    public function attemptedGuesses(): ArrayCollection
    {
        return $this->attemptedGuesses;
    }

    public function __toString()
    {
        return sprintf("id: %s, attempts: %s, found: %s", $this->id, $this->attempts, $this->found ? 'yes' : 'no');
    }
}
