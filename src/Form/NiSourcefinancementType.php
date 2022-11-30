<?php

namespace App\Form;

use App\Entity\NiSourcefinancement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NiSourcefinancementType extends AbstractType
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
            'required'=>true))

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NiSourcefinancement::class,
        ]);
    }
}
