<?php

namespace App\Form;

use App\Entity\Activities;
use App\Entity\SYSCOA;
use App\Entity\NAEMA;
use App\Entity\CategorySyscoa;
use App\Entity\NAEMAS;
use App\Entity\CITI;
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




class ActivitiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('chiffreAffaire',IntegerType::class,
                   array('label'=>'Chiffre d\'affaire  ',
                   'required'=>false,
                   
                   'attr'=>array('class'=>'form-control')))
            ->add('pourcentage',IntegerType::class,
                   array('label'=>'Pourcentage ',
                   'required'=>false,
                   'attr'=>array('class'=>'form-control')))
            ->add('valeurAjoutee',IntegerType::class,
                   array('label'=>'Valeur ajoutée ',
                   'required'=>false,
                   'attr'=>array('class'=>'form-control')))
            ->add('libelleActivitePrincipale',TextType::class,
                    array('label'=>'Libelle ',
                   'required'=>false,
                   'attr'=>array('class'=>'form-control')) )
            ->add('activitePrincipale',CheckboxType::class,
                    array('label'=>'Activite principale',
                          'required'=>false,   
                ))
            
           

            ->add('categorySyscoa', EntityType::class, [
                 'class' => CategorySyscoa::class,
                  'placeholder'=>'Sélectionner.......',
                'choice_label' => 'libelle',
                'attr'=>array('class'=>'form-control syscoa'),
                'required'=>false,
                'mapped'=>false,

            ])

             ->add('cITI', EntityType::class, [
                 'class' => CITI::class,
                'choice_label' => 'libelle',
                'attr'=>array('class'=>'form-control syscoa'),
                'required'=>false,

            ])

             ->add('nAEMA', EntityType::class, [
                 'class' => NAEMA::class,
                'choice_label' => 'libelle',
                'attr'=>array('class'=>'form-control syscoa'),
                'required'=>false,

            ])

            ->add('nAEMAS', EntityType::class, [
                 'class' => NAEMAS::class,
                'choice_label' => 'libelle',
                'attr'=>array('class'=>'form-control syscoa'),
                'required'=>false,

            ]);


    $formModifier = function (FormInterface $form, CategorySyscoa $categorysyscoa = null) {
            $syscoa = null === $categorysyscoa ? [] : $categorysyscoa->getSyscoa();

            $form->add('sYSCOA', EntityType::class, [
                 'class' => SYSCOA::class,
                'choice_label' => 'libelle',
                'attr'=>array('class'=>'form-control syscoa'),
                'required'=>false,
                'choices' => $syscoa,

            ]);
        };

       
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Activities::class,
        ]);
    }
}
