<?php

namespace App\Controller;

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
    public function start(Request $request): Response
    {
        return new Response('new game');
    }

    /**
     * @Route("/games", name="app_pending_games")
     */
    public function pending(Request $request): Response
    {
        return new Response('resume');
    }

    /**
     * @Route("/resume/{id}", name="app_resume_game")
     */
    public function resume(Request $request): Response
    {
        return new Response('resume_one');
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
