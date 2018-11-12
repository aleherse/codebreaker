<?php

namespace App\Codebreaker;

use App\Entity\Codebreaker;
use App\Entity\Player;
use App\Repository\CodebreakerRepository;
use App\Security\Authentication;

class Games
{
    /**
     * @var CodebreakerRepository
     */
    protected $codebreakers;

    /**
     * @var Authentication
     */
    protected $auth;

    public function __construct(CodebreakerRepository $codebreakers, Authentication $auth)
    {
        $this->codebreakers = $codebreakers;
        $this->auth = $auth;
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

    public function new(Player $player): Codebreaker
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

    public function playedGames(View $view)
    {
        if (null === $player = $this->auth->currentPlayer()) {
            $view->anonymousForbidden();
            return;
        }

        // @TODO: Add pagination
        $games = $this->codebreakers->finishedGames($player, 1);

        $view->showPlayedGames($games);
    }

    public function playGameAttempt(Codebreaker $codebreaker, string $numbers): Codebreaker
    {
        $codebreaker->check(Code::fromGuess($numbers));

        $this->codebreakers->save($codebreaker);

        return $codebreaker;
    }
}
