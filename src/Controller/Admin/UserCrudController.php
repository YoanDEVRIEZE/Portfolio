<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Vich\UploaderBundle\Form\Type\VichFileType;

class UserCrudController extends AbstractCrudController
{
    public function __construct(
        public UserPasswordHasherInterface $userPasswordHasher
    ) {}

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier un utilisateur')
            ->setPageTitle(Crud::PAGE_INDEX, 'Utilisateur');
    }

    public function configureFields(string $pageName): iterable
    {
        $isCreatedPage = $pageName === 'new';

        return [
            TextField::new('Email')
                ->setLabel('E-mail :')
                ->setRequired(true)
                ->setMaxLength(320)
                ->setHelp('Entre 5 et 320 caractères maximum'),
            TextField::new('Nom')
                ->setLabel('Nom :')
                ->setRequired(true)
                ->setMaxLength(50)
                ->setHelp('Entre 1 et 50 caractères maximum'),
            TextField::new('Prenom')
                ->setLabel('Prénom :')
                ->setRequired(true)
                ->setMaxLength(50)
                ->setHelp('Entre 1 et 50 caractères maximum'),
            TextField::new('Telephone')
                ->setLabel('Téléphone :')
                ->setRequired(false)
                ->setMaxLength(10)
                ->setHelp('Entre 1 et 10 caractères maximum'),
            TextField::new('Password')
                ->setFormType(RepeatedType::class)
                ->setFormTypeOptions([
                    'type' => PasswordType::class,
                    'first_options' => ['label' => 'Mot de passe :', 'help' => 'Entre 6 et 25 caractères maximum, au moins une majuscule, une minuscule et un chiffre'],
                    'second_options' => ['label' => 'Confirmer le mot de passe :', 'help' => 'Veuillez comfirmer votre mot de passe'],
                    'invalid_message' => 'Les mots de passe doivent correspondre',
                    'mapped' => false,
                ])
                ->onlyOnForms()
                ->setRequired($isCreatedPage)
                ->setMaxLength(50),
            TextField::new('Git')
                ->setLabel('Lien GitHub :')
                ->setRequired(false)
                ->setMaxLength(255)
                ->setHelp('Entre 1 et 255 caractères maximum'),
            TextField::new('Linkedin')
                ->setLabel('Lien Linkedin :')
                ->setRequired(false)
                ->setMaxLength(255)
                ->setHelp('Entre 1 et 255 caractères maximum'),
            Field::new('cv')
                ->setFormType(VichFileType::class)
                ->setFormTypeOptions([
                    'download_label' => true,
                    'allow_delete' => false,
                    'attr' => [
                        'accept' => 'application/pdf',
                    ]
                ])
                ->setLabel('Votre CV :')
                ->setRequired(false)
                ->hideOnIndex()
                ->hideOnDetail()
                ->setHelp('Fichier au format .pdf, avec une taille maximale de 10Mo'),
            TextField::new('cvFileName')
                ->hideOnForm()
                ->setLabel('Votre CV :')
                ->formatValue(function ($value, $entity) {
                    if (!$value) {
                        return '<span>Aucun fichier</span>';
                    }
                    return sprintf('<a href="/uploads/files/%s" target="_blank" class="btn btn-primary">Télécharger le CV</a>', $value);
                })
        ];
    }

    public function createNewFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $formBuilder = parent::createNewFormBuilder($entityDto, $formOptions, $context);
        return $this->addPasswordEventListener($formBuilder);
    }

    public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $formBuilder = parent::createEditFormBuilder($entityDto, $formOptions, $context);
        return $this->addPasswordEventListener($formBuilder);
    }

    private function addPasswordEventListener(FormBuilderInterface $formBuilder): FormBuilderInterface
    {
        return $formBuilder->addEventListener(FormEvents::POST_SUBMIT, $this->hashPassword());
    }

    private function hashPassword() {
        return function($event) {
            $form = $event->getForm();
            if (!$form->isValid()) {
                return;
            }
            $password = $form->get('Password')->getData();
            if ($password === null) {
                return;
            }

            $hash = $this->userPasswordHasher->hashPassword($this->getUser(), $password);
            $form->getData()->setPassword($hash);
        };
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_EDIT, Action::INDEX)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_EDIT, Action::DETAIL)
            ->disable(Action::NEW, Action::DELETE); 
            ;
    }
}
