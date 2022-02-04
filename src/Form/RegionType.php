<?php

namespace App\Form;

use App\Entity\Region;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('regCD')
            ->add('regActiviteF')
            ->add('regCDATE')
            ->add('regCUSER')
            ->add('regCDMIG')
            ->add('regContactDetails')
            ->add('regDescription')
            ->add('regMDATE')
            ->add('regMUSER')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Region::class,
        ]);
    }
}
