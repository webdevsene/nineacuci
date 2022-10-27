<?php

namespace App\Form;

use App\Entity\JournalDettesPayerSmt;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JournalDettesPayerSmtType extends AbstractType
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

            ->add('numFacture', TextType::class, 
                array('label'=>'',
                'required'=>false,
                'attr'=>array('class'=>'form-control form-control-sm',)
            ))

            ->add('nom', TextType::class, 
                array('label'=>'',
                'required'=>false,
                'attr'=>array('class'=>'form-control form-control-sm',)
            ))

            ->add('montant', TextType::class, 
                array('label'=>'',
                'required'=>false,
                'attr'=>array('class'=>'form-control form-control-sm',
                          'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")
            ))

            ->add('datePaiement', DateType::class, 
                array('label'=>'',
                'required'=>false,
                'widget' => 'single_text',
                'attr'=>array('class'=>'form-control form-control-sm',)
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => JournalDettesPayerSmt::class,
        ]);
    }
}
