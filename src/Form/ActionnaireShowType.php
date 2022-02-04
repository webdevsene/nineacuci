<?php

namespace App\Form;

use App\Entity\Actionnaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class ActionnaireShowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
            ->add('capital',TextType::class,
            array('label'=>'Capital  ',
            'required'=>false,
            'disabled'=>true,
            'attr'=>array('class'=>'form-control')))
            ->add('pourcentage',TextType::class,
            array('label'=>'Pourcentage  ',
            'required'=>false,
            'disabled'=>true,
            'attr'=>array('class'=>'form-control')))
            
            ->add('nationality', ChoiceType::class, [
                  'label'=>'Nationalité ',
                  'choices'  => [
                      '' => "choissir...",
                      'Teste' => "Teste"
                  ],
                  'attr'=>array('class'=>'form-control select2'),
                   'required'=>false,
                   'disabled'=>true,
              ])
            ->add('nom',TextType::class,
            array('label'=>'Nom  ',
            'required'=>false,
            'disabled'=>true,
            'attr'=>array('class'=>'form-control')))
            ->add('prenom',TextType::class,
            array('label'=>'Prénom  ',
            'required'=>false,
            'disabled'=>true,
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
