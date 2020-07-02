<?php

namespace App\Http\Controller\Web\Auth;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class AuthController extends AbstractController
{
    /**
     * @Route("/auth/login", name="auth.login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('music/auth/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/auth/logout", name="auth.logout", methods={"POST"})
     * @return Response
     * @throws Exception
     */
    public function logout(): Response
    {
        throw new Exception('Dont forget to activate logout in security.yaml');
    }
}
