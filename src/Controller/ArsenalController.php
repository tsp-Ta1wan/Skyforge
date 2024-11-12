<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;

use App\Entity\Arsenal;
use App\Repository\ArsenalRepository;

class ArsenalController extends AbstractController
{
    #[Route('/arsenal', name: 'app_arsenal')]
    public function index(): Response
    {
        return $this->render('arsenal/index.html.twig', [
            'controller_name' => 'ArsenalController',
        ]);
    }

    #[Route('/arsenal/list', name: 'arsenal_list', methods: ['GET'])]
    public function listAction(ArsenalRepository $ArsRepository)
    {
        $arsenals = $ArsRepository->findAll();

        return $this->render('arsenal/list.html.twig', [
            'arsenals' => $arsenals,
        ]);
    }

    /**
     * Show an Arsenal
     *
     * @param Integer $id (note that the id must be an integer)
     */
    #[Route('/arsenal/{id}', name: 'arsenal_show', requirements: ['id' => '\d+'])]
    public function show(Arsenal $arsenal): Response
    {
        $hasAccess = $this->isGranted('ROLE_ADMIN') ||
            ($this->getUser() == $arsenal->getMember());
        /** 
        
            if (! $hasAccess) {
            return $this->redirectToRoute(
                'app_member_show',
                ['id' => $this->getUser()->getId()],
                Response::HTTP_SEE_OTHER
            );
        }
         */
        if (! $hasAccess) {
            throw $this->createAccessDeniedException("You cannot access another member's arsenal!");
        }


        return $this->render(
            'arsenal/show.html.twig',
            ['arsenal' => $arsenal]
        );
    }
}
