<?php

namespace App\Form;

use App\Entity\NinJourFerier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NinJourFerierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nindescription', TextareaType::class,
            array('label'=>'Description',
                   'required'=> true,
                   'attr'=>array('class'=>'form-control form-control-sm p-2')))
            ->add('Ninjour', DateType::class,
            array('label'=>'Jour férié',
                   'required'=> true,
                   'attr'=>array('class'=>'form-control form-control-sm'),
                   'widget' => 'single_text'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NinJourFerier::class,
        ]);
    }
}
