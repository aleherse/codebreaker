<?php

namespace App\Entity;

use App\Codebreaker\Code;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class AttemptedGuess
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $exact;

    /**
     * @ORM\Column(type="integer")
     */
    private $partial;

    /**
     * @ORM\Column(type="codebreaker_code")
     */
    private $guess;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Codebreaker", inversedBy="id")
     */
    private $codebreaker;

    public function __construct(Codebreaker $codebreaker, Code $guess, int $exact, int $partial)
    {
        $this->guess = $guess;
        $this->exact = $exact;
        $this->partial = $partial;
        $this->codebreaker = $codebreaker;
    }

    public function id(): int
    {
        return $this->id;
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
