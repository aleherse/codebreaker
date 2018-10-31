<?php

namespace App\Codebreaker;

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
        int $average = null,
        int $minimum = null,
        int $win = null,
        int $lost = null,
        int $played = null,
        int $notFinished = null,
        int $total = null
    ) {
        $this->average = $average ?? 0;
        $this->minimum = $minimum ?? 0;
        $this->win = $win ?? 0;
        $this->lost = $lost ?? 0;
        $this->played = $played ?? 0;
        $this->notFinished = $notFinished ?? 0;
        $this->total = $total ?? 0;
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
