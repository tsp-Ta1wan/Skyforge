<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PieceRepository;
use App\Entity\Piece;

class PieceController extends AbstractController
{
    #[Route('/piece', name: 'app_piece')]
    public function index(): Response
    {
        return $this->render('piece/index.html.twig', [
            'controller_name' => 'PieceController',
        ]);
    }
    
    #[Route('/piece/list', name: 'piece_list', methods: ['GET'])]
    public function listAction(PieceRepository $PieceRepository)
    {
        $htmlpage = '<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Pieces!!</title>
    </head>
    <body>
        <h1>Pieces list</h1>
        <p>All weapons of war should be here</p>
        <ul>';
        
        $tags = $PieceRepository->findAll();
        foreach($tags as $piece) {
            $htmlpage .= '<li><b>'. $piece->getId() .'. ' . $piece->getName(). ': </b>' . $piece->getDescription()  .'</li>';
        }
        $htmlpage .= '</ul>';
        
        $htmlpage .= '</body></html>';
        
        return new Response(
            $htmlpage,
            Response::HTTP_OK,
            array('content-type' => 'text/html')
            );
    }   
    
    #[Route('/piece/{id}', name: 'piece_show', requirements: ['id' => '\d+'])]
    public function show(Piece $piece): Response
    {
        return $this->render('piece/show.html.twig',
            [ 'piece' => $piece ]
            );
    }
    
    
}

