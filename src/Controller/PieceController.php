<?php

namespace App\Controller;

use App\Entity\Piece;
use App\Entity\Arsenal;
use App\Entity\Member;
use App\Form\PieceType;
use App\Repository\PieceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


final class PieceController extends AbstractController
{


    #[Route('/home', name: 'app_home', methods: ['GET'])]
    public function home(PieceRepository $pieceRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($this->isGranted('ROLE_ADMIN')) {
            $pieces = $pieceRepository->findAll();
        } else {
            $member = $this->getUser();
            $pieces = $pieceRepository->findMemberPieces($member);
        }
        return $this->render('piece/home.html.twig', [
            'pieces' => $pieces,
        ]);
    }

    #[Route('/piece', name: 'app_piece_index', methods: ['GET'])]
    public function index(PieceRepository $pieceRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($this->isGranted('ROLE_ADMIN')) {
            $pieces = $pieceRepository->findAll();
        } else {
            $member = $this->getUser();
            $pieces = $pieceRepository->findMemberPieces($member);
        }
        return $this->render('piece/index.html.twig', [
            'pieces' => $pieces,
        ]);
    }


    #[Route('/piece/new/{id}', name: 'app_piece_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Arsenal $arsenal): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $hasAccess = $this->isGranted('ROLE_ADMIN') || ($this->getUser() == $arsenal->getMember());

        if (! $hasAccess) {
            throw $this->createAccessDeniedException("Piece creation not authorized for user");
        }
        $piece = new Piece();
        $piece->setArsenal($arsenal);
        $member = $arsenal->getMember(); // i use this to limit the Halls shown only to the said member

        $form = $this->createForm(PieceType::class, $piece, [
            'member' => $member, // Pass the member to the form
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($piece);
            $entityManager->flush();

            return $this->redirectToRoute(
                'app_arsenal_show',
                ['id' => $arsenal->getId()],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->render('piece/new.html.twig', [
            'piece' => $piece,
            'form' => $form,
        ]);
    }

    #[Route('/piece/{id}', name: 'app_piece_show', methods: ['GET'])]
    public function show(Piece $piece): Response
    {
        dump($piece->getImageFile());
        dump($piece->getImageName());
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $published = false;
        $halls = $piece->getHalls();
        foreach ($halls as $hall) {
            if ($hall->isPublished()) {
                $published = true;
                break;
            }
        };
        $hasAccess = $this->isGranted('ROLE_ADMIN') || $published || ($this->getUser() == $piece->getArsenal()->getMember());
        if (! $hasAccess) {
            throw $this->createAccessDeniedException("Owner of this piece has not made it public!");
        }
        return $this->render('piece/show.html.twig', [
            'piece' => $piece,
        ]);
    }

    #[Route('/piece/{id}/edit', name: 'app_piece_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Piece $piece, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $hasAccess = $this->isGranted('ROLE_ADMIN') || ($this->getUser() == $piece->getArsenal()->getMember());
        if (! $hasAccess) {
            throw $this->createAccessDeniedException("Cannot edit other members' pieces!");
        }
        $form = $this->createForm(PieceType::class, $piece);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_arsenal_show', ['id' => $piece->getArsenal()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('piece/edit.html.twig', [
            'piece' => $piece,
            'form' => $form,
        ]);
    }

    #[Route('/piece/{id}', name: 'app_piece_delete', methods: ['POST'])]
    public function delete(Request $request, Piece $piece, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $hasAccess = $this->isGranted('ROLE_ADMIN') || ($this->getUser() == $piece->getArsenal()->getMember());
        if (! $hasAccess) {
            throw $this->createAccessDeniedException("Cannot delete other members' pieces!");
        }
        if ($this->isCsrfTokenValid('delete' . $piece->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($piece);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_arsenal_show', ['id' => $piece->getArsenal()->getId()], Response::HTTP_SEE_OTHER);
    }
}
