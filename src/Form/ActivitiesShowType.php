<?php

namespace App\Form;

use App\Entity\Activities;
use App\Entity\SYSCOA;
use App\Entity\NAEMA;
use App\Entity\NAEMAS;
use App\Entity\CITI;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;



class ActivitiesShowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('chiffreAffaire',TextType::class,
                   array('label'=>'Chiffre d\'affaire  ',
                   'required'=>false,
                   'disabled'=>true,
                   'attr'=>array('class'=>'form-control')))
            ->add('pourcentage',TextType::class,
                   array('label'=>'Pourcentage ',
                   'required'=>false,
                   'disabled'=>true,
                   'attr'=>array('class'=>'form-control')))
            ->add('valeurAjoutee',TextType::class,
                   array('label'=>'Valeur ajoutée ',
                   'required'=>false,
                   'disabled'=>true,
                   'attr'=>array('class'=>'form-control')))
            ->add('libelleActivitePrincipale',TextType::class,
                    array('label'=>'Libelle ',
                   'required'=>false,
                   'disabled'=>true,
                   'attr'=>array('class'=>'')) )
            ->add('activitePrincipale',CheckboxType::class,
                    array('label'=>'Activite principale',
                          'required'=>false, 
                          'disabled'=>true,  
                ))
            
            ->add('sYSCOA', EntityType::class, [
                 'class' => SYSCOA::class,
                'choice_label' => 'libelle',
                'attr'=>array('class'=>'form-control select2'),
                'required'=>false,
                'disabled'=>true,

            ])
             ->add('cITI', EntityType::class, [
                 'class' => CITI::class,
                'choice_label' => 'libelle',
                'attr'=>array('class'=>'form-control select2'),
                'required'=>false,
                'disabled'=>true,

            ])

             ->add('nAEMA', EntityType::class, [
                 'class' => NAEMA::class,
                'choice_label' => 'libelle',
                'attr'=>array('class'=>'form-control select2'),
                'required'=>false,
                'disabled'=>true,

            ])

              ->add('nAEMAS', EntityType::class, [
                 'class' => NAEMAS::class,
                'choice_label' => 'libelle',
                'attr'=>array('class'=>'form-control select2'),
                'required'=>false,
                'disabled'=>true,

            ])
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Activities::class,
        ]);
    }
}
