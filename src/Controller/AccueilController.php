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
            $recaptchaResponse = $request->request->get('g-recaptcha-response');

            if ($recaptchaResponse) {
                $contact = $form->getData();
                $entityManager->persist($contact);
                $entityManager->flush(); 

                $this->addFlash('success', 'Message envoyé !'); 
                
                return $this->redirectToRoute('portfolio_accueil', [
                    'presentation' => $presentation,
                    'projet' => $projet,
                    'parcours' => $parcours,
                    'skill' => $skill,
                    'form' => $form,
                    'section' => 4,
                ]);
            } else {
                $this->addFlash('error', 'Vous êtes un robot !'); 
            }            
        } 
        
        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('error', 'Erreur dans le formulaire !');            
        }  

        return $this->render('accueil/index.html.twig', [
            'presentation' => $presentation,
            'projet' => $projet,
            'parcours' => $parcours,
            'skill' => $skill,
            'form' => $form,
            'section' => ($form->isSubmitted()) ? 4 : 0, 
        ]);
    }
}
