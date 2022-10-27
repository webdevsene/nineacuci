<?php

namespace App\Form;

use App\Entity\NiActiviteEconomique;
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


            ->add('ninCapital',TextType::class,
                    array('label'=>'Capital ',
                            'required'=>false,
                            'attr'=>array('class'=> 'form-control  form-control-sm input-mask mt-2',
                                    'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" ,
                            )
                        ) 
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

      
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NiActiviteEconomique::class,
        ]);
    }
}