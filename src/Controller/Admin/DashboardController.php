<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Entity\Parcours;
use App\Entity\Presentation;
use App\Entity\Projet;
use App\Entity\Site;
use App\Entity\Skill;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/Admin/Dashboard', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    private EntityManagerInterface $entityManager;
    private $nbMessage;
    private $favicon;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->nbMessage = $this->entityManager->getRepository(Contact::class)->count([]);
        $this->favicon = $this->entityManager->getRepository(User::class)->find(1);
    }
    
    public function index(): Response
    {        
        $nbProjet = $this->entityManager->getRepository(Projet::class)->count([]);
        $nbParcours = $this->entityManager->getRepository(Parcours::class)->count([]);
        $nbSkill = $this->entityManager->getRepository(Skill::class)->count([]);

        return $this->render('admin/my-dashboard.html.twig', [
            'nbMessage' => $this->nbMessage,
            'nbProjet' => $nbProjet,
            'nbParcours' => $nbParcours,
            'nbSkill' => $nbSkill
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Portfolio Yoan DE VRIEZE Développeur PHP Symfony/Laravel')
            ->setFaviconPath('styles/img/profil/'.$this->favicon->getPhoto())
            ->renderContentMaximized()
            ->setDefaultColorScheme('dark')
            ->setLocales(['fr', 'fr']);
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Présentation', 'fas fa-list', Presentation::class);
        yield MenuItem::linkToCrud('Mes projets', 'fas fa-briefcase', Projet::class);
        yield MenuItem::linkToCrud('Parcours', 'fas fa-graduation-cap', Parcours::class);
        yield MenuItem::linkToCrud('Skills', 'fas fa-lightbulb', Skill::class);
        yield MenuItem::linkToCrud('Messages <span style="color: red;">('. $this->nbMessage .')</span>', 'fas fa-envelope', Contact::class);
        yield MenuItem::linkToCrud('Utilisateur', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Paramètres du site', 'fas fa-globe', Site::class);
        yield MenuItem::linkToRoute('Voir le site', 'fas fa-file-alt', 'portfolio_accueil');
        yield MenuItem::linkToLogout('Deconnexion', 'fas fa-sign-out-alt');
    }
}
