<?php

namespace App\Form;

use App\Entity\JournalTresorerie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JournalTresorerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateJ', DateType::class, 
                array('label'=>'',
                'required'=>false,
                'widget' => 'single_text',
                'attr'=>array('class'=>'form-control form-control-sm',)
            ))

            ->add('libelle', TextType::class, 
                array('label'=>'',
                'required'=>false,
                'attr'=>array('class'=>'form-control form-control-sm',)
            ))

            ->add('recettes', TextType::class, 
                array('label'=>'',
                'required'=>false,
                'attr'=>array('class'=>'form-control form-control-sm',
                              'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")
            ))

            ->add('depenses', TextType::class, 
                array('label'=>'',
                'required'=>false,
                'attr'=>array('class'=>'form-control form-control-sm',
                'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")
            ))

            ->add('solde', TextType::class, 
                array('label'=>'',
                'required'=>false,
                'attr'=>array('class'=>'form-control form-control-sm',
                'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")
            ))

            ->add('vrVentes', TextType::class, 
                array('label'=>'',
                'required'=>false,
                'attr'=>array('class'=>'form-control form-control-sm',
                'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")
            ))

            ->add('vrAutres', TextType::class, 
                array('label'=>'',
                'required'=>false,
                'attr'=>array('class'=>'form-control form-control-sm',
                'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")
            ))

            ->add('vdMobiliers', TextType::class, 
                array('label'=>'',
                'required'=>false,
                'attr'=>array('class'=>'form-control form-control-sm',
                'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")
            ))

            ->add('vdMarchandises', TextType::class, 
                array('label'=>'',
                'required'=>false,
                'attr'=>array('class'=>'form-control form-control-sm',
                'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")
            ))

            ->add('vdFournitures', TextType::class, 
                array('label'=>'',
                'required'=>false,
                'attr'=>array('class'=>'form-control form-control-sm',
                'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")
            ))

            ->add('vdLoyer', TextType::class, 
                array('label'=>'',
                'required'=>false,
                'attr'=>array('class'=>'form-control form-control-sm',
                'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")
            ))

            ->add('vdSalaires', TextType::class, 
                array('label'=>'',
                'required'=>false,
                'attr'=>array('class'=>'form-control form-control-sm',
                'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")
            ))

            ->add('vdImpots', TextType::class, 
                array('label'=>'',
                'required'=>false,
                'attr'=>array('class'=>'form-control form-control-sm',
                'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")
            ))

            ->add('vdAutres', TextType::class, 
                array('label'=>'',
                'required'=>false,
                'attr'=>array('class'=>'form-control form-control-sm',
                'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => JournalTresorerie::class,
        ]);
    }
}
