<?php

namespace App\Form;

use App\Entity\Effectifs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EffectifsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('rank')
            ->add('uploadedFileName')
            ->add('units', ChoiceType::class, array(
                'choices'=>[
                   'Selectionner...'=>'',
                   'CFA' => 'CFA',
                   'MILLIER DE CFA' => 'Millier de CFA',
                ],
                'required'=>false,
                'attr'=>array('class'=>'form-control form-control-sm')
            ))
            ->add('submit')
            ->add('totalEf')
            ->add('totalMs')
            ->add('qualification')
            ->add('category')
            ->add('anneeFinanciere')
            ->add('facm')
            ->add('facf')
            ->add('hmfef')
            ->add('hmmef')
            ->add('mhmfef')
            ->add('mhmmef')
            ->add('mnfef')
            ->add('mnmef')
            ->add('mumfef')
            ->add('mummef')
            ->add('nfef')
            ->add('nmef')
            ->add('umfef')
            ->add('ummef')
            ->add('createdBy')
            ->add('updatedBy')
            ->add('repertoire')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Effectifs::class,
        ]);
    }
}
