<?php

namespace App\Form;

use App\Entity\Dirigeant;
use App\Entity\Qualite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class DirigeantShowType extends AbstractType
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
            array('label'=>'Nom ',
            'required'=>false,
            'disabled'=>true,
            'attr'=>array('class'=>'form-control')))
           
            ->add('prenom',TextType::class,
            array('label'=>'Prénom',
            'required'=>false,
            'attr'=>array('class'=>'form-control')))
            ->add('numero',TextType::class,
            array('label'=>'Numéro ',
            'required'=>false,
            'disabled'=>true,
            'attr'=>array('class'=>'form-control')))
          
              ->add('position', EntityType::class, [
                 'class' => Qualite::class,
                'choice_label' => 'getCodeLibelle',
                'attr'=>array('class'=>'form-control form-control-sm syscoa', "style"=>"width:100%;"),
               
                'required'=>false,
                'disabled'=>true,
                'label'=>'Fonction/Qualité ',

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
