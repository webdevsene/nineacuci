<?php

namespace App\Form;

use App\Entity\Filiales;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class FilialesShowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
            ->add('capital',TextType::class,
            array('label'=>'Capital  ',
            'required'=>false,
            'disabled'=>true,
            'attr'=>array('class'=>'form-control')))
            ->add('designation',TextType::class,
            array('label'=>'Désignation  ',
            'required'=>false,
            'disabled'=>true,
            'attr'=>array('class'=>'form-control')))
           
             ->add('nationality', ChoiceType::class, [
                  'label'=>'Nationalité ',
                  'attr'=>array('class'=>'form-control select2'),
                  'choices'  => [
                      '' => "choissir...",
                      'Teste' => "Teste"
                  ],
                   'required'=>false,
                   'disabled'=>true,
              ])
            ->add('pourcentage',TextType::class,
            array('label'=>'Pourcentage  ',
            'required'=>false,
            'disabled'=>true,
            'attr'=>array('class'=>'form-control')))
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Filiales::class,
        ]);
    }
}
