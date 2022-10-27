<?php

namespace App\Form;

use App\Entity\ProductionDeExercice;
use App\Entity\ProductionDeExerciceUtil;
use App\Entity\Repertoire;



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProductionDeExerciceUtilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
      
        $builder
            ->add('productionDeExercices',CollectionType::class,[
                 'entry_type' => ProductionDeExerciceType::class,
                 'label'=>' ',
                 'allow_add'=> true,
                 'allow_delete'=>true,
                 'by_reference'=>false,
                 'delete_empty' => function (ProductionDeExercice $productionDeExercices = null) {
                            return null === $productionDeExercices || empty($productionDeExercices->getLibelle());
                 },
                 'attr' => array('class' => 'form-control form-control-ms','style' => 'border:#ced4da;'),

            ])
            
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
       
        
        $resolver->setDefaults([
            'data_class' => ProductionDeExerciceUtil::class,
        ]);
    }
}
