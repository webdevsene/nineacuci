<?php

namespace App\Form;

use App\Entity\ProductionDeExercice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductionDeExerciceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('libelle', TextType::class, 
                array('label'=>'',
                'attr'=>array('class'=>'form-control form-control-sm calcul libelle')))

            ->add('unites', ChoiceType::class, array(
                'choices'=>[
                   'Selectionner...' => '',
                   'TONNES' => 'Tonnes',
                   'LITRES' => 'Litres',
                   'METRE CUBE' => 'Mètre cube',
                   'KILOGRAMME' => 'Kilogrammee',
                   'ONCE' => 'Once',
                   'PIECE' => 'Pièce',
                   'ROULEAU' => 'Rouleau',
                   'ROULEAUX' => 'Rouleaux',
                   'KW' => 'Kilowatt',
                   'CRTDZ' => 'CRT/DZ',
                   'ARTICLE' => 'Article',
                ],
                'attr'=>array('class'=>'form-control-sm calcul-unite select2')
            ))

            ->add('qtyProdVenduDansEtat', TextType::class, 
                    array('label'=>'',
                    'required'=>false,
                    'attr'=>array('class'=>'form-control form-control-sm calcul',
                                  'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")
                                ))

            ->add('valProdVenduDansEtat', TextType::class, 
                    array('label'=>'',
                    'required'=>false,
                    'attr'=>array('class'=>'form-control form-control-sm calcul',
                                  'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")
                                ))

            ->add('qtyProdVenduDansUemoa', TextType::class, 
                    array('label'=>'',
                    'required'=>false,
                    'attr'=>array('class'=>'form-control form-control-sm calcul',
                                  'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")
                                ))

            ->add('valProdVenduDansUemoa', TextType::class, 
                    array('label'=>'',
                    'required'=>false,
                    'attr'=>array('class'=>'form-control form-control-sm calcul',
                                  'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")
                                ))

            ->add('qtyProdVenduHorsUemoa', TextType::class, 
                    array('label'=>'',
                    'required'=>false,
                    'attr'=>array('class'=>'form-control form-control-sm calcul',
                                  'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")
                                ))

            ->add('valProdVenduHorsUemoa', TextType::class, 
                    array('label'=>'',
                    'required'=>false,
                    'attr'=>array('class'=>'form-control form-control-sm calcul',
                                  'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")
                                ))

            ->add('qtyProdImmobilisee', TextType::class, 
                    array('label'=>'',
                    'required'=>false,
                    'attr'=>array('class'=>'form-control form-control-sm calcul',
                                  'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")
                                ))

            ->add('valProdImmobilisee', TextType::class, 
                    array('label'=>'',
                    'required'=>false,
                    'attr'=>array('class'=>'form-control form-control-sm calcul',
                                  'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")
                                ))

            ->add('qtyStkOuverture', TextType::class, 
                    array('label'=>'',
                    'required'=>false,
                    'attr'=>array('class'=>'form-control form-control-sm calcul',
                                  'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")
                                ))

            ->add('valStkOuverture', TextType::class, 
                    array('label'=>'',
                    'required'=>false,
                    'attr'=>array('class'=>'form-control form-control-sm calcul',
                                  'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")
                                ))

            ->add('qtyStkCloture', TextType::class, 
                    array('label'=>'',
                    'required'=>false,
                    'attr'=>array('class'=>'form-control form-control-sm calcul',
                                  'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")
                                ))

            ->add('valStkCloture', TextType::class, 
                    array('label'=>'',
                    'required'=>false,
                    'attr'=>array('class'=>'form-control form-control-sm calcul',
                                  'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")
                                ))

        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProductionDeExercice::class,
        ]);
    }
}
