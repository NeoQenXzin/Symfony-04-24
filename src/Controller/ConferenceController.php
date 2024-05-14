<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ConferenceController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    // public function index(): Response
    public function index(Request $request): Response
    {
        // return $this->render('conference/index.html.twig', [
        //     'controller_name' => 'ConferenceController',
        // ]);
dump($request);
        return new Response(<<<EOF
                        <html>
                            <body><img src="/images/under-construction.gif" /></body>
                        </html>
                    EOF);
    }
}
