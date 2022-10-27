<?php

namespace App\Form;

use App\Entity\NAEMA;
use App\Entity\RefNaemaNew;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NAEMAType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder            
            ->add('id',TextType::class,
            array('label'=>'Code ',
            'required'=>true,
        
            'attr'=>array('class'=>'form-control')) )
            ->add('libelle',TextType::class,
            array('label'=>'Libelle ',
            'required'=>true,
           
            'attr'=>array('class'=>'form-control')) )            
            ->add('refNaemaNew', EntityType::class, [
                'class' => RefNaemaNew::class,
                 'placeholder'=>'Sélectionner.......',
               'choice_label' => 'libelle',
               'attr'=>array('class'=>'form-control form-control-sm'),
               'required'=>true,
               'label'=>'Nouvelle REF NEAMA '
               
           ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NAEMA::class,
        ]);
    }
}
