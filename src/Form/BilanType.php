<?php

namespace App\Form;

use App\Entity\Bilan;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BilanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('amortPR')
            ->add('anneeFinanciere')
            ->add('brut')
            ->add('net1')
            ->add('net2')
            ->add('refCode')
            ->add('status')
            ->add('submit')
            ->add('type')
            ->add('typeRecupperation')
            ->add('uploadedFileName')
            ->add('createdBy')
            ->add('modifiedBy')
            ->add('repertoire')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bilan::class,
        ]);
    }
}
