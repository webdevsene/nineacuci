<?php

namespace App\Form;

use App\Entity\NiNineaproposition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NiRechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('createdAt')
            ->add('updatedAt')
            ->add('ninRaison')
            ->add('ninRegcom')
            ->add('ninNinea')
            ->add('ninMisajour')
            ->add('ninSigle')
            ->add('ninCreation')
            ->add('ninEnseigne')
            ->add('ninEtat')
            ->add('ninNineamere')
            ->add('ninNumetab')
            ->add('ninmajdate')
            ->add('ninnumerodemande')
            ->add('nincreationninea')
            ->add('ninSiglemere')
            ->add('ninRemarque')
            ->add('ninDatreg')
            ->add('statut')
            ->add('createdBy')
            ->add('modifiedBy')
            ->add('ninStatut')
            ->add('ninAdministration')
            ->add('ninFormejuridique')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NiNineaproposition::class,
        ]);
    }
}
