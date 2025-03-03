<?php

namespace App\Controller;

use App\Form\ContactFormType;
use App\Repository\PresentationRepository;
use App\Repository\ProjetRepository;
use App\Repository\SkillRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccueilController extends AbstractController
{
    #[Route('/', name: 'portfolio_accueil')]
    public function index(Request $request, EntityManagerInterface $entityManager, PresentationRepository $presentation, ProjetRepository $projet, SkillRepository $skill, ContactFormType $form): Response
    {
        $presentation = $presentation->findAll();
        $projet = $projet->findAll();
        $skill = $skill->findAll();

        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $entityManager->persist($contact);
            $entityManager->flush(); 
            
            $this->addFlash('success', 'Votre message a bien ete envoye !');

            return $this->render('accueil/index.html.twig', [
                'presentation' => $presentation,
                'projet' => $projet,
                'skill' => $skill,
                'form' => $form->createView(),
                'section' => 4, 
            ]);
        } 
        
        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('error', 'Votre message contient des erreurs');

            return $this->render('accueil/index.html.twig', [
                'presentation' => $presentation,
                'projet' => $projet,
                'skill' => $skill,
                'form' => $form->createView(),
                'section' => 4, 
            ]);
        }  

        return $this->render('accueil/index.html.twig', [
            'presentation' => $presentation,
            'projet' => $projet,
            'skill' => $skill,
            'form' => $form,
        ]);
    }
}
