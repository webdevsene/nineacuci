<?php

namespace App\Form;

use App\Entity\NiActivite;
use App\Entity\NiNineaproposition;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NiActivite2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder


        ->add('ninActivites',CollectionType::class,[
            'entry_type' => NiActiviteType::class,
            'label'=>' ',
            'allow_add'=> true,
            'allow_delete'=>true,
            'by_reference'=>false,
            'delete_empty' => function (NiActivite $activites = null) {
                       return null === $activites || empty($activites->getNinAutact());
             },

       ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NiNineaproposition::class,
        ]);
    }
}
