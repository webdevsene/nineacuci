<?php

namespace App\Form;

use App\Entity\DettesCreancesSmt;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class DettesCreancesSmtType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'Selectionner...' => null,
                    'Créances' => "Creances",
                    'Dettes' => "Dettes",
                ],
                'attr'=>array('class'=>'form-control form-control-sm',)
            ])
            ->add('dateJ', DateType::class, 
                array('label'=>'',
                'required'=>false,
                'widget' => 'single_text',
                'attr'=>array('class'=>'form-control form-control-sm')
                ))
            ->add('nom', TextType::class, 
                array('label'=>'',
                'required'=>false,
                'attr'=>array('class'=>'form-control form-control-sm',)
            ))
            ->add('montant1', TextType::class, 
                array('label'=>'',
                'required'=>false,
                'attr'=>array('class'=>'form-control form-control-sm',
                'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")
            ))
            ->add('montant2', TextType::class, 
                array('label'=>'',
                'required'=>false,
                'attr'=>array('class'=>'form-control form-control-sm',
                'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")
            ))
            ->add('variation', TextType::class, 
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
            'data_class' => DettesCreancesSmt::class,
        ]);
    }
}
