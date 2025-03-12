<?php

namespace App\Controller\Admin;

use App\Entity\Presentation;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PresentationCrudController extends AbstractCrudController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getEntityFqcn(): string
    {
        return Presentation::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier une présentation')
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des présentations')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Présentation');
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre')
                ->setRequired(false)
                ->setMaxLength(20)
                ->setHelp('Entre 1 et 20 caractères maximum')
                ->setLabel('Titre :'),
            TextEditorField::new('contenu')
                ->setRequired(false)
                ->setHelp('Entre 1 et 250 caractères maximum')
                ->setLabel('Contenu de votre présentation :'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $count = $this->entityManager->getRepository(Presentation::class)->count([]);

        if ($count >= 3) {
            $actions = $actions->disable(Action::NEW);
        }

        return $actions
            ->add(Crud::PAGE_EDIT, Action::INDEX)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_EDIT, Action::DETAIL); 
    }
}
