<?php

namespace App\Form;

use App\Entity\EtatDesStocksSmt;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;

class EtatDesStocksSmtType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference', TypeTextType::class, 
                array('label'=>'',
                'required'=>false,
                'attr'=>array('class'=>'form-control form-control-sm',)
                ))
            ->add('designation', TypeTextType::class, 
                array('label'=>'',
                'required'=>false,
                'attr'=>array('class'=>'form-control form-control-sm',)
                ))
            ->add('quantite', TypeTextType::class, 
                array('label'=>'',
                'required'=>false,
                'attr'=>array('class'=>'form-control form-control-sm',
                'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")
                ))
            ->add('prixUnitaire', TypeTextType::class, 
                array('label'=>'',
                'required'=>false,
                'attr'=>array('class'=>'form-control form-control-sm',
                'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")
                ))
            ->add('montant', TypeTextType::class, 
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
            'data_class' => EtatDesStocksSmt::class,
        ]);
    }
}
