<?php

namespace App\Form;

use App\Entity\CACR;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class CACRType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cacrID')
            ->add('cacrActiveF')
            ->add('cacrCDATE')
            ->add('cacrCUSER')
            ->add('cacrCD')
            ->add('cacrCDMIG')
            ->add('cacrDescription')
            ->add('cacrMDATE')
            ->add('cacrMUSER')
           
            ->add('cacrCAVID',EntityType::class,
                   array( 'placeholder'=>'Sélectionner ......',
                           'class'=>'App:CAV',
                          'label'=>'CAV',
                          'required'=>true,
                         
                          'choice_label'=>'cavCUSER',
                          'attr'=>array('class'=>'form-control')              
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CACR::class,
        ]);
    }
}
