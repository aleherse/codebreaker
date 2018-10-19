<?php

namespace PcComponentes\Codebreaker;

class CheckResult
{
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

    public function __construct(Code $guess, int $exact, int $partial)
    {
        $this->guess = $guess;
        $this->exact = $exact;
        $this->partial = $partial;
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
