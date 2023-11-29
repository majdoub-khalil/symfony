<?php

namespace App\Form;

use App\Entity\Personne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;


class SingupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('genre', ChoiceType::class, [
                'label' => 'Genre',
                'choices' => [
                    'Male' => 'Male',
                    'Female' => 'Female',
                ],
            ])
            ->add('dateNaissance', DateType::class, [
                'label' => 'Date de Naissance',
            ])
            ->add('motDePasse', PasswordType::class, [
                'label' => 'Mot de Passe',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%^&*]{8,}$/',
                        'message' => 'Le mot de passe doit contenir au moins 8 caractères, dont au moins un chiffre et une lettre.',
                    ]),
                ],
            ])
            ->add('motDePasse2', PasswordType::class, [
                'label' => 'Confirmer le Mot de Passe',
            ])
            ;
            
            
           
            #->add('Sign_Up', SubmitType::class, [
                #'label' => 'Sign Up',
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
    
}
