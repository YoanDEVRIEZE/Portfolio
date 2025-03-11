<?php

namespace App\Controller\Admin;

use App\Entity\Skill;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SkillCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Skill::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter un skill')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier un skill')
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des skills')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Skill');
    }

    public function configureFields(string $pageName): iterable
    {
        $isCreatePage = $pageName === 'new';

        return [
            TextField::new('titre')
                ->setRequired(true)
                ->setMaxLength(100)
                ->setHelp('Entre 1 et 100 caractères maximum')
                ->setLabel('Nom :'),
            ImageField::new('logo')
                ->setBasePath('styles/img/icones_competences/')
                ->setUploadDir('assets/styles/img/icones_competences/')
                ->setUploadedFileNamePattern('[randomhash].webp')
                ->setLabel('Logo :')
                ->setHelp('Image au format .webp, de préférence avec un fond transparent')
                ->setRequired($isCreatePage)
                ->setFormTypeOptions([
                    'attr' => ['accept' => 'image/webp']
                ]),
            IntegerField::new('niveau')
                ->setRequired(true)
                ->setLabel('Niveau :')
                ->setHelp('Entre 0 et 100'),
            ColorField::new('couleur')
                ->setRequired(true)
                ->setHelp('Selectionnez une couleur correspondante au skill')
                ->setLabel('Couleur associée:')
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
