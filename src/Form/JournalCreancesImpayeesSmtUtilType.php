<?php

namespace App\Form;

use App\Entity\JournalCreancesImpayeesSmt;
use App\Entity\JournalCreancesImpayeesSmtUtil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JournalCreancesImpayeesSmtUtilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('journalCreancesImpayeesSmts',CollectionType::class,[
            'entry_type' => JournalCreancesImpayeesSmtType::class,
            'label'=>' ',
            'allow_add'=> true,
            'allow_delete'=>true,
            'by_reference'=>false,
            'delete_empty' => function (JournalCreancesImpayeesSmt $journalCreancesImpayeesSmts = null) {
                    return null === $journalCreancesImpayeesSmts || empty($journalCreancesImpayeesSmts->getNom());
            },
            'attr' => array('class' => 'form-control form-control-ms','style' => 'border:#ced4da;'),

        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => JournalCreancesImpayeesSmtUtil::class,
        ]);
    }
}
