<?php

namespace App\Form;

use App\Entity\TempNINinea;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TempNINineaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ninRaison')
            ->add('ninRegcom')
            ->add('ninNumattrib')
            ->add('ninNinea')
            ->add('ninMisajour')
            ->add('ninSigle')
            ->add('ninCreation')
            ->add('ninCuci')
            ->add('ninDatcre')
            ->add('ninDatreg')
            ->add('ninEmployninEmploy')
            ->add('ninEnseigne')
            ->add('ninEtabsecond')
            ->add('ninEtat')
            ->add('ninMetier')
            ->add('ninNetab')
            ->add('ninNineamere')
            ->add('ninNumetab')
            ->add('ninSiglemere')
            ->add('ninmajdate')
            ->add('ninmaj')
            ->add('ninNumerodemande')
            ->add('ninCreationninea')
            ->add('formeUnite')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('niLibelleactiviteglobale')
            ->add('ninTitrefoncier')
            ->add('ninAgrement')
            ->add('ninArrete')
            ->add('ninRecepisse')
            ->add('ninAccord')
            ->add('ninBordereau')
            ->add('ninBail')
            ->add('ninPermisoccuper')
            ->add('ninNature')
            ->add('ninAdministration')
            ->add('formeJuridique')
            ->add('createdBy')
            ->add('modifiedBy')
            ->add('ninStatut')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TempNINinea::class,
        ]);
    }
}
