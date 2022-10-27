<?php

namespace App\Form;

use App\Entity\ComptederesultatSmt;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComptederesultatSmtType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rank')
            ->add('submit')
            ->add('status')
            ->add('refCode')
            ->add('anneeFinanciere')
            ->add('uploadedFileName')
            ->add('net1')
            ->add('net2')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('repertoire')
            ->add('createdBy')
            ->add('updatedBy')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ComptederesultatSmt::class,
        ]);
    }
}
