<?php

namespace App\Form;

use App\Entity\FormeJuridique;

use App\Entity\NiAdministration;
use App\Entity\NiAgenceCSS;
use App\Entity\NiCentreFiscal;
use App\Entity\NiCivilite;
use App\Entity\NiControle;
use App\Entity\NiDirigeant;
use App\Entity\NiFormejuridique;
use App\Entity\NiFormePersonnemorale;
use App\Entity\NiFormeunite;
use App\Entity\NiLocaliteDGID;
use App\Entity\NiLocaliteDPS;
use App\Entity\NiModaliteExploitation;
use App\Entity\NiModeoccupation;

use App\Entity\NiNationalite;
use App\Entity\Activities;
use App\Entity\NiActivite;
use App\Entity\NiNatureLocaliteExploitation;
use App\Entity\NiNineaproposition;
use App\Entity\NiPatente;
use App\Entity\NiPerception;
use App\Entity\NiPersonne;
use App\Entity\NiSexe;
use App\Entity\NiStatut;
use App\Entity\NiTypevoie;
use App\Entity\NiTypepersone;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;


class NiNineapropositionAncienNINEAType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

         

              ->add('ninNinea',  TextType::class, [
                'label'=>"NINEA ",
                'required'=>true,
                'attr'=>array('class'=>'form-control  form-control-sm ',
                            'oninput'=>"this.value = this.value.replace(/[^0-9]/g, '');"
                         )
                ])

             
  
          ->add('ninStatut', EntityType::class, [
            'class' => NiStatut::class,
            'placeholder'=>'Sélectionner ...',
            'choice_label' => 'statLibelle',
            'attr'=>array('class'=>'form-control  form-control-sm classselect  me-auto',
                   ),
            'required'=>true,
             'label'=>'Statut ',
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
