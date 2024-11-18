<?php

namespace App\Controller;

use App\Entity\Member;

use App\Repository\MemberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;



#[Route('/member')]
class MemberController extends AbstractController
{
    #[Route('/', name: 'app_member_list')]
    public function index(MemberRepository $memberRepository): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('app_login');
        }
        $members = $memberRepository->findAll();

        return $this->render('member/index.html.twig', [
            'members' => $members,
        ]);
    }

    #[Route('/{id}', name: 'app_member_show', methods: ['GET'])]
    public function show(Member $member): Response
    {
        return $this->render('member/show.html.twig', [
            'member' => $member,
        ]);
    }

    #[Route('/redirect/member-redirect', name: 'app_member_redirect', methods: ['GET'])]
    public function memberRedirect(): Response
    {


        $user = $this->getUser();

        if (!$user instanceof Member) {
            throw $this->createAccessDeniedException('Access denied.');
        }

        return $this->redirectToRoute(
            'app_member_show',
            ['id' => $user->getId()],
            Response::HTTP_SEE_OTHER
        );
    }
}
