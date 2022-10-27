<?php

namespace App\Form;

use App\Entity\DbChange;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DbChangeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('created_at')
            ->add('table_name')
            ->add('entity_id')
            ->add('action')
            ->add('field_name')
            ->add('old_value')
            ->add('new_value')
            ->add('user_id')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DbChange::class,
        ]);
    }
}
