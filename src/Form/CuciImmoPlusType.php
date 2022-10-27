<?php

namespace App\Form;

use App\Entity\CuciImmoPlus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CuciImmoPlusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('createdAt')
            ->add('updatedAt')
            ->add('amortPr')
            ->add('anneeFinanciere')
            ->add('brut')
           
            ->add('net')
            ->add('submit')
            ->add('valeur')
            ->add('createdBy')
            ->add('modifiedBy')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CuciImmoPlus::class,
        ]);
    }
}
