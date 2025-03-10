<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Entity\Parcours;
use App\Entity\Presentation;
use App\Entity\Projet;
use App\Entity\Skill;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function index(): Response
    {
        $nbMessage = $this->entityManager->getRepository(Contact::class)->count([]);
        $nbProjet = $this->entityManager->getRepository(Projet::class)->count([]);
        $nbParcours = $this->entityManager->getRepository(Parcours::class)->count([]);
        $nbSkill = $this->entityManager->getRepository(Skill::class)->count([]);

        return $this->render('admin/my-dashboard.html.twig', [
            'nbMessage' => $nbMessage,
            'nbProjet' => $nbProjet,
            'nbParcours' => $nbParcours,
            'nbSkill' => $nbSkill
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Portfolio Yoan DE VRIEZE Développeur PHP Symfony/Laravel')
            ->setFaviconPath('styles/img/profil/profil.webp')
            ->renderContentMaximized()
            ->setDefaultColorScheme('dark')
            ->setLocales(['fr', 'fr']);
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Présentation', 'fas fa-user', Presentation::class);
        yield MenuItem::linkToCrud('Mes projets', 'fas fa-briefcase', Projet::class);
        yield MenuItem::linkToCrud('Parcours', 'fas fa-graduation-cap', Parcours::class);
        yield MenuItem::linkToCrud('Skills', 'fas fa-lightbulb', Skill::class);
        yield MenuItem::linkToCrud('Messages', 'fas fa-envelope', Contact::class);
    }
}
