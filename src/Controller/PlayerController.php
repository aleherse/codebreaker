<?php

namespace App\Controller;

use App\Codebreaker\Games;
use App\Repository\CodebreakerRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 */
class PlayerController extends AbstractController
{
    /**
     * @Route("/new", name="app_new_game")
     */
    public function start(Games $games): Response
    {
        $game = $games->new($this->getUser());

        return $this->redirectToRoute('app_resume_game', ['id' => $game->id()]);
    }

    /**
     * @Route("/games", name="app_pending_games")
     */
    public function pending(Games $games): Response
    {
        $games = $games->pendingGames($this->getUser());

        return $this->render('player/pending_games.html.twig', [
            'games' => $games
        ]);
    }

    /**
     * @Route("/resume/{id}", name="app_resume_game")
     */
    public function resume(Request $request, Games $games, int $id): Response
    {
        $player = $this->getUser();
        $game = $games->pending($player, $id);
        if (null === $game || !$game->isPlayer($player)) {
            return $this->redirectToRoute('app_pending_games');
        }

        return $this->render('player/resume_game.html.twig', [
            'game' => $game
        ]);
    }

    /**
     * @Route("/played", name="app_played_games")
     */
    public function played(CodebreakerRepository $codebreakers, Request $request): Response
    {
        $games = $codebreakers->finishedGames(
            $this->getUser(),
            $request->query->getInt('page', 1)
        );

        return $this->render('player/played_games.html.twig', [
            'games' => $games
        ]);
    }
}
