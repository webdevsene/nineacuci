<?php

namespace App\Form;

use App\Entity\NiFormejuridique;
use App\Entity\NiFormeunite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class NiFormejuridiqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id',TextType::class,
            array('label'=>'Code ',
            'required'=>true,
           
            'attr'=>array('class'=>'form-control')) )
            ->add('fojLibelle',TextType::class,
            array('label'=>'Libelle ',
            'required'=>true,
           
            'attr'=>array('class'=>'form-control')) )
            ->add('niFormeunite', EntityType::class, [
                'class' => NiFormeunite::class,
                 'placeholder'=>'Sélectionner.......',
               'choice_label' => 'libelle',
               'attr'=>array('class'=>'form-control '),
               'required'=>true,
               'label'=>'Forme unité '
               
           ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NiFormejuridique::class,
        ]);
    }
}
