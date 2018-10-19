<?php

namespace PcComponentes\Codebreaker;

class AttemptedGuess
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $exact;

    /**
     * @var int
     */
    private $partial;

    /**
     * @var Code
     */
    private $guess;

    /**
     * @var Codebreaker
     */
    private $codebreaker;

    public function __construct(Codebreaker $codebreaker, Code $guess, int $exact, int $partial)
    {
        $this->guess = $guess;
        $this->exact = $exact;
        $this->partial = $partial;
        $this->codebreaker = $codebreaker;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function guess(): Code
    {
        return $this->guess;
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
