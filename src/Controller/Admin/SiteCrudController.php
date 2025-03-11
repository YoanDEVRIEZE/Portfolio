<?php

namespace App\Controller\Admin;

use App\Entity\Site;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SiteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Site::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier les paramètres du site')
            ->setPageTitle(Crud::PAGE_INDEX, 'Paramètres du site')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Détails des paramètres du site');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title')
                ->setRequired(false)
                ->setMaxLength(100)
                ->setHelp('Entre 1 et 100 caractères maximum')
                ->setLabel('Titre :'),
            TextField::new('description')
                ->setRequired(false)
                ->setMaxLength(250)
                ->setHelp('Entre 1 et 250 caractères maximum')
                ->setLabel('Description :'),
            ArrayField::new('keywords')
                ->setLabel('Mots-clés :')
                ->setFormTypeOptions([
                    'attr' => ['class' => 'keywords-field'], 
                    'help' => 'Entrez des mots-clés séparés par des virgules.',
                ])
                ->setHelp('Entrez des mots-clés, ceux-ci seront sauvegardés sous forme de JSON.'),
            TextField::new('reseaudescription')
                ->setRequired(false)
                ->setMaxLength(250)
                ->setHelp('Entre 1 et 250 caractères maximum')
                ->setLabel('Description pour les réseaux :'),
            TextField::new('url')
                ->setRequired(false)
                ->setMaxLength(250)
                ->setHelp('Entre 1 et 250 caractères maximum')
                ->setLabel('URL de votre site :'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_EDIT, Action::INDEX)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_EDIT, Action::DETAIL)
            ->disable(Action::NEW, Action::DELETE);
    }
}
