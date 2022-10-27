<?php

namespace App\Form;

use App\Entity\NiDirigeant;
use App\Entity\Qualite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class NiDirigeantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('ninAddresse',TextType::class,
        array('label'=>'Adresse  ',
        'required'=>false,
        'attr'=>array('class'=>'form-control')))
        
        ->add('ninNom',TextType::class,
        array('label'=>'Nom :',
        'required'=>false,
        'attr'=>array('class'=>'form-control')))
       
        ->add('ninPrenom',TextType::class,
        array('label'=>'Prénom :',
        'required'=>false,
        'attr'=>array('class'=>'form-control')))

        ->add('ninNumero',TextType::class,
        array('label'=>'Numéro ',
        'required'=>false,
        'attr'=>array('class'=>'form-control')))

        ->add('ninPosition', EntityType::class, [
             'class' => Qualite::class,
            'choice_label' => 'getCodeLibelle',
            'attr'=>array('class'=>'form-control form-control-sm syscoa', "style"=>"width:100%;"),
           
            'required'=>false,
            'label'=>'Fonction/Qualité :',

           ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NiDirigeant::class,
        ]);
    }
}
