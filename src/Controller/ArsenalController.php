<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
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
        $htmlpage = '<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Arsenals!!</title>
    </head>
    <body>
        <h1>tags list</h1>
        <p>Arsenals should show up here:</p>
        <ul>';
        
        $tags = $ArsRepository->findAll();
        foreach($tags as $ars) {
            $htmlpage .= '<li>'. $ars->getDescription() .'</li>';
        }
        $htmlpage .= '</ul>';
        
        $htmlpage .= '</body></html>';
        
        return new Response(
            $htmlpage,
            Response::HTTP_OK,
            array('content-type' => 'text/html')
            );
    }
}
