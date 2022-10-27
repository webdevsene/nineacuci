<?php

namespace App\Form;

use App\Entity\SuiviMaterielMobilier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SuiviMaterielMobilierType extends AbstractType
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
            ->add('designation', TypeTextType::class, 
            array('label'=>'',
            'required'=>false,
            'attr'=>array('class'=>'form-control form-control-sm',)
                ))
            ->add('montant', TypeTextType::class, 
                    array('label'=>'',
                    'required'=>false,
                    'attr'=>array('class'=>'form-control form-control-sm',
                    'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")
                        ))
            ->add('dateDeSortie', DateType::class, 
                    array('label'=>'',
                    'required'=>false,
                    'widget' => 'single_text',
                    'attr'=>array('class'=>'form-control form-control-sm',)
                        ))
            ->add('prixDeCession', TypeTextType::class, 
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
            'data_class' => SuiviMaterielMobilier::class,
        ]);
    }
}
