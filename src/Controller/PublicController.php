<?php

namespace App\Controller;

use App\Codebreaker\GameService;
use App\Entity\Player;
use App\Form\PlayerType;
use App\Repository\PlayerRepository;
use App\Security\WebPlayerAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class PublicController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function index(GameService $games): Response
    {
        return $this->render('public/homepage.html.twig', [
            'stats' => $games->stats()
        ]);
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('public/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): Response
    {
        return new Response('');
    }

    /**
     * @Route("/register", name="app_register")
     */

    public function register(
        Request $request,
        PlayerRepository $players,
        WebPlayerAuthenticator $authenticator,
        GuardAuthenticatorHandler $guardHandler
    ): Response {
        $form = $this->createForm(PlayerType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Player $player */
            $player = $form->getData();

            $players->save($player);

            return $guardHandler->authenticateUserAndHandleSuccess(
                $player,
                $request,
                $authenticator,
                'main'
            );
        }

        return $this->render('public/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
