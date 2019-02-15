<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class  SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    // pour obtenir les erreurs d'authentification on injecte une class AuthenticationUtils qui nous permets l'accées a differents chose et nous permet de s'authentifier
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error =$authenticationUtils ->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }
}