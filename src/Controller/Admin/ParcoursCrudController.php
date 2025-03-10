<?php

namespace App\Controller\Admin;

use App\Entity\Parcours;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ParcoursCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Parcours::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter un parcours')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier un parcours')
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des parcours');
    }

    public function configureFields(string $pageName): iterable
    {
        $isCreatePage = $pageName === 'new';

        return [
            TextField::new('nom')
                ->setRequired(true)
                ->setMaxLength(100)
                ->setHelp('Entre 1 et 100 caractères maximum')
                ->setLabel('Nom de l\'entreprise:'),
            TextField::new('poste')
                ->setRequired(true)
                ->setMaxLength(50)
                ->setHelp('Entre 1 et 50 caractères maximum')
                ->setLabel('Poste occupé :'),
            TextField::new('statut')
                ->setRequired(true)
                ->setMaxLength(100)
                ->setHelp('Sélectionnez un statut pour cette mission')
                ->setLabel('Statut :'),
            ImageField::new('photo_couverture')
                ->setLabel('Photo de couverture :')
                ->setBasePath('styles/img/icones_entreprises/')
                ->setUploadDir('assets/styles/img/icones_entreprises/')
                ->setUploadedFileNamePattern('[randomhash].webp')
                ->setHelp('Image au format .webp')
                ->setRequired($isCreatePage)
                ->setFormTypeOptions([
                    'attr' => ['accept' => 'image/webp']
                ]),
            ImageField::new('photo')
                ->setLabel('Photo parcours :')
                ->setBasePath('styles/img/projets/')
                ->setUploadDir('assets/styles/img/projets/')
                ->setUploadedFileNamePattern('[randomhash].webp')
                ->setHelp('Image au format .webp')
                ->setRequired($isCreatePage)
                ->setFormTypeOptions([
                    'attr' => ['accept' => 'image/webp']
                ]),
                DateField::new('date_debut')
                ->setRequired(true)
                ->setLabel('Date de début :')
                ->setHelp('Format : JJ/MM/AAAA'),
            DateField::new('date_fin')
                ->setRequired(false)
                ->setLabel('Date de fin :')
                ->setHelp('Format : JJ/MM/AAAA'),
            TextEditorField::new('contenu')
                ->setRequired(true)
                ->setLabel('Contenu du parcours :')
                ->setHelp('Entre 1 et 1024 caractères maximum, au format HTML')            
        ];
    }
}
