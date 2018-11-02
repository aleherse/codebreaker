<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class PlayerController extends AbstractController
{
    /**
     * @Route("/games", name="app_played_games")
     * @IsGranted("ROLE_USER")
     */
    public function playedGames(): Response
    {
        return $this->render('player/played_games.html.twig', []);
    }
}
