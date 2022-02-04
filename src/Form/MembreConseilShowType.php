<?php

namespace App\Form;

use App\Entity\MembreConseil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class MembreConseilShowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('addresse',TextType::class,
            array('label'=>'Addresse  ',
            'required'=>false,
            'disabled'=>true,
            'attr'=>array('class'=>'form-control')))
            ->add('nom',TextType::class,
            array('label'=>'Nom  ',
            'required'=>false,
            'disabled'=>true,
            'attr'=>array('class'=>'form-control')))
          
             ->add('position', ChoiceType::class, [
                  'label'=>'Nationalité ',
                  'attr'=>array('class'=>'form-control select2'),
                  'choices'  => [
                      '' => "choissir...",
                      'Teste' => "Teste"
                  ],
                   'required'=>false,
                   'disabled'=>true,
              ])
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
            'data_class' => MembreConseil::class,
        ]);
    }
}
