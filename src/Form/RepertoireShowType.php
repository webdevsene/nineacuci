<?php

namespace App\Form;

use App\Entity\Repertoire;
use App\Entity\Region;
use App\Entity\Departement;
use App\Entity\CAV;
use App\Entity\CACR;
use App\Entity\Control;
use App\Entity\Qualite;
use App\Entity\Citi;
use App\Entity\Pays;
use App\Entity\NAEMAS;
use App\Entity\NAEMA;
use App\Entity\SystemeComptabilite;
use App\Entity\CategoryNaema;
use App\Entity\SYSCOA;
use App\Entity\RegimeFiscal;
use App\Entity\FormeJuridique;
use App\Entity\CategorySyscoa;
use App\Entity\CommissairesComptes;
use App\Entity\Dirigeant;
use App\Entity\Activities;
use App\Entity\MembreConseil;
use App\Entity\Actionnaire;
use App\Entity\Filiales;
use App\Entity\TypeNINEA;
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

class RepertoireShowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
      
        $builder
            ->add('sigle',TextType::class,
                   array('label'=>'Sigle ',
                          'required'=>false,
                          'disabled'=>true,
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
                'disabled'=>true,
                'widget' => 'single_text'])
              


              ->add('statut', ChoiceType::class, [
                 'label'=>'Statut ',
                  'choices'  => [
                     
                      'Actif' => 1,
                      'Inactif' => 0
                  ],
                   'required'=>true,
                   'disabled'=>true,
              'attr'=>array('class'=>'form-control form-control-sm')
              ])

              ->add('reactivation', ChoiceType::class, [
                 'label'=>'Réactivation ',
                  'choices'  => [
                     
                      'Non concerné' => 1,
                      'Concerné' => 0
                  ],
                   'required'=>true,
                   'disabled'=>true,
              'attr'=>array('class'=>'form-control form-control-sm')
              ])
              

              ->add('dateCessation', DateType::class, ['label'=>'Date de cessation',
                'attr'=>array('class'=>'form-control form-control-sm'),
                'required'=>false,
                'disabled'=>true,
                'widget' => 'single_text'])

              ->add('raisonCessation', ChoiceType::class, [
                 'label'=>'Raison de Cessation ',
                  'choices'  => [
                     
                      'Choissir' => "",
                      'Cessation' => 1,
                      'Fusion' => 2,
                      'Absorption' => 3,
                      'Scission' => 4
                  ],
                   'required'=>false,
                   'disabled'=>true,
              'attr'=>array('class'=>'form-control form-control-sm')
              ])


              ->add('dateMiseAjour', DateType::class, ['label'=>'Date de mise à jour',
                'attr'=>array('class'=>'form-control form-control-sm'),
                'required'=>false,
                'disabled'=>true,
                'widget' => 'single_text'])

           ->add('observation',TextareaType::class,
                   array('label'=>'Observation ',
                          'required'=>false,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))
            


             ->add('systemeComptabilite', EntityType::class, [
                 'class' => SystemeComptabilite::class,
                'choice_label' => 'libelle',
                'attr'=>array('class'=>'form-control form-control-sm syscoa', "style"=>"width:100%;"),
               
                'required'=>false,
                'disabled'=>true,
              
                'label'=>'Systeme de comptabilité ',

               ])


            ->add('formeJuridique', EntityType::class, [
                 'class' => FormeJuridique::class,
                'choice_label' => 'getCodeLibelle',
                'attr'=>array('class'=>'form-control form-control-sm syscoa', "style"=>"width:100%;"),
                'required'=>false,
                'disabled'=>true,

               ])


             ->add('regimeFiscal', EntityType::class, [
                 'class' => RegimeFiscal::class,
                'choice_label' => 'getCodeLibelle',
                'attr'=>array('class'=>'form-control form-control-sm syscoa', "style"=>"width:100%;"),
                'required'=>false,
                 'label'=>'Régime fiscal ',
                'disabled'=>true,

               ])

             ->add('paysDuEntreprise', EntityType::class, [
                 'class' => Pays::class,
                'choice_label' => 'getCodeLibelle',
                'attr'=>array('class'=>'form-control form-control-sm syscoa', "style"=>"width:100%;"),
               
                'required'=>false,
                'disabled'=>true,
                'label'=>'Pays du siége de l\'entreprise ',

               ])

             


              ->add('etablissementsDansPays',IntegerType::class,
                   array('label'=>'Nombre d\'établissements dans le pays:',
                          'required'=>false,
                          'disabled'=>true,
                          'attr'=>array(
                              'class'=>'form-control',
                              'min'=>"1"
                       )              
            ))


             ->add('etablissementsHorsPays',IntegerType::class,
                   array('label'=>'Nombre d\'établissements hors du pays:',
                          'required'=>false,
                          'disabled'=>true,
                          'attr'=>array(
                               'class'=>'form-control form-control-sm',
                               'min'=>"1"

                        )              
            ))


              ->add('premiereAnneeExercice',IntegerType::class,
                   array('label'=>'Premiére année d\'éxercice',
                          'required'=>false,
                          'disabled'=>true,
                          'attr'=>array(
                            'class'=>'form-control form-control-sm',
                            'min'=>"1"
                   )              
            ))


            ->add('controle', EntityType::class, [
                 'class' => Control::class,
                'choice_label' => 'getCodeLibelle',
                'attr'=>array('class'=>'form-control form-control-sm syscoa', "style"=>"width:100%;"),
               
                'required'=>false,
                'disabled'=>true,
                'label'=>'Controle ',

               ])


          


            ->add('activitePrincipale',TextareaType::class,
                   array('label'=>'Libellé ',

                          'required'=>false,
                          'disabled'=>true,
                          'attr'=>array('class'=>'form-control form-control-sm',
                           'style' => 'width:100%;'),             
            ))

            ->add('denominationSocial',TextType::class,
                   array('label'=>'Dénomination sociale ',
                          'required'=>false,
                          'disabled'=>true,
                          'attr'=>array('class'=>'form-control form-control-sm input-sm')              
            ))


            ->add('ninea',TextType::class,
                   array('label'=>'NINEA/NINET ',
                          'required'=>false,
                          'disabled'=>true,
                          'attr'=>array('class'=>'form-control form-control-sm','min' => 1)              
            ))

           ->add('dateReactivation', DateType::class, ['label'=>'Date de Réactivation:',
                'attr'=>array('class'=>'form-control form-control-sm',"visibility" => 'hidden'),
                'required'=>false,
                'disabled'=>true,
                'widget' => 'single_text'])

            

            ->add('raisonReactivation',TextType::class,
                   array('label'=>'Raison de Réactivation',
                          'required'=>false,
                          'disabled'=>true,
                          'attr'=>array('class'=>'form-control form-control-sm',"visibility" => 'hidden')              
            ))



           ->add('NomDuContact',TextType::class,
                   array('label'=>'Nom ',
                          'required'=>false,
                          'disabled'=>true,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))

            ->add('prenomDuContact',TextType::class,
                   array('label'=>'Prénom ',
                          'required'=>false,
                          'disabled'=>true,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))

           ->add('addresseDuContact',TextType::class,
                   array('label'=>'adresse ',
                          'required'=>false,
                          'disabled'=>true,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))


           ->add('fonctionDuContact', EntityType::class, [
                 'class' => Qualite::class,
                'choice_label' => 'getCodeLibelle',
                'attr'=>array('class'=>'form-control form-control-sm syscoa', "style"=>"width:100%;"),
               
                'required'=>false,
                'disabled'=>true,
                'label'=>'Fonction/Qualité ',

               ])


            ->add('NomDuCabinet',TextType::class,
                   array('label'=>'Nom du cabinet ',
                          'required'=>false,
                          'disabled'=>true,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))


            ->add('addresseDuCabinet',TextType::class,
                   array('label'=>'Fonction/Qualité ',
                          'required'=>false,
                          'disabled'=>true,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))


          ->add('prenomDuExpert',TextType::class,
                   array('label'=>'Prénom ',
                          'required'=>false,
                          'disabled'=>true,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))


           ->add('nomDuExpert',TextType::class,
                   array('label'=>'Nom ',
                          'required'=>false,
                          'disabled'=>true,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))



            ->add('telephoneDuCabinet',TextType::class,
                   array('label'=>'Tél',
                          'required'=>false,
                          'disabled'=>true,
                          'attr'=>array('class'=>'form-control form-control-sm',
                       "visibility" => 'hidden')              
            ))



            ->add('addresseComplete',TextType::class,
                   array('label'=>'Adresse complete',
                          'required'=>false,
                          'disabled'=>true,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))

            ->add('dureeDeExercice',IntegerType::class,
                   array('label'=>'Durée de l\'excercice(mois)',
                          'required'=>false,
                          'disabled'=>true,
                          'attr'=>array('class'=>'form-control form-control-sm','min' => 1)              
            ))

            ->add('clotureDeExercice', DateType::class, ['label'=>'Date de clôture de l\'excercice',
                'attr'=>array('class'=>'form-control form-control-sm'),
                'required'=>false,
                'disabled'=>true,
                'widget' => 'single_text'])

            ->add('debutExerciceComptable', DateType::class, ['label'=>'Date de début l\'excercice comptable:',
                'attr'=>array('class'=>'form-control form-control-sm'),
                'required'=>false,
                'disabled'=>true,
                'widget' => 'single_text'])



            ->add('finExerciceComptable', DateType::class, ['label'=>'Date de fin de l\'excercice comptable:',
                'attr'=>array('class'=>'form-control form-control-sm'),
                'required'=>false,
                'disabled'=>true,
                'widget' => 'single_text'])



            ->add('dateArreteEffectif', DateType::class, ['label'=>'Date d\'arrêt effectif des comptes:',
                'attr'=>array('class'=>'form-control form-control-sm'),
                'required'=>false,
                'disabled'=>true,
                'widget' => 'single_text'])



            ->add('clotureExercicePrecedent', DateType::class, ['label'=>'Date clôture de l\'excercice précédent:',
                'attr'=>array('class'=>'form-control form-control-sm'),
                'required'=>false,
                'disabled'=>true,
                'widget' => 'single_text'])


            


            ->add('enseigne',TextType::class,
                   array('label'=>'Enseigne ',
                          'required'=>false,
                          'disabled'=>true,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))


            ->add('dureeExercicePrecedent',IntegerType::class,
                   array('label'=>'Durée de l\'excercice précédent(mois):',
                          'required'=>false,
                          'disabled'=>true,
                          'attr'=>array('class'=>'form-control form-control-sm','min' => 1)              
            ))


            ->add('numeroRegistreCommerce',TextType::class,
                   array('label'=>'Numéro de registre de commerce: ',
                          'required'=>false,
                          'disabled'=>true,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))



            ->add('numeroCaisseSociale',TextType::class,
                   array('label'=>'Numéro de caisse sociale ',
                          'required'=>false,
                          'disabled'=>true,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))

            ->add('codeImportateur',TextType::class,
                   array('label'=>'Numéro de code importateur ',
                          'required'=>false,
                          'disabled'=>true,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))


            ->add('telephone1',TextType::class,
                   array('label'=>'Téléphone 1 ',
                          'required'=>false,
                          'disabled'=>true,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))

          ->add('telephone2',TextType::class,
                   array('label'=>'Téléphone 2 ',
                          'required'=>false,
                          'disabled'=>true,
                          'attr'=>array('class'=>'form-control form-control-sm'))
               )

           ->add('numeroTelecopie',TextType::class,
                   array('label'=>'Numéro de télécopie(fax) ',
                          'required'=>false,
                         'disabled'=>true,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))

           ->add('boitePostale',TextType::class,
                   array('label'=>'Boite postale',
                          'required'=>false,
                          'disabled'=>true,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))
            ->add('addresseDuCabinet',TextType::class,
                   array('label'=>'Adresse ',
                          'required'=>false,
                          'disabled'=>true,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))

            
            

             ->add('email',TextType::class,
                   array('label'=>'Adresse email',
                          'required'=>false,
                          'disabled'=>true,
                          'attr'=>array('class'=>'form-control form-control-sm')              
            ))

            ->add('typeNINEA',EntityType::class,array(

                'placeholder'=>'Sélectionner.......',
                'class'=>TypeNINEA::class,
                'choice_label'=>'libelle',
                'attr'=>array('class'=>'form-control form-control-sm '),
                'required'=>false,
                'disabled'=>true,
                'label'=>"Type"


            ))



       

            ->add('commissairesComptes',CollectionType::class,[
                 'entry_type' => CommissairesComptesShowType::class,
                 'label'=>' ',
                 'allow_add'=> true,
                 'allow_delete'=>true,
                 'by_reference'=>false,
                  'delete_empty' => function (CommissairesComptes $commissairesComptes = null) {
                            return null === $commissairesComptes || empty($commissairesComptes->getPrenom());
                  },

            ])

            ->add('activities',CollectionType::class,[
                 'entry_type' => ActivitiesShowType::class,
                 'label'=>' ',
                 'allow_add'=> true,
                 'allow_delete'=>true,
                 'by_reference'=>false,
                 'delete_empty' => function (Activities $activities = null) {
                            return null === $activities || empty($activities->getLibelleActivitePrincipale());
                  },

            ])


             ->add('dirigeants',CollectionType::class,[
                 'entry_type' => DirigeantShowType::class,
                 'label'=>' ',
                 'allow_add'=> true,
                 'allow_delete'=>true,
                 'by_reference'=>false,
                 'delete_empty' => function (Dirigeant $dirigeant = null) {
                            return null === $dirigeant || empty($dirigeant->getPrenom());
                 },

            ])

             ->add('actionnaires',CollectionType::class,[
                 'entry_type' => ActionnaireShowType::class,
                 'label'=>' ',
                 'allow_add'=> true,
                 'allow_delete'=>true,
                 'by_reference'=>false,
                 'delete_empty' => function (Actionnaire $actionnaire = null) {
                            return null === $actionnaire || empty($actionnaire->getPrenom());
                 },

            ])

            ->add('membreConseils',CollectionType::class,[
                 'entry_type' => MembreConseilShowType::class,
                 'label'=>' ',
                 'allow_add'=> true,
                 'allow_delete'=>true,
                 'by_reference'=>false,
                 'delete_empty' => function (MembreConseil $membreConseil = null) {
                            return null === $membreConseil || empty($membreConseil->getPrenom());
                 },

            ])


            ->add('filiales',CollectionType::class,[
                 'entry_type' => FilialesShowType::class,
                 'label'=>' ',
                 'allow_add'=> true,
                 'allow_delete'=>true,
                 'by_reference'=>false,
                 'delete_empty' => function (Filiales $filiales = null) {
                            return null === $filiales || empty($filiales->getDesignation());
                 },

            ])
            
        ;



    



       



    


     
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
       
        
        $resolver->setDefaults([
            'data_class' => Repertoire::class,
        ]);
    }
}
