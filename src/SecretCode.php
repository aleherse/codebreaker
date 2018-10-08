<?php

namespace PcComponentes\Codebreaker;

class SecretCode
{
    private const CODE_SIZE = 4;

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

    public function size(): int
    {
        return self::CODE_SIZE;
    }

    public function numbers(): array
    {
        return $this->numbers;
    }

    public function __toString(): string
    {
        return implode($this->numbers);
    }
}
