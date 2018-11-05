<?php

namespace App\Entity;

use App\Codebreaker\Code;
use App\Codebreaker\GuessChecker;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CodebreakerRepository")
 */
class Codebreaker
{
    const TRIES = 10;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Code
     * @ORM\Column(type="codebreaker_code")
     */
    private $secret;

    /**
     * @ORM\Column(type="integer")
     */
    private $attempts = 0;

    /**
     * @ORM\Column(type="boolean")
     */
    private $found = false;

    /**
     * @var AttemptedGuess[]|Collection
     * @ORM\OneToMany(targetEntity="App\Entity\AttemptedGuess", mappedBy="codebreaker", cascade={"persist", "merge"})
     */
    private $attemptedGuesses;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Player")
     * @ORM\JoinColumn(nullable=false)
     */
    private $player;

    public function __construct(Code $secretCode, Player $player = null)
    {
        $this->secret = $secretCode;
        $this->player = $player;
        $this->attemptedGuesses = new ArrayCollection();
    }

    public function id(): int
    {
        return $this->id;
    }

    public function secretCode(): Code
    {
        return $this->secret;
    }

    public function check(Code $guess): void
    {
        $result = (new GuessChecker($this, $guess))->result();

        $this->found = $this->secret->size() === $result->exact();
        $this->attempts++;

        $this->attemptedGuesses->add($result);
    }

    public function lastResult(): AttemptedGuess
    {
        return $this->attemptedGuesses->last();
    }

    public function attempts(): int
    {
        return $this->attempts;
    }

    public function hasMoreAttempts(): bool
    {
        return $this->attempts < self::TRIES;
    }

    public function hasBeenFound(): bool
    {
        return $this->found;
    }

    public function canPlay(): bool
    {
        return !$this->hasBeenFound() && $this->hasMoreAttempts();
    }

    /**
     * @return AttemptedGuess[]|Collection
     */
    public function attemptedGuesses(): Collection
    {
        return $this->attemptedGuesses;
    }

    public function __toString()
    {
        return sprintf("id: %s, attempts: %s, found: %s", $this->id, $this->attempts, $this->found ? 'yes' : 'no');
    }

    public function player(): ?Player
    {
        return $this->player;
    }
}
