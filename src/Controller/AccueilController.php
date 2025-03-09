<?php

namespace App\Controller;

use App\Form\ContactFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccueilController extends AbstractController
{
    #[Route('/', name: 'portfolio_accueil')]
    public function index(Request $request, EntityManagerInterface $entityManager, ContactFormType $form): Response
    {        
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
            'form' => $form,
            'section' => ($form->isSubmitted()) ? 4 : 0, 
        ]);
    }
}
