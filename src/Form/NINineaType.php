<?php

namespace App\Form;

use App\Entity\NiActivite;
use App\Entity\NINinea;
use App\Entity\NiNineaproposition;
use App\Entity\NiStatut;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class NINineaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        ->add('ninEnseigne',  TextType::class, [
            'label'=>"Enseigne ",
            'required'=>false,
            'attr'=>array('class'=>'form-control  form-control-sm ')
            ])

            ->add('ninRegcom',  TextType::class, [
              'label'=>"Registre de commerce ",
              'required'=>true,
              'attr'=>array('class'=>'form-control  form-control-sm ')
              ])

              ->add('ninNinea',  TextType::class, [
                'label'=>"NINEA 2 ",
                'required'=>true,
                'attr'=>array('class'=>'form-control  form-control-sm ',
                                'oninput'=>"this.value = this.value.replace(/[^0-9]/g, '');"),
                ])
  
              ->add('ninDatreg', DateType::class, ['label'=>"Date du registre de commerce",
              'attr'=>array('class'=>'form-control  form-control-sm ')  ,
              'required'=>false,
                  'widget' => 'single_text'
              ])
  
              ->add('ninStatut', EntityType::class, [
                'class' => NiStatut::class,
                'placeholder'=>'Sélectionner ...',
                'choice_label' => 'statLibelle',
                'attr'=>array('class'=>'form-control  form-control-sm  me-auto',
                       ),
                'required'=>true,
                 'label'=>'Statut ',
              ])
         
          
          ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NiNineaproposition::class,
        ]);
    }
}
