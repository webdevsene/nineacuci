<?php

namespace App\Form;

use App\Entity\CompteDeResultats;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompteDeResultatsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rank')
            ->add('submit')
            ->add('status')
            ->add('ref_code')
            ->add('annee_financiere')
            ->add('uploaded_file_name')
            ->add('net1')
            ->add('net2')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('cuci_rep_code')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CompteDeResultats::class,
        ]);
    }
}
