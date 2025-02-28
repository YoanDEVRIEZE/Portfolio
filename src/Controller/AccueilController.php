<?php

namespace App\Controller;

use App\Repository\PresentationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccueilController extends AbstractController
{
    #[Route('/', name: 'portfolio_accueil')]
    public function index(PresentationRepository $presentation): Response
    {
        $presentation = $presentation->findAll();

        return $this->render('accueil/index.html.twig', [
            'presentation' => $presentation,
        ]);
    }
}
