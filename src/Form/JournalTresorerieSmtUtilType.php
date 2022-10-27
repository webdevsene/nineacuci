<?php

namespace App\Form;

use App\Entity\JournalTresorerie;
use App\Entity\JournalTresorerieSmtUtil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JournalTresorerieSmtUtilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('journalTresoreries',CollectionType::class,[
            'entry_type' => JournalTresorerieType::class,
            'label'=>' ',
            'allow_add'=> true,
            'allow_delete'=>true,
            'by_reference'=>false,
            'delete_empty' => function (JournalTresorerie $journalTresorerieSmts = null) {
                    return null === $journalTresorerieSmts || empty($journalTresorerieSmts->getLibelle());
            },
            'attr' => array('class' => 'form-control form-control-ms','style' => 'border:#ced4da;'),

        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => JournalTresorerieSmtUtil::class,
        ]);
    }
}
