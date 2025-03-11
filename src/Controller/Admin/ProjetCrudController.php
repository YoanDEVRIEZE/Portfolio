<?php

namespace App\Controller\Admin;

use App\Entity\Projet;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProjetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Projet::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter un projet')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier un projet')
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des projets')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Projet');
    }

    public function configureFields(string $pageName): iterable
    {
        $isCreatePage = $pageName === 'new';

        return [
            TextField::new('titre')
                ->setRequired(true)
                ->setMaxLength(50)
                ->setHelp('Entre 1 et 50 caractères maximum')
                ->setLabel('Titre :'),
            TextField::new('description')
                ->setRequired(true)
                ->setMaxLength(100)
                ->setHelp('Entre 1 et 100 caractères maximum')
                ->setLabel('Description :'),
            AssociationField::new('skill')
                ->setRequired(true)
                ->setHelp('Sélectionnez les langages de programmation associés au projet')
                ->setLabel('Langages :')                
                ->setFormTypeOptions([
                    'by_reference' => false,
                    'multiple' => true,
                    'choice_label' => 'titre'
                ]),
            ImageField::new('photo_couverture')
                ->setLabel('Photo de couverture :')
                ->setHelp('Image au format .webp')
                ->setBasePath('styles/img/icones_projets/')
                ->setUploadDir('assets/styles/img/icones_projets/')
                ->setUploadedFileNamePattern('[randomhash].webp')
                ->setRequired($isCreatePage)
                ->setFormTypeOptions([
                    'attr' => ['accept' => 'image/webp']
                ]),
            ImageField::new('photo')
                ->setLabel('Photo du projet :')
                ->setHelp('Image au format .webp')
                ->setBasePath('styles/img/projets/')
                ->setUploadDir('assets/styles/img/projets/')
                ->setUploadedFileNamePattern('[randomhash].webp')
                ->setRequired($isCreatePage)
                ->setFormTypeOptions([
                    'attr' => ['accept' => 'image/webp']
                ]),
            TextField::new('lien')
                ->setRequired(false)
                ->setLabel('Lien :')
                ->setHelp('Lien vers le site web du projet'),
            TextEditorField::new('contenu')
                ->setRequired(true)
                ->setLabel('Contenu du projet :')
                ->setHelp('Entre 1 et 1024 caractères maximum, au format HTML'),
            TextField::new('alt')
                ->setLabel('Alt de l\'image :')
                ->setMaxLength(100)
                ->setHelp('Entre 1 et 100 caractères maximum')
                ->setRequired(true)            
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_EDIT, Action::INDEX)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_EDIT, Action::DETAIL);             
    }
}
