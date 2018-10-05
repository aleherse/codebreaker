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

    public function __construct(int $exact, int $partial)
    {
        $this->exact = $exact;
        $this->partial = $partial;
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
