<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'formulaireinput',
                    'placeholder' => 'Nom',
                ],
                'label' => false,
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le nom ne peut pas être vide.']),
                    new Assert\Length([
                        'min' => 2,
                        'max' => 50,
                        'minMessage' => 'Le nom doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le nom ne peut pas contenir plus de {{ limit }} caractères.'
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-ZÀ-ÿ\s\-]+$/u',
                        'message' => 'Le nom ne peut contenir que des lettres et des espaces.'
                    ])
                ]
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'class' => 'formulaireinput',
                    'placeholder' => 'Prénom',
                ],
                'label' => false,
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le prénom ne peut pas être vide.']),
                    new Assert\Length([
                        'min' => 2,
                        'max' => 50,
                        'minMessage' => 'Le prénom doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le prénom ne peut pas contenir plus de {{ limit }} caractères.'
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-ZÀ-ÿ\s\-]+$/u', 
                        'message' => 'Le prénom ne peut contenir que des lettres et des espaces.'
                    ])
                ]
            ])
            ->add('mail', EmailType::class, [
                'attr' => [
                    'class' => 'formulaireinput',
                    'placeholder' => 'Email',
                ],
                'label' => false,
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(['message' => 'L\'adresse email ne peut pas être vide.']),
                    new Assert\Email([
                        'message' => 'L\'adresse email "{{ value }}" n\'est pas valide.'
                    ])
                ]
            ])
            ->add('contenu', TextareaType::class, [
                'attr' => [
                    'class' => 'formulairearea',
                    'placeholder' => 'Votre message',
                ],
                'label' => false,
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le message ne peut pas être vide.']),
                    new Assert\Length([
                        'min' => 10,
                        'max' => 500,
                        'minMessage' => 'Le message doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le message ne peut pas contenir plus de {{ limit }} caractères.'
                    ])
                ]
            ])
            ->add('button', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'formulairebutton',
                ],
            ])             
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
