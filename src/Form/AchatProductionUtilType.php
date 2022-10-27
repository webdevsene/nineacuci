<?php

namespace App\Form;

use App\Entity\AchatProduction;
use App\Entity\AchatProductionUtil;
use App\Entity\Repertoire;



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AchatProductionUtilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
      
        $builder
            ->add('achatProduction',CollectionType::class,[
                 'entry_type' => AchatProductionType::class,
                 'label'=>' ',
                 'allow_add'=> true,
                 'allow_delete'=>true,
                 'by_reference'=>false,
                 'delete_empty' => function (AchatProduction $achatProduction = null) {
                            return null === $achatProduction || empty($achatProduction->getLibelle());
                 },

            ])
            
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
       
        
        $resolver->setDefaults([
            'data_class' => AchatProductionUtil::class,
        ]);
    }
}
