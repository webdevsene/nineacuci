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
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;





class ActivitiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('chiffreAffaire',IntegerType::class,
                   array('label'=>'Chiffre d\'affaire  ',
                   'required'=>false,
                   'attr'=>array('class'=>'form-control ','min'=>0)))
            ->add('pourcentage',IntegerType::class,
                   array('label'=>'Pourcentage ',
                   'required'=>false,
                   'attr'=>array(
                       'class'=>'form-control',
                       'min'=>0,
                       'max'=>100
                    )))
            ->add('valeurAjoutee',IntegerType::class,
                   array('label'=>'Valeur ajoutée ',
                   'required'=>false,
                   'attr'=>array('class'=>'form-control','min'=>0)))
            ->add('libelleActivitePrincipale',TextareaType::class,
                    array('label'=>'Libelle ',
                   'required'=>false,
                   'attr'=>array('class'=>'form-control')) )
            
            
            ->add('sYSCOA', EntityType::class, [
                 'class' => SYSCOA::class,
                'choice_label' => 'getCodeLibelle',
                'attr'=>array('class'=>'form-control form-control-sm select2  syscoa', "style"=>"width:100%;"),
                'required'=>false,

            ])
             ->add('cITI', EntityType::class, [
                 'class' => CITI::class,
                'choice_label' => 'getCodeLibelle',
                'attr'=>array('class'=>'form-control form-control-sm select2  syscoa', "style"=>"width:100%;"),
                'required'=>false,

            ])

              ->add('activitePrincipale',CheckboxType::class,
                    array('label'=>'Activite principale',
                          'required'=>false,  
                            'attr'=>array(), 
                ))

             ->add('nAEMA', EntityType::class, [
                 'class' => NAEMA::class,
                'choice_label' => 'getCodeLibelle',
                'attr'=>array('class'=>'form-control form-control-sm select2  syscoa', "style"=>"width:100%;"),
                'required'=>false,

            ])

              ->add('nAEMAS', EntityType::class, [
                 'class' => NAEMAS::class,
                'choice_label' => 'getCodeLibelle',
                'attr'=>array('class'=>'form-control form-control-sm select2  syscoa', "style"=>"width:100%;"),
                'required'=>false,

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
