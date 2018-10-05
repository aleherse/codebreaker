<?php

namespace PcComponentes\Codebreaker;

class SecretCode
{
    /**
     * @var int
     */
    private $numbers;

    public static function random(): self
    {
        return new self([
            random_int(1, 6),
            random_int(1, 6),
            random_int(1, 6),
            random_int(1, 6)
        ]);
    }

    public function __construct(array $numbers)
    {
        $this->numbers = $numbers;
    }

    public function in(int $position): int
    {
        return $this->numbers[$position];
    }

    public function __toString(): string
    {
        return implode($this->numbers);
    }
}
