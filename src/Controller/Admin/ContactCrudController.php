<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contact::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Messages')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Message');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            DateField::new('createdAt')
                ->setLabel('Date de récepetion :'),
            TextField::new('nom')
                ->setLabel("Nom :"),
            TextField::new('prenom')
                ->setLabel('Prénom :'),
            TextField::new('mail')
                ->setLabel('Email :'),
            TextEditorField::new('contenu')
                ->setLabel('Contenu de la demande :'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_EDIT, Action::INDEX)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->disable(Action::NEW, Action::EDIT); 
    }
}
