<?php

namespace App\Form;

use App\Entity\NiPersonne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NiPersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ninNom')
            ->add('ninPrenom')
            ->add('ninSexe')
            ->add('ninDate_Naissance')
            ->add('ninLieu_Naissance')
            ->add('ninQualification')
            ->add('ninCNI')
            ->add('ninDateCNI')
            ->add('ninCivilite')
            ->add('ninNationalite')
            ->add('ninSigle')
            
            ->add('ninRaison')
           
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NiPersonne::class,
        ]);
    }
}
