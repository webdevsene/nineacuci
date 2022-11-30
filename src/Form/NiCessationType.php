<?php

namespace App\Form;

use App\Entity\NiCessation;
use App\Entity\NINinea;
use App\Entity\NiTypeConsequence;
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


class NiCessationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('motif', ChoiceType::class, [
                'label'=>'Motif de suspension',

                 'choices'  => [
                     'Sélectionner...' =>  '',
                     'Maladie' =>  'Maladie',
                     'Sinistre' => 'Sinistre' ,
                     'Vente' => 'Vente' ,
                     'Location gérance' => 'Location gérance' ,
                     'Décès' => 'Décès' ,
                     'Autres' => 'Autres' 
                    
                 ],
                  'required'=>true,
             'attr'=>array('class'=>'form-control form-control-sm')
             ])
             
             ->add('description',TextareaType::class,
             array('label'=>'Description ',
             'required'=>true,
             
             'attr'=>array('class'=>'form-control form-control-sm')) )

             ->add('consequences', ChoiceType::class, [
                 'label'=>'Conséquence sur les établissements secondaires ',
 
                  'choices'  => [
                      'Sélectionner...' =>  '',
                      'Vente' =>  'Vente',
                      'Location gérance' => 'Location gérance' ,
                      'Cessation définitive' => 'Cessation définitive' ,
                      'Autre à préciser' => 'Autre à préciser' ,
                     
                  ],
                   'required'=>true,
                   'empty_data'=> 9,
                   'mapped' => false,
                    'attr'=>array('class'=>'form-control form-control-sm')
              ])


            ->add('dateCessation', DateType::class, ['label'=>'Date cessation',
                    'attr'=>array('class'=>'form-control form-control-sm'),
                    'required'=>false,
                    
                    'widget' => 'single_text'])

            ->add('denominationBeneficiaire', TextType::class, [
                'label'=>'Nom Prénom',
                'attr'=>array('class'=>'form-control form-control-sm')
            ])

                                
            ->add('adresseBeneficiaire', TextType::class, [
                'label'=>'Adresse',
                'attr'=>array('class'=>'form-control form-control-sm')
            ])

                                
            ->add('rccmBeneficiaire', TextType::class, [
                'label'=>'Numéro document',
                'attr'=>array('class'=>'form-control form-control-sm')
            ])

                                
            /*->add('ninConsequences', EntityType::class, [
                        'class'=>NiTypeConsequence::class,
                        'expanded' => false,
                'multiple' => false,
                'placeholder'=>'Sélectionner.......',
                'choice_label' => 'libelle',
                'attr'=>array('class'=>' select2 form-select'),
                'required'=>true,
                'label'=>'Conséquence sur les établissements secondaires ' 
            ])*/                        

            
           

            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NiCessation::class,
        ]);
    }
}
