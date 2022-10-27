<?php

namespace App\Form;

use App\Entity\SuiviMaterielMobilier;
use App\Entity\SuiviMaterielMobilierUtilSmt;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SuiviMaterielMobilierUtilSmtType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('suiviMaterielMobiliers',CollectionType::class,[
            'entry_type' => SuiviMaterielMobilierType::class,
            'label'=>' ',
            'allow_add'=> true,
            'allow_delete'=>true,
            'by_reference'=>false,
            'delete_empty' => function (SuiviMaterielMobilier $suiviMaterielMobiliers = null) {
                       return null === $suiviMaterielMobiliers || empty($suiviMaterielMobiliers->getDesignation());
            },
            'attr' => array('class' => 'form-control form-control-ms','style' => 'border:#ced4da;'),

       ])
       

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SuiviMaterielMobilierUtilSmt::class,
        ]);
    }
}
