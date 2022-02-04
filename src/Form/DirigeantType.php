<?php

namespace App\Form;

use App\Entity\Dirigeant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class DirigeantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('addresse',TextType::class,
            array('label'=>'Addresse  ',
            'required'=>false,
            'attr'=>array('class'=>'form-control')))
            ->add('nom',TextType::class,
            array('label'=>'Nom ',
            'required'=>false,
            'attr'=>array('class'=>'form-control')))
           
            ->add('prenom',TextType::class,
            array('label'=>'Prénom',
            'required'=>false,
            'attr'=>array('class'=>'form-control')))
            ->add('numero',TextType::class,
            array('label'=>'Numéro ',
            'required'=>false,
            'attr'=>array('class'=>'form-control')))
            ->add('position', ChoiceType::class, [
                  'label'=>'Fonction/Qualité ',
                  'choices'  => [
                      '' => "choissir...",
                      'Teste' => "Teste"
                  ],
                  'attr'=>array('class'=>'form-control select2'),
                   'required'=>false
              ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dirigeant::class,
        ]);
    }
}
