<?php

namespace App\Form;

use App\Entity\MembreConseil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Qualite;



class MembreConseilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('addresse',TextType::class,
            array('label'=>'Adresse  ',
            'required'=>false,
            'attr'=>array('class'=>'form-control')))
            ->add('nom',TextType::class,
            array('label'=>'Nom  ',
            'required'=>false,
            'attr'=>array('class'=>'form-control')))
          
             ->add('position', EntityType::class, [
                 'class' => Qualite::class,
                'choice_label' => 'getCodeLibelle',
                'attr'=>array('class'=>'form-control form-control-sm syscoa', "style"=>"width:100%;"),
               
                'required'=>false,
              
                'label'=>'Fonction/Qualité ',

               ])
            ->add('prenom',TextType::class,
            array('label'=>'Prénom  ',
            'required'=>false,
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
