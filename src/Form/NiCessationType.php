<?php

namespace App\Form;

use App\Entity\NiCessation;
use App\Entity\NINinea;
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
                'label'=>'Motif ',
                 'choices'  => [
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
            
                'attr'=>array('class'=>'form-control')) )

            ->add('dateCessation', DateType::class, ['label'=>'Date cessation',
                      'attr'=>array('class'=>'form-control form-control-sm'),
                      'required'=>false,
                    
                    'widget' => 'single_text'])

            
           

            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NiCessation::class,
        ]);
    }
}
