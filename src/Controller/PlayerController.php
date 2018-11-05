<?php

namespace App\Controller;

use App\Repository\CodebreakerRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlayerController extends AbstractController
{
    /**
     * @Route("/games", name="app_played_games")
     * @IsGranted("ROLE_USER")
     */
    public function playedGames(CodebreakerRepository $codebreakers, Request $request): Response
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
