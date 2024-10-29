<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    #[Route('/login_check', name: 'login_check')]
    public function loginCheck(): void
    {
        // Cette route est gérée automatiquement par le firewall dans security.yaml
        throw new \LogicException('This method should not be reached directly.');
    }

    #[Route('/logout', name: 'logout')]
    public function logout(): void
    {
        // Cette route est également gérée automatiquement par le firewall
        throw new \LogicException('This method should not be reached directly.');
    }
}
