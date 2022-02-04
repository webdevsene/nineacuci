<?php

namespace App\Form;

use App\Entity\CAV;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class CAVType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('CAVID')
            ->add('cavActiveF')
            ->add('cavCDATE')
            ->add('cavCUSER')
            ->add('cavCDMIG')
            ->add('cavCD')
            ->add('cavDescription')
            ->add('cavMDATE')
            ->add('cavMUSER')
            ->add('cavDEPID')

            ->add('cavDEPID',EntityType::class,
                   array( 'placeholder'=>'Sélectionner ......',
                           'class'=>'App:Departement',
                          'label'=>'Departemet',
                          'required'=>true,
                         
                          'choice_label'=>'depCUSER',
                          'attr'=>array('class'=>'form-control')              
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CAV::class,
        ]);
    }
}
