<?php

namespace App\Form;

use App\Entity\SuiviMaterielMobilierCaution;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SuiviMaterielMobilierCautionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('createdAt')
            ->add('updatedAt')
            ->add('anneeFinanciere')
            ->add('dateJ')
            ->add('designation')
            ->add('montant')
            ->add('dateDeSortie')
            ->add('prixDeCession')
            ->add('submit')
            ->add('status')
            ->add('repertoire')
            ->add('createdBy')
            ->add('modifiedBy')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SuiviMaterielMobilierCaution::class,
        ]);
    }
}
