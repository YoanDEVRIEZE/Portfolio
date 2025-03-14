<?php

namespace App\Controller\Admin;

use App\Entity\Parcours;
use App\Enum\StatutEnum;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
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
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des parcours')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Entreprise');
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
            DateField::new('date_debut')
                ->setRequired(true)
                ->setLabel('Date de début :')
                ->setHelp('Format : JJ/MM/AAAA'),
            ChoiceField::new('statut')
                ->setChoices(array_combine(
                    array_map(fn($case) => $case->value, StatutEnum::cases()),
                    StatutEnum::cases()
                ))
                ->setRequired(true)
                ->setLabel('Statut :')
                ->setHelp('Sélectionnez un statut pour cette mission'),
            DateField::new('date_fin')
                ->setRequired(false)
                ->setLabel('Date de fin :')
                ->setHelp('Format : JJ/MM/AAAA, laissez vide si en cours ou en cours de réflexion'),
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
            TextEditorField::new('contenu')
                ->setRequired(true)
                ->setLabel('Contenu du parcours :')
                ->setHelp('Entre 1 et 1024 caractères maximum, au format HTML')            
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
