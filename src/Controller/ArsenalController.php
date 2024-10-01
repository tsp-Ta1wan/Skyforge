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
        $htmlpage = '
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Arsenals List</title>
            <!-- Bootstrap CSS -->
            <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>
            <div class="container my-5">
                <h1 class="display-4 text-center mb-4">Arsenals List</h1>
                <p class="lead text-center">Browse through the list of arsenals below:</p>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <ul class="list-group">';
        
        $arsenals = $ArsRepository->findAll();
        if (count($arsenals) > 0) {
            foreach ($arsenals as $arsenal) {
                
                $url = $this->generateUrl(
                    'arsenal_show',
                    ['id' => $arsenal->getId()]);
                
                
                // <li><a href="/[inventaire]/42">un [inventaire] (42)</a></li>
                $htmlpage .= '<a href="'. $url .'">' . '<li class="list-group-item">' . '<b>' . $arsenal->getId() . ' </b>';
                $htmlpage .= $arsenal->getDescription() .'</li></a>';
            }
        } else {
            $htmlpage .= '<li class="list-group-item text-muted">No arsenals available</li>';
        }
        
        $htmlpage .= '
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Bootstrap JS and dependencies -->
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </body>
    </html>
    ';
        
        return new Response(
            $htmlpage,
            Response::HTTP_OK,
            ['content-type' => 'text/html']
            );
    }
    
    /**
     * Show an Arsenal
     *
     * @param Integer $id (note that the id must be an integer)
     */
    #[Route('/arsenal/{id}', name: 'arsenal_show', requirements: ['id' => '\d+'])]
    public function show(Arsenal $arsenal): Response
    {
        return $this->render('arsenal/show.html.twig',
            [ 'arsenal' => $arsenal ]
            );
    }
    
    
}
