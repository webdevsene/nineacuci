<?php

namespace App\Form;

use App\Entity\NAEMA;
use App\Entity\RefProduits;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RefProduitsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', TextType::class,
            array('label' => 'Code',
                  'required' => true,
                  'attr' => array('class' => 'form-control')))
            ->add('libelle', TextType::class,
                 array('label'=>'Libelle',
                 'required'=> true,
                 'attr'=>array('class'=>'form-control')))
            ->add('naema', EntityType::class, [
                'class'=>NAEMA::class,
				'expanded' => false,
				'multiple' => false,
                'placeholder'=>'Sélectionner.......',
                'choice_label' => 'libelle',
                'attr'=>array('class'=>' select2 form-select'),
                'required'=>true,
                'label'=>'Reference NAEMA du produit ' 
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RefProduits::class,
        ]);
    }
}
