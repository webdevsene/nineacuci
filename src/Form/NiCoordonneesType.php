<?php

namespace App\Form;

use App\Entity\NiCoordonnees;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\NiTypevoie;




class NiCoordonneesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ninnumVoie',TextType::class,
                array('label'=>'Numéro voie ',
            'required'=>false,
            'attr'=>array('class'=>'form-control  form-control-sm',
            'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');" 
                )))

            ->add('ninVoie',TextType::class,
            array('label'=>'Nom Voie ',
           'required'=>false,
           'attr'=>array('class'=>'form-control  form-control-sm'   )))

            ->add('ninadresse1', TextType::class,
            array('label'=>'Adresse du domicile ',
           'required'=>true,
           'attr'=>array('class'=>'form-control  form-control-sm',
          
                )))
            
            ->add('ninEmail',TextType::class,
                    array('label'=>'Email ',
                'required'=>false,
                'attr'=>array('class'=>'form-control  form-control-sm',
                )))

          
                ->add('ninUrl',TextType::class,
                        array('label'=>'Adresse site web :  ',
                       'required'=>false,
                       'attr'=>array('class'=>'form-control  form-control-sm',
                      
                            )))

                ->add('ninBP',TextType::class,
                array('label'=>'Boite postale :  ',
                'required'=>false,
                'attr'=>array('class'=>'form-control  form-control-sm',
                
                    )))
                  
              
            ->add('ninTelephon1',TextType::class,
                    array('label'=>'Téléphone portable :  ',
                'required'=>true,
                'attr'=>array('class'=>'form-control  form-control-sm',
                'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');" 
                )))

                ->add('nintelephon2',TextType::class,
                    array('label'=>'Téléphone fixe :  ',
                'required'=>true,
                'attr'=>array('class'=>'form-control  form-control-sm',
                'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');" 
                )))

            ->add('ninadresse1', TextType::class,
                    array('label'=>'Adresse domicile :  ',
                'required'=>true,
                'attr'=>array('class'=>'form-control  form-control-sm',
                )))

            ->add('ninTypeVoie', EntityType::class, [
              'class' => NiTypevoie::class,
              'placeholder'=>'Sélectionner ......',
              'choice_label' => 'tyvlibelle',
              'attr'=>array('class'=>'form-control  form-control-sm'),
              'required'=>true,
               'label'=>'Type voie '
        ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NiCoordonnees::class,
        ]);
    }
}
