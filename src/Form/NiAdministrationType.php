<?php

namespace App\Form;

use App\Entity\NiAdministration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NiAdministrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('admcode', TextType::class,
            array('label'=>'Code',
                   'required'=> true,
                   'attr'=>array('class'=>'form-control form-control-sm p-2')))
            ->add('admlibelle', TextType::class,
            array('label'=>'Libelle',
                   'required'=> true,
                   'attr'=>array('class'=>'form-control form-control-sm p-2')))
            ->add('admContactDetails', TextareaType::class,
            array('label'=>'Contact',
                   'required'=> true,
                   'attr'=>array('class'=>'form-control form-control-sm p-2')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NiAdministration::class,
        ]);
    }
}
