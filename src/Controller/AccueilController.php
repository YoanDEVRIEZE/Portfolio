<?php

namespace App\Controller;

use App\Form\ContactFormType;
use App\Repository\ParcoursRepository;
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
    public function index(Request $request, EntityManagerInterface $entityManager, PresentationRepository $presentation, ProjetRepository $projet, ParcoursRepository $parcours, SkillRepository $skill, ContactFormType $form): Response
    {
        $presentation = $presentation->findAll();
        $projet = $projet->findAll();
        $parcours = $parcours->findBy([],['id' => 'DESC'], 3);
        $skill = $skill->findAll();

        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $entityManager->persist($contact);
            $entityManager->flush(); 
            
            $this->addFlash('success', 'Votre message a bien ete envoye !');            
        } 
        
        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('error', 'Votre message contient des erreurs');            
        }  

        if ($form->isSubmitted()) {
            return $this->render('accueil/index.html.twig', [
                'presentation' => $presentation,
                'projet' => $projet,
                'parcours' => $parcours,
                'skill' => $skill,
                'form' => $form->createView(),
                'section' => 4, 
            ]);
        }

        return $this->render('accueil/index.html.twig', [
            'presentation' => $presentation,
            'projet' => $projet,
            'parcours' => $parcours,
            'skill' => $skill,
            'form' => $form,
            'section' => 0, 
        ]);
    }
}
