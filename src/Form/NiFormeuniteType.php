<?php

namespace App\Form;

use App\Entity\NiFormeunite;
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

class NiFormeuniteType extends AbstractType
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
            
            'attr'=>array('class'=>'form-control' )) )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NiFormeunite::class,
        ]);
    }
}
