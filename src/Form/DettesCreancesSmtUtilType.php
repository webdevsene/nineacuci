<?php

namespace App\Form;

use App\Entity\DettesCreancesSmt;
use App\Entity\DettesCreancesSmtUtil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DettesCreancesSmtUtilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('dettesCreancesSmts',CollectionType::class,[
            'entry_type' => DettesCreancesSmtType::class,
            'label'=>' ',
            'allow_add'=> true,
            'allow_delete'=>true,
            'by_reference'=>false,
            'delete_empty' => function (DettesCreancesSmt $dettesCreancesSmts = null) {
                    return null === $dettesCreancesSmts || empty($dettesCreancesSmts->getNom());
            },
            'attr' => array('class' => 'form-control form-control-ms','style' => 'border:#ced4da;'),

        ])

    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DettesCreancesSmtUtil::class,
        ]);
    }
}
