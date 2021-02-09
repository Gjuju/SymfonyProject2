<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreationProduitForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categorie',null,[
                'required' => false
            ])
            ->add('nom',null,[
                'required' => false
            ])
            ->add('description',null,[
                'required' => false
            ])
            ->add('prix', null,[
                'required' => false
            ])
            ->add('stock',null,[
                'required' => false
            ])
            ->add('photo', null,[
                'required' => false
            ])

            ->add('is_active', CheckboxType::class,[
                'label' => 'Activé',
                'required' => false
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [ 'class' => 'btn-success' ]
            ]);
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}