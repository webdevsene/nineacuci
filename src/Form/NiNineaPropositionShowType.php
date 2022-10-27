<?php

namespace App\Form;

use App\Entity\FormeJuridique;
use App\Entity\NIActivite;
use App\Entity\NiCentreFiscal;
use App\Entity\NiCivilite;
use App\Entity\NiControle;
use App\Entity\NiDirigeant;
use App\Entity\NiFormePersonnemorale;
use App\Entity\NiLocaliteDGID;
use App\Entity\NiLocaliteDPS;
use App\Entity\NiModaliteExploitation;
use App\Entity\NiModeoccupation;
use App\Entity\NiNationalite;
use App\Entity\NiNatureLocaliteExploitation;
use App\Entity\NiNineaproposition;
use App\Entity\NiPatente;
use App\Entity\NiPerception;
use App\Entity\NiRegimeImposition;
use App\Entity\NiSexe;
use App\Entity\NiStatut;
use App\Entity\NiTypevoie;
use App\Entity\NiTypepersone;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class NiNineaPropositionShowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        ->add('ninmajdate', DateType::class, ['label'=>"Date de mise a jour",
        'attr'=>array('class'=>'form-control  form-control-sm ')  ,
        'required'=>false,
            'widget' => 'single_text'
        ])

          ->add('ninEnseigne',  TextType::class, [
            'label'=>"Enseigne ",
            'required'=>false,
            'attr'=>array('class'=>'form-control  form-control-sm ')
            ])

          ->add('ninStatut', EntityType::class, [
            'class' => NiStatut::class,
            'placeholder'=>'Sélectionner ......',
            'choice_label' => 'statLibelle',
            'attr'=>array('class'=>'form-control  form-control-sm'),
            'required'=>false,
             'label'=>'Statut ',
          ])


          ->add('ninDirigeants', CollectionType::class,[
            'entry_type' => NiDirigeantType::class,
            'label'=>' ',
            'allow_add'=> true,
            'allow_delete'=>true,
            'by_reference'=>false,
            'delete_empty' => function (NiDirigeant $ninDirigeant = null) {
                       return null === $ninDirigeant || empty($ninDirigeant->getNinPrenom());
                },

            ])


          ->add('ninActivites',CollectionType::class,[
               'entry_type' => NiActiviteType::class,
               'label'=>' ',
               'allow_add'=> true,
               'allow_delete'=>true,
               'by_reference'=>false,
               'delete_empty' => function (NIActivite $activites = null) {
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
