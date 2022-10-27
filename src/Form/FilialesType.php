<?php

namespace App\Form;

use App\Entity\Filiales;
use App\Entity\Pays;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;




class FilialesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
            ->add('capital',TextType::class,
            array('label'=>'Capital  ',
            'required'=>false,
            'attr'=>array('oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');",'class'=>'form-control capitalfiliale')))
            ->add('designation',TextType::class,
            array('label'=>'Désignation  ',
            'required'=>false,
            'attr'=>array('class'=>'form-control')))
           
             ->add('pays', EntityType::class, [
                 'class' => Pays::class,
                'choice_label' => 'libelle',
                'attr'=>array('class'=>'form-control form-control-sm syscoa', "style"=>"width:100%;"),
               
                'required'=>false,
                'label'=>'Nationalité ',

               ])
            ->add('pourcentage',TextType::class,
            array('label'=>'Pourcentage  ',
            'required'=>false,
            'attr'=>array('oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');",'class'=>'form-control pourcentagefiliale')))
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Filiales::class,
        ]);
    }
}
