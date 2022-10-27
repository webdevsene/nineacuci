<?php

namespace App\Form;

use App\Entity\JournalCreancesImpayeesSmt;
use App\Entity\JournalDettesPayerSmt;
use App\Entity\JournalDettesPayerSmtUtil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JournalDettesPayerSmtUtilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('journalDettesPayerSmts',CollectionType::class,[
            'entry_type' => JournalDettesPayerSmtType::class,
            'label'=>' ',
            'allow_add'=> true,
            'allow_delete'=>true,
            'by_reference'=>false,
            'delete_empty' => function (JournalDettesPayerSmt $journalDettesPayerSmts = null) {
                    return null === $journalDettesPayerSmts || empty($journalDettesPayerSmts->getNom());
            },
            'attr' => array('class' => 'form-control form-control-ms','style' => 'border:#ced4da;'),

        ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => JournalDettesPayerSmtUtil::class,
        ]);
    }
}
