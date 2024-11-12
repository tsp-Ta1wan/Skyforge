<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


use App\Entity\Member;
use App\Repository\MemberRepository;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    #[Route('/login-redirect', name: 'app_login_redirect', methods: ['GET', 'POST'])]
    public function loginRedirect(): Response
    {
        // Fetch the currently logged-in user
        $user = $this->getUser();

        // Ensure the user is a Member entity
        if (!$user instanceof Member) {
            throw $this->createAccessDeniedException('Access denied.');
        }


        return $this->redirectToRoute(
            'app_member_show',
            ['id' => $user->getId()],
            Response::HTTP_SEE_OTHER
        );
    }

    #[Route('/logout', name: 'app_logout', methods: ['GET', 'POST'])]
    public function logout()
    {

        dump("logout");
        // throw new \Exception('Don\'t forget to activate logout in security.yaml');
        return new Response();
    }
}
