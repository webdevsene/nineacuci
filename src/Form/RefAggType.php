<?php

namespace App\Form;

use App\Entity\RefAgg;
use App\Entity\Category;

use App\Entity\TypeBilan;
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


class RefAggType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            

             ->add('ordre',IntegerType::class,
                   array('label'=>'Ordre ',
                   'required'=>false,
                   
                   'attr'=>array('class'=>'form-control')))
           
            ->add('parent',TextType::class,
                    array('label'=>'Parent ',
                   'required'=>false,
                   'attr'=>array('class'=>'form-control')) )

             ->add('code',TextType::class,
                    array('label'=>'Code ',
                   'required'=>false,
                   'disabled'=>true,
                   'attr'=>array('class'=>'form-control')) )

             ->add('libelle',TextType::class,
                    array('label'=>'Libelle ',
                   'required'=>false,
                   'attr'=>array('class'=>'form-control')) )
                   
             ->add('signes',TextType::class,
                    array('label'=>'Signe s ',
                   'required'=>false,
                   'attr'=>array('class'=>'form-control')) )

             ->add('notes',TextType::class,
                    array('label'=>'Note ',
                   'required'=>false,
                   'attr'=>array('class'=>'form-control')) )
           

            ->add('surlignee',CheckboxType::class,
                    array('label'=>'Surlignée',
                          'required'=>false,  
                           'attr'=>array('style'=>'width: 100px;'),
                ))

            ->add('category', EntityType::class, [
                 'class' => Category::class,
                  'placeholder'=>'Sélectionner.......',
                'choice_label' => 'libelle',
                'attr'=>array('class'=>'form-control syscoa'),
                'required'=>false,
                
            ])

            ->add('typeBilan', EntityType::class, [
                 'class' => TypeBilan::class,
                  'placeholder'=>'Sélectionner.......',
                'choice_label' => 'libelle',
                'attr'=>array('class'=>'form-control syscoa'),
                'required'=>false,
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RefAgg::class,
        ]);
    }
}
