<?php

namespace App\Form;

use App\Entity\FluxDesTresoreries;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FluxDesTresoreriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id')
            ->add('annee_financiere')
            ->add('ref_code')
            ->add('net1')
            ->add('net2')
            ->add('status')
            ->add('upload_file_name')
            ->add('rank')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('createdBy')
            ->add('updatedBy')
            ->add('cuci_rep_code')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FluxDesTresoreries::class,
        ]);
    }
}
