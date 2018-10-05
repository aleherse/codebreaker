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
     * @var int
     */
    private $size;

    public function __construct(int $exact, int $partial, int $size)
    {
        $this->exact = $exact;
        $this->partial = $partial;
        $this->size = $size;
    }

    public function exact(): int
    {
        return $this->exact;
    }

    public function partial(): int
    {
        return $this->partial;
    }

    public function hasBeenFound(): bool
    {
        return $this->size === $this->exact;
    }
}
