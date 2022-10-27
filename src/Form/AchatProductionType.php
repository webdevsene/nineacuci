<?php

namespace App\Form;

use App\Entity\AchatProduction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AchatProductionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, array('label'=>'',
            'required'=>false,
            'attr'=>array('class'=>'form-control form-control-sm calcul libelle')))

            ->add('qtyProduitDansEtat', TextType::class, array('label'=>'',
            'required'=>false,
            'attr'=>array('class'=>'form-control form-control-sm calcul',
                          'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');", 'id'=>'')))

            ->add('qtyAcheteeDansEtat', TextType::class, array('label'=>'',
            'required'=>false,
            'attr'=>array('class'=>'form-control form-control-sm calcul',
                          'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")))
            
            ->add('qtyAcheteeHorsPays', TextType::class, array('label'=>'',
            'required'=>false,
            'attr'=>array('class'=>'form-control form-control-sm calcul',
                          'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")))
            
            ->add('valProduitDansEtat', TextType::class, array('label'=>'',
            'required'=>false,
            'attr'=>array('class'=>'form-control form-control-sm calcul',
                          'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")))
            
            ->add('valAcheteeDansPays', TextType::class, array('label'=>'',
            'required'=>false,
            'attr'=>array('class'=>'form-control form-control-sm calcul',
                          'oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")))
            
            ->add('valAcheteeHorsPays', TextType::class, array('label'=>'',
            'required'=>false,
            'attr'=>array('class'=>'form-control form-control-sm calcul','oninput'=>"this.value = this.value.replace(/[^0-9,]/g, '');")))

            ->add('variationDesStocks', TextType::class, array('label'=>'',
            'required'=>false,
            'attr'=>array('class'=>'form-control form-control-sm calcul',
                            'oninput'=>"this.value = this.value.replace(/[^0-9,-]/g, '');")))

            ->add('unites', ChoiceType::class, array(
                'choices'=>[
                   'Selectionner...' => '',
                   'TONNES' => 'Tonnes',
                   'LITRES' => 'Litres',
                   'METRECUBE' => 'Mètre cube',
                   'KILOGRAMME' => 'Kilogrammee',
                   'ONCE' => 'Once',
                   'PIECE' => 'Pièce',
                   'ROULEAU' => 'Rouleau',
                   'ROULEAUX' => 'Rouleaux',
                   'KW' => 'Kilowatt',
                   'CRTDZ' => 'CRT/DZ',
                   'ARTICLE' => 'Article',
                ],
                'attr'=>array('class'=>'form-control-sm calcul select2')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AchatProduction::class,
        ]);
    }
}
