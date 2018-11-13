<?php

namespace App\Codebreaker;

use App\Entity\Codebreaker;
use App\Entity\Player;
use App\Repository\CodebreakerRepository;

class GameService
{
    /**
     * @var CodebreakerRepository
     */
    protected $codebreakers;

    public function __construct(CodebreakerRepository $codebreakers)
    {
        $this->codebreakers = $codebreakers;
    }

    /**
     * @param Player $player
     *
     * @return Codebreaker[]
     */
    public function pendingGames(Player $player): array
    {
        return $this->codebreakers->pendingGames($player);
    }

    public function new(Player $player = null): Codebreaker
    {
        return $this->codebreakers->new($player);
    }

    public function find(Player $player, int $id): ?Codebreaker
    {
        return $this->codebreakers->findOneBy(['id' => $id, 'player' => $player]);
    }

    public function showStats(View $view)
    {
        $stats = $this->codebreakers->stats();

        $view->showStats($stats);
    }

    public function finishedGames(Player $player, int $page = 1)
    {
        return $this->codebreakers->finishedGames($player, $page);
    }

    public function playGameAttempt(Codebreaker $codebreaker, string $numbers): Codebreaker
    {
        $codebreaker->check(Code::fromGuess($numbers));

        $this->codebreakers->save($codebreaker);

        return $codebreaker;
    }
}
