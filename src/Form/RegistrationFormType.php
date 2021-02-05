<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationFormType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /* ->add('username') */
            /* ->add('roles') */
            ->add('firstName', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse'
            ])
            ->add('phone_number', TextType::class, [
                'label' => 'Téléphone'
            ])
            ->add('birth_date', DateType::class, [
                'label' => 'Date de naissance'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse mail'
            ])
            ->add('password', PasswordType::class, [
                'label'=> 'Mot de passe',
                'always_empty'=> true,
            ])            /* ->add('isVerified') */
            /* ->add('panier') */
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [ 'class' => 'btn-primary' ]
            ]);
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
