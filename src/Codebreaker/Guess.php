<?php

namespace PcComponentes\Codebreaker;

class Guess
{
    /**
     * @var int[]
     */
    private $numbers;

    public function __construct(string $guess)
    {
        $numbers = str_split($guess, 1);
        if (4 !== count($numbers)) {
            throw new \InvalidArgumentException();
        }

        $this->numbers = [];
        foreach ($numbers as $value) {
            if (!is_numeric($value) || $value < 1 || $value > 6) {
                throw new \InvalidArgumentException();
            }

            $this->numbers[] = (int) $value;
        }
    }

    public function in(int $position): int
    {
        return $this->numbers[$position];
    }

    /**
     * @return int[]
     */
    public function numbers(): array
    {
        return $this->numbers;
    }

    public function __toString()
    {
        return implode($this->numbers);
    }
}
