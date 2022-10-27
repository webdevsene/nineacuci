<?php

namespace App\Form;

use App\Entity\NiActivite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

use App\Entity\CAV;
use App\Entity\CACR;
use App\Entity\Control;
use App\Entity\Qualite;
use App\Entity\Citi;
use App\Entity\SystemeComptabilite;
use App\Entity\Pays;
use App\Entity\NAEMAS;
use App\Entity\NAEMA;
use App\Entity\CategoryNaema;
use App\Entity\SYSCOA;
use App\Entity\RegimeFiscal;
use App\Entity\FormeJuridique;
use App\Entity\CategorySyscoa;


class NiActiviteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

      

        ->add('statActivprincipale',CheckboxType::class,
                array(
            'required'=>false,
            )
            ) 


            ->add('ninAutact',TextType::class,
                    array('label'=>'Libelle ',
                   'required'=>true,
                   'attr'=>array('class'=>'form-control  form-control-sm')) )


             ->add('refNaema', EntityType::class, [
                 'class' => NAEMA::class,
                 'placeholder'=>'Sélectionner ......',
                'choice_label' => 'getCodeLibelle',
                'attr'=>array('class'=>'form-control form-control-sm  activiteliste ',
                                'style' => 'width:60% ;'),
                'required'=>true,

            ])

           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NiActivite::class,
        ]);
    }
}