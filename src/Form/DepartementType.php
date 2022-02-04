<?php

namespace App\Form;

use App\Entity\Departement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class DepartementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('depId')
            ->add('depActiveF')
            ->add('depCDATE')
            ->add('depCUSER')
            ->add('depCD')
            ->add('depCDMIG')
            ->add('depDescription')
            ->add('depMDATE')
            ->add('depMUSER')
           
             ->add('depRegCD',EntityType::class,
                   array( 'placeholder'=>'Sélectionner ......',
                           'class'=>'App:Region',
                          'label'=>'Region',
                          'required'=>true,
                         
                          'choice_label'=>'regCUSER',
                          'attr'=>array('class'=>'form-control')              
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Departement::class,
        ]);
    }
}
