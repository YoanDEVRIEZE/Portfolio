<?php

namespace App\Controller\Admin;

use App\Entity\Presentation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PresentationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Presentation::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier une présentation')
            ->setPageTitle(Crud::PAGE_INDEX, 'Vos 3 présentations');
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
        return $actions
            ->disable(Action::NEW, Action::DELETE); 
    }
}
