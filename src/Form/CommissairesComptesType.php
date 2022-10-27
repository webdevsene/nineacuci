<?php

namespace App\Form;

use App\Entity\CommissairesComptes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class CommissairesComptesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('address',TextType::class,
            array('label'=>'Adresse  ',
            'required'=>false,
            'attr'=>array('class'=>'form-control')))
            ->add('nom',TextType::class,
            array('label'=>'Nom  ',
            'required'=>false,
            'attr'=>array('class'=>'form-control')))
            ->add('prenom',TextType::class,
            array('label'=>'prenom  ',
            'required'=>false,
            'attr'=>array('class'=>'form-control')))
            ->add('telephone',TextType::class,
            array('label'=>'Tél  ',
            'required'=>false,
            'attr'=>array('class'=>'form-control')))
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CommissairesComptes::class,
        ]);
    }
}
