<?php

namespace PcComponentes\Codebreaker;

class GameStats
{
    /**
     * @var int
     */
    private $average;

    /**
     * @var int
     */
    private $minimum;

    /**
     * @var int
     */
    private $win;

    /**
     * @var int
     */
    private $lost;

    /**
     * @var int
     */
    private $played;

    /**
     * @var int
     */
    private $notFinished;

    /**
     * @var int
     */
    private $total;

    public function __construct(
        int $average,
        int $minimum,
        int $win,
        int $lost,
        int $played,
        int $notFinished,
        int $total
    ) {
        $this->average = $average;
        $this->minimum = $minimum;
        $this->win = $win;
        $this->lost = $lost;
        $this->played = $played;
        $this->notFinished = $notFinished;
        $this->total = $total;
    }

    public function average(): int
    {
        return $this->average;
    }

    public function minimum(): int
    {
        return $this->minimum;
    }

    public function win(): int
    {
        return $this->win;
    }

    public function lost(): int
    {
        return $this->lost;
    }

    public function played(): int
    {
        return $this->played;
    }

    public function notFinished(): int
    {
        return $this->notFinished;
    }

    public function total(): int
    {
        return $this->total;
    }
}
