<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /* ->add('username') */
            /* ->add('roles') */
            ->add('firstName')
            ->add('lastName')
            ->add('address')
            ->add('phone_number')
            ->add('birth_date')
            ->add('email')
            ->add('password')
            /* ->add('isVerified') */
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
