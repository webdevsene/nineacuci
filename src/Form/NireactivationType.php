<?php

namespace App\Form;

use App\Entity\Nireactivation;
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
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Entity\NINinea;


class NireactivationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateReactivation', DateType::class, ['label'=>'Date de réactivation',
            'attr'=>array('class'=>'form-control form-control-sm'),
            'required'=>false,          
            'widget' => 'single_text'])
            ->add('remarque', TextareaType::class, ['label'=>'Remarque ou Commentaire',
            'attr'=>array('class'=>'form-control form-control-sm'),
            'required'=>false,])            
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Nireactivation::class,
        ]);
    }
}
