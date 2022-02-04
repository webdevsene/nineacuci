<?php

namespace App\Form;

use App\Entity\QVH;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class QVHType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('QVHID')
            ->add('qvhCUSER')
            ->add('qvhActiveF')
            ->add('qvhCDATE')
            ->add('qvhCD')
            ->add('qvhCDMIG')
            ->add('qvhDescription')
            ->add('qvhMDATE')
            ->add('qvhMUSER')
            ->add('qvhTYPE')
            ->add('qvhCACRID',EntityType::class,
                   array( 'placeholder'=>'Sélectionner ......',
                           'class'=>'App:CACR',
                          'label'=>'CACR',
                          'required'=>true,
                         
                          'choice_label'=>'cacrCUSER',
                          'attr'=>array('class'=>'form-control')              
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => QVH::class,
        ]);
    }
}
