<?php

namespace App\Form;

use App\Entity\Pays;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaysType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', TextType::class, 
            array('label'=>'Code pays',
                   'required'=> true,
                   'attr'=>array('class'=>'form-control form-control-sm p-2')))
            ->add('libelle', TextType::class, 
            array('label'=>'Libelle',
                   'required'=> true,
                   'attr'=>array('class'=>'form-control form-control-sm p-2')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pays::class,
        ]);
    }
}
