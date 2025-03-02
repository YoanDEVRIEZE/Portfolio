<?php

namespace App\Controller;

use App\Repository\PresentationRepository;
use App\Repository\ProjetRepository;
use App\Repository\SkillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccueilController extends AbstractController
{
    #[Route('/', name: 'portfolio_accueil')]
    public function index(PresentationRepository $presentation, ProjetRepository $projet, SkillRepository $skill): Response
    {
        $presentation = $presentation->findAll();
        $projet = $projet->findAll();
        $skill = $skill->findAll();

        return $this->render('accueil/index.html.twig', [
            'presentation' => $presentation,
            'projet' => $projet,
            'skill' => $skill,
        ]);
    }
}
