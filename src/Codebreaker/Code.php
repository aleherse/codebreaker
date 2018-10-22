<?php

namespace PcComponentes\Codebreaker;

class Code
{
    private const CODE_SIZE = 4;
    private const MIN_VALUE = 1;
    private const MAX_VALUE = 6;

    /**
     * @var int
     */
    private $numbers;

    public static function fromGuess(string $guess)
    {
        $values = str_split($guess, 1);
        if (self::CODE_SIZE !== count($values)) {
            throw new \InvalidArgumentException();
        }

        $numbers = [];
        foreach ($values as $value) {
            if (!is_numeric($value) || $value < self::MIN_VALUE || $value > self::MAX_VALUE) {
                throw new \InvalidArgumentException();
            }

            $numbers[] = (int) $value;
        }

        return new self($numbers);
    }

    public static function random(): self
    {
        return new self([
            random_int(self::MIN_VALUE, self::MAX_VALUE),
            random_int(self::MIN_VALUE, self::MAX_VALUE),
            random_int(self::MIN_VALUE, self::MAX_VALUE),
            random_int(self::MIN_VALUE, self::MAX_VALUE),
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
