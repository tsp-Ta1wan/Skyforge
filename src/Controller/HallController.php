<?php

namespace App\Controller;

use App\Entity\Hall;
use App\Entity\Piece;
use App\Form\HallType;
use App\Repository\HallRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

#[Route('/hall')]
final class HallController extends AbstractController
{
    #[Route(name: 'app_hall_index', methods: ['GET'])]
    public function index(HallRepository $hallRepository): Response
    {
        return $this->render('hall/index.html.twig', [
            'halls' => $hallRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_hall_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $hall = new Hall();
        $form = $this->createForm(HallType::class, $hall);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($hall);
            $entityManager->flush();

            return $this->redirectToRoute('app_hall_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hall/new.html.twig', [
            'hall' => $hall,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hall_show', methods: ['GET'])]
    public function show(Hall $hall): Response
    {
        return $this->render('hall/show.html.twig', [
            'hall' => $hall,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_hall_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Hall $hall, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HallType::class, $hall);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_hall_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hall/edit.html.twig', [
            'hall' => $hall,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hall_delete', methods: ['POST'])]
    public function delete(Request $request, Hall $hall, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hall->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($hall);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_hall_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{hall_id}/piece/{piece_id}',methods: ['GET'],name: 'app_hall_piece_show')]
   public function pieceShow(
       #[MapEntity(id: 'hall_id')]
       Hall $hall,
       #[MapEntity(id: 'piece_id')]
       Piece $piece
   ): Response
   {
    if(! $hall->getPieces()->contains($piece)) {
                throw $this->createNotFoundException("Couldn't find such a piece in this hall!");
        }

        if(! $hall->isPublished()) {
            throw $this->createAccessDeniedException("Thou shall not access this fine piece!");
        }

       return $this->render('hall/pieceshow.html.twig', [
           'piece' => $piece,
           'hall' => $hall
       ]);
   }
}
