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

    public function times()
    {
        $times = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0];
        for ($i = 0; $i < $this->size(); $i++) {
            $times[$this->numbers[$i]]++;
        }

        return $times;
    }

    public function __toString(): string
    {
        return implode($this->numbers);
    }
}
