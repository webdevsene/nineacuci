<?php

namespace App\Form;

use App\Entity\NinTypedocuments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NinTypedocumentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, 
            array('label'=>'Libelle',
                   'required'=> true,
                   'attr'=>array('class'=>'form-control form-control-sm p-2')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NinTypedocuments::class,
        ]);
    }
}
