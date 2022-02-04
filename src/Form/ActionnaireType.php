<?php

namespace App\Form;

use App\Entity\Actionnaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class ActionnaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
            ->add('capital',IntegerType::class,
            array('label'=>'Capital  ',
            'required'=>false,
            'attr'=>array('class'=>'form-control')))
            ->add('pourcentage',IntegerType::class,
            array('label'=>'Pourcentage  ',
            'required'=>false,
            'attr'=>array('class'=>'form-control')))
            
            ->add('nationality', ChoiceType::class, [
                  'label'=>'Nationalité ',
                  'choices'  => [
                      '' => "choissir...",
                      'Teste' => "Teste"
                  ],
                  'attr'=>array('class'=>'form-control select2'),
                   'required'=>false
              ])
            ->add('nom',TextType::class,
            array('label'=>'Nom  ',
            'required'=>false,
            'attr'=>array('class'=>'form-control')))
            ->add('prenom',TextType::class,
            array('label'=>'Prénom  ',
            'required'=>false,
            'attr'=>array('class'=>'form-control')))
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Actionnaire::class,
        ]);
    }
}
