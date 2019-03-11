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
        // pour afficher l'erreur d'authentifications s'il y en a
        $error =$authenticationUtils ->getLastAuthenticationError();
        //pour afficher l'erreur d'utilisateurs si quelqu'un rentre le mauvais user/password
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }
}