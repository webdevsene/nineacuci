<?php

namespace App\Form;

use App\Entity\EtatDesStocksSmt;
use App\Entity\EtatDesStocksSmtUtil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtatDesStocksSmtUtilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('etatDesStocksSmts',CollectionType::class,[
                'entry_type' => EtatDesStocksSmtType::class,
                'label'=>' ',
                'allow_add'=> true,
                'allow_delete'=>true,
                'by_reference'=>false,
                'delete_empty' => function (EtatDesStocksSmt $etatDesStocksSmt = null) {
                        return null === $etatDesStocksSmt || empty($etatDesStocksSmt->getDesignation());
                },
                'attr' => array('class' => 'form-control form-control-ms','style' => 'border:#ced4da;'),

        ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EtatDesStocksSmtUtil::class,
        ]);
    }
}
