<?php

namespace App\Form;

use App\Entity\Repertoire;
use App\Entity\Region;
use App\Entity\Departement;
use App\Entity\CAV;
use App\Entity\CACR;
use App\Entity\Control;
use App\Entity\Citi;
use App\Entity\Pays;
use App\Entity\NAEMAS;
use App\Entity\NAEMA;
use App\Entity\CategoryNaema;
use App\Entity\SYSCOA;
use App\Entity\RegimeFiscal;
use App\Entity\FormeJuridique;
use App\Entity\CategorySyscoa;



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RepertoireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $syscoa=$options["syscoa"];
        $naema=$options["naema"];
        $naemas=$options["naemas"];
        $citi=$options["citi"];
        $builder
            ->add('sigle',TextType::class,
                   array('label'=>'Sigle ',
                          'required'=>false,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))

            ->add('codeCuci',TextType::class,
                   array('label'=>'Numéro de CUCI ',
                          'required'=>false,
                          'disabled'=>true,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))

            

            


            ->add('dateReception', DateType::class, ['label'=>'Date de réception de la DSF',
                'attr'=>array('class'=>'form-control form-control-sm'),
                'required'=>false,
                'widget' => 'single_text'])
              


              ->add('statut', ChoiceType::class, [
                 'label'=>'Statut ',
                  'choices'  => [
                     
                      'Actif' => 1,
                      'Inactif' => 0
                  ],
                   'required'=>true,
              'attr'=>array('class'=>'form-control form-control-sm')
              ])

              ->add('reactivation', ChoiceType::class, [
                 'label'=>'Réactivation ',
                  'choices'  => [
                     
                      'Non concerné' => 1,
                      'Concerné' => 0
                  ],
                   'required'=>true,
              'attr'=>array('class'=>'form-control form-control-sm')
              ])


              ->add('dateMiseAjour', DateType::class, ['label'=>'Date de mise à jour',
                'attr'=>array('class'=>'form-control form-control-sm'),
                'required'=>false,
                'widget' => 'single_text'])

           ->add('observation',TextareaType::class,
                   array('label'=>'Observation ',
                          'required'=>false,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))
            


             ->add('systeme', ChoiceType::class, [
                 'label'=>'Systeme de comptabilité ',
                  'choices'  => [
                      '' => "choissir...",
                      'Teste' => "Teste"
                  ],
                   'required'=>true,
              'attr'=>array('class'=>'form-control form-control-sm')
              ])


            ->add('formeJuridique', EntityType::class, [
                 'class' => FormeJuridique::class,
                'choice_label' => 'libelle',
                'attr'=>array('class'=>'form-control form-control-sm syscoa', "style"=>"width:100%;"),
                'required'=>false,

               ])


             ->add('regimeFiscal', EntityType::class, [
                 'class' => RegimeFiscal::class,
                'choice_label' => 'libelle',
                'attr'=>array('class'=>'form-control form-control-sm syscoa', "style"=>"width:100%;"),
                'required'=>false,

               ])

             ->add('paysDuEntreprise', EntityType::class, [
                 'class' => Pays::class,
                'choice_label' => 'libelle',
                'attr'=>array('class'=>'form-control form-control-sm syscoa', "style"=>"width:100%;"),
               
                'required'=>false,
                'label'=>'Pays du siége de l\'entreprise ',

               ])

             


              ->add('etablissementsDansPays',IntegerType::class,
                   array('label'=>'Nombre d\'établissements dans le pays:',
                          'required'=>false,
                          'attr'=>array('class'=>'form-control')              
            ))


             ->add('etablissementsHorsPays',IntegerType::class,
                   array('label'=>'Nombre d\'établissements hors du pays:',
                          'required'=>false,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))


              ->add('premiereAnneeExercice',IntegerType::class,
                   array('label'=>'Premiére année d\'éxercice',
                          'required'=>false,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))


            ->add('controle', EntityType::class, [
                 'class' => Control::class,
                'choice_label' => 'libelle',
                'attr'=>array('class'=>'form-control form-control-sm syscoa', "style"=>"width:100%;"),
               
                'required'=>false,
                'label'=>'Controle ',

               ])


           


            ->add('activitePrincipale',TextareaType::class,
                   array('label'=>'Libellé ',

                          'required'=>false,
                          'attr'=>array('class'=>'form-control form-control-sm',
                           'style' => 'width:100%;'),             
            ))












            

            ->add('denominationSocial',TextType::class,
                   array('label'=>'Dénomination sociale ',
                          'required'=>false,
                          'attr'=>array('class'=>'form-control form-control-sm input-sm')              
            ))


            ->add('ninea',IntegerType::class,
                   array('label'=>'NINEA/NINET ',
                          'required'=>false,
                          'attr'=>array('class'=>'form-control form-control-sm','min' => 1)              
            ))


           ->add('NomDuContact',TextType::class,
                   array('label'=>'Nom ',
                          'required'=>false,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))

            ->add('prenomDuContact',TextType::class,
                   array('label'=>'Prénom ',
                          'required'=>false,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))

           ->add('addresseDuContact',TextType::class,
                   array('label'=>'addresse ',
                          'required'=>false,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))


           ->add('fonctionDuContact',TextType::class,
                   array('label'=>'Fonction/Qualité ',
                          'required'=>false,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))

            ->add('NomDuCabinet',TextType::class,
                   array('label'=>'Nom du cabinet ',
                          'required'=>false,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))


            ->add('addresseDuCabinet',TextType::class,
                   array('label'=>'Fonction/Qualité ',
                          'required'=>false,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))


          ->add('prenomDuExpert',TextType::class,
                   array('label'=>'Prénom ',
                          'required'=>false,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))


           ->add('nomDuExpert',TextType::class,
                   array('label'=>'Nom ',
                          'required'=>false,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))



            ->add('telephoneDuCabinet',TextType::class,
                   array('label'=>'Tél',
                          'required'=>false,
                          'attr'=>array('class'=>'form-control form-control-sm',
                       "visibility" => 'hidden')              
            ))



            ->add('addresseComplete',TextType::class,
                   array('label'=>'Addresse complete',
                          'required'=>false,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))

            ->add('dureeDeExercice',IntegerType::class,
                   array('label'=>'Durée de l\'excercice(mois)',
                          'required'=>false,
                          'attr'=>array('class'=>'form-control form-control-sm','min' => 1)              
            ))

            ->add('clotureDeExercice', DateType::class, ['label'=>'Date de clôture de l\'excercice',
                'attr'=>array('class'=>'form-control form-control-sm'),
                'required'=>false,
                'widget' => 'single_text'])

            ->add('debutExerciceComptable', DateType::class, ['label'=>'Date de debut l\'excercice comptable:',
                'attr'=>array('class'=>'form-control form-control-sm'),
                'required'=>false,
                'widget' => 'single_text'])



            ->add('finExerciceComptable', DateType::class, ['label'=>'Date de fin de l\'excercice comptable:',
                'attr'=>array('class'=>'form-control form-control-sm'),
                'required'=>false,
                'widget' => 'single_text'])



            ->add('dateArreteEffectif', DateType::class, ['label'=>'Date d\'arret effectif des comptes:',
                'attr'=>array('class'=>'form-control form-control-sm'),
                'required'=>false,
                'widget' => 'single_text'])



            ->add('clotureExercicePrecedent', DateType::class, ['label'=>'Date clôture de l\'excercice précédent:',
                'attr'=>array('class'=>'form-control form-control-sm'),
                'required'=>false,
                'widget' => 'single_text'])


            


            ->add('enseigne',TextType::class,
                   array('label'=>'Enseigne ',
                          'required'=>false,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))


            ->add('dureeExercicePrecedent',IntegerType::class,
                   array('label'=>'Durée de l\'excercice précédent(mois):',
                          'required'=>false,
                          'attr'=>array('class'=>'form-control form-control-sm','min' => 1)              
            ))


            ->add('numeroRegistreCommerce',TextType::class,
                   array('label'=>'Numéro de registre de commerce: ',
                          'required'=>false,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))



            ->add('numeroCaisseSociale',TextType::class,
                   array('label'=>'Numéro de caisse sociale ',
                          'required'=>false,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))

            ->add('codeImportateur',TextType::class,
                   array('label'=>'Numéro de code importateur ',
                          'required'=>false,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))


            ->add('telephone1',TextType::class,
                   array('label'=>'Téléphone 1 ',
                          'required'=>false,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))

          ->add('telephone2',TextType::class,
                   array('label'=>'Téléphone 2 ',
                          'required'=>false,
                          'attr'=>array('class'=>'form-control form-control-sm'))
               )

           ->add('numeroTelecopie',TextType::class,
                   array('label'=>'Numéro de télécopie(fax) ',
                          'required'=>false,

                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))

           ->add('boitePostale',TextType::class,
                   array('label'=>'Boite postale',
                          'required'=>false,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))
            ->add('addresseDuCabinet',TextType::class,
                   array('label'=>'Addresse ',
                          'required'=>false,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))

            
            

             ->add('email',TextType::class,
                   array('label'=>'Addresse email',
                          'required'=>false,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))

            ->add('typeNINEA',EntityType::class,array(

                'placeholder'=>'Sélectionner.......',
                'class'=>'App:TypeNINEA',
                'choice_label'=>'libelle',
                'attr'=>array('class'=>'form-control form-control-sm '),
                'required'=>false,
                'label'=>"Type"


            ))
            ->add('commissairesComptes',CollectionType::class,[
                 'entry_type' => CommissairesComptesType::class,
                 'label'=>' ',
                 'allow_add'=> true,
                 'allow_delete'=>true,
                 'by_reference'=>false

            ])

          /*  ->add('activities',CollectionType::class,[
                 'entry_type' => ActivitiesType::class,
                 'label'=>' ',
                 'allow_add'=> true,
                 'allow_delete'=>true,
                 'by_reference'=>false

            ])*/


             ->add('dirigeants',CollectionType::class,[
                 'entry_type' => DirigeantType::class,
                 'label'=>' ',
                 'allow_add'=> true,
                 'allow_delete'=>true,
                 'by_reference'=>false

            ])

             ->add('actionnaires',CollectionType::class,[
                 'entry_type' => ActionnaireType::class,
                 'label'=>' ',
                 'allow_add'=> true,
                 'allow_delete'=>true,
                 'by_reference'=>false

            ])

            ->add('membreConseils',CollectionType::class,[
                 'entry_type' => MembreConseilType::class,
                 'label'=>' ',
                 'allow_add'=> true,
                 'allow_delete'=>true,
                 'by_reference'=>false

            ])


            ->add('filiales',CollectionType::class,[
                 'entry_type' => FilialesType::class,
                 'label'=>' ',
                 'allow_add'=> true,
                 'allow_delete'=>true,
                 'by_reference'=>false

            ])
            
        ;



    



       



    


     
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired(['syscoa','naema','naemas','citi']);
        
        $resolver->setDefaults([
            'data_class' => Repertoire::class,
        ]);
    }
}
