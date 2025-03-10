<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Entity\Parcours;
use App\Entity\Presentation;
use App\Entity\Projet;
use App\Entity\Skill;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        return $this->render('admin/my-dashboard.html.twig', [
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
        yield MenuItem::linkToCrud('Présentation', 'fas fa-list', Presentation::class);
        yield MenuItem::linkToCrud('Skills', 'fas fa-list', Skill::class);
        yield MenuItem::linkToCrud('Parcours', 'fas fa-list', Parcours::class);
        yield MenuItem::linkToCrud('Messages', 'fas fa-list', Contact::class);
        yield MenuItem::linkToCrud('Mes projets', 'fas fa-list', Projet::class);
    }
}
