<?php

namespace App\Form;

use App\Entity\NiActiviteEconomique;
use App\Entity\NiModaliteexploitation;
use App\Entity\NiNatureLocaliteExploitation;
use App\Entity\NiSourcefinancement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NiActiviteEconomiqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

           
            ->add('ninAnneeCa',TextType::class,
                array('label'=>"Année du chiffres d'affaires ",
                
                'attr'=>array('class'=>'form-control  form-control-sm input-mask',
                'data-inputmask'=>"'mask': '9999'"
                        ))
                )
           

            ->add('ninEffect1',TextType::class,
                    array('label'=>'Effectif temporaire ',
                   'required'=>false,
                   'attr'=>array('class'=> 'form-control  form-control-sm input-mask mt-2', 
                   'oninput'=>"this.value = this.value.replace(/[^0-9]/g, '');" ,
                    'maxlength' => '7',
                    )) )

             ->add('ninEffectifFem',TextType::class,
                   array('label'=>'Effectif permanent féminin ',
                  'required'=>false,
                  'attr'=>array('class'=> 'form-control  form-control-sm input-mask mt-2' ,
                  'oninput'=>"this.value = this.value.replace(/[^0-9]/g, '');",
                    'maxlength' => '7',
                     )) )

            ->add('ninEffectifFemSAIS',TextType::class,
                  array('label'=>'Effectif temporaire féminin ',
                 'required'=>false,
                 'attr'=>array('class'=> 'form-control  form-control-sm input-mask mt-2',
                 'oninput'=>"this.value = this.value.replace(/[^0-9]/g, '');" ,
                    'maxlength' => '7',
                    )) )

            ->add('ninEffectif',TextType::class,
                  array('label'=>'Effectif permanent ',
                 'required'=>false,
                 'attr'=>array('class'=> 'form-control  form-control-sm input-mask mt-2', 
                 'oninput'=>"this.value = this.value.replace(/[^0-9]/g, '');",
                    'maxlength' => '7'
                )) )


                ->add('ninOcc', EntityType::class, [
                    'class' => NiSourcefinancement::class,
                    'placeholder'=>'Sélectionner ...',
                    'choice_label' => 'libelle',
                    'attr'=>array('class'=>'form-control  form-control-sm mt-2 '),
                    'required'=>false,
                    'label'=>'Source de financement ',
                ])

                
                ->add('ninNature', EntityType::class, [
                    'class' => NiNatureLocaliteExploitation::class,
                    'placeholder'=>'Sélectionner ...',
                    'choice_label' => 'nleLibelle',
                    'attr'=>array('class'=>'form-control  form-control-sm mt-2 '),
                    'required'=>false,
                    'label'=>'Nature d\'exploitation ',
                ])

                ->add('ninMode', EntityType::class, [
                    'class' => NiModaliteexploitation::class,
                    'placeholder'=>'Sélectionner ...',
                    'choice_label' => 'libelle',
                    'attr'=>array('class'=>'form-control  form-control-sm mt-2 '),
                    'required'=>false,
                    'label'=>'Modalité ',
                ])
    
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NiActiviteEconomique::class,
        ]);
    }
}