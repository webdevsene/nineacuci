<?php

namespace App\Controller;

use App\Entity\DemandeModification;
use App\Entity\NINinea;
use App\Entity\TempNiActivite;
use App\Entity\TempNinproduits;
use App\Entity\TempNINinea;
use App\Entity\NinTypedocuments;
use App\Entity\NiSourcefinancement;
use App\Entity\NiModaliteexploitation;
use App\Entity\NiNatureLocaliteExploitation;
use App\Entity\QVH;
use App\Entity\TempNiPersonne;
use App\Entity\TempNiDirigeant;
use App\Entity\NiActivite;
use App\Entity\NiCivilite;
use App\Entity\NiPersonne;
use App\Entity\NiTypevoie;
use App\Entity\Departement;
use App\Entity\CategoryCiti;
use App\Entity\NiFormeunite;
use App\Entity\NiPerception;
use App\Entity\CategoryNaema;
use App\Entity\CompteurNINEA;
use App\Entity\NiCoordonnees;
use App\Entity\TempNiCoordonnees;
use App\Entity\TempNiActiviteEconomique;
use App\Entity\CategorySyscoa;
use Doctrine\ORM\EntityManager;
use App\Entity\NiFormejuridique;
use App\Entity\NiNineaproposition;
use App\Entity\CompteurDemandeNINEA;
use App\Entity\NiActiviteEconomique;
use App\Entity\NiDirigeant;
use App\Entity\NinJourFerier;
use App\Entity\Ninproduits;
use App\Entity\NiStatut;
use App\Entity\Qualite;
use App\Entity\RefProduits;
use App\Entity\CAV;
use App\Entity\CACR;
use App\Entity\Citi;
use App\Entity\Pays;
use App\Entity\NAEMA;
use App\Entity\NAEMAS;
use App\Entity\NiSexe;
use App\Entity\Region;
use App\Entity\SYSCOA;
use App\Entity\NiNationalite;
use App\Entity\NiTypepersone;
use App\Services\DiversUtils;
use App\Entity\CategoryNaemas;
use App\Entity\HistoryNiActivite;
use App\Entity\HistoryNiActiviteEconomique;
use App\Entity\HistoryNiCoordonnees;
use App\Entity\HistoryNiDirigeant;
use App\Entity\HistoryNINinea;
use App\Entity\HistoryNinproduits;
use App\Entity\HistoryNiPersonne;
use App\Entity\NiCessation;
use App\Entity\Nireactivation;
use Symfony\Component\HttpFoundation\Session\Session;


use App\Form\DemandeModificationType;
use App\Repository\DemandeModificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;


/**
 * @Route("/demande/modification")
 * @Security("is_granted('ROLE_CONSULTATION_NINEA') or is_granted('ROLE_DEMANDE_NINEA') or is_granted('ROLE_VALIDER_DEMANDE_NINEA') or is_granted('ROLE_NINEA_ADMIN')")
 */
class DemandeModificationController extends AbstractController
{
    /**
     * @Route("/", name="app_demande_modification_index", methods={"GET"})
     */
    public function index(DemandeModificationRepository $demandeModificationRepository): Response
    {
        return $this->render('demande_modification/index.html.twig', [
            'demande_modifications' => $demandeModificationRepository->findBy(["etat"=>"c", "typeDemande"=>array(1,2)], array('id' => 'DESC')),
        ]);
    }

     /**
     * @Route("/suiviDemandeModification", name="suiviDemandeModification", methods={"GET"})
     * 
     */
    public function suiviDemandeModification(DemandeModificationRepository $demandeModificationRepository,AuthorizationCheckerInterface $autorization, EntityManagerInterface $entityManager): Response
    {
      $demande_modifications = "";

      if ($autorization->isGranted('ROLE_DEMANDE_NINEA')) {

        // $demande_modifications = $demandeModificationRepository->findBysuiviDemandeModification($this->getUser(),"3");
        $demande_modifications = $entityManager->getRepository(DemandeModification::class)->findBy(["typeDemande" => array("1","2"), "createdBy"=>$this->getUser()], array("id"=>"DESC"));
      }
      if ($autorization->isGranted('ROLE_NINEA_ADMIN') || $autorization->isGranted('ROLE_VALIDER_DEMANDE_NINEA')) {

        // $demande_modifications = $demandeModificationRepository->findBysuiviDemandeModification($this->getUser(),"3");
        $demande_modifications = $entityManager->getRepository(DemandeModification::class)->findBy(["typeDemande" => array("1","2"), "etat" => array("a","c","t","r","v")], array("id"=>"DESC"));
      }
      

        return $this->render('demande_modification/suiviDemandeModification.html.twig', [
            'demande_modifications' =>$demande_modifications 
        ]);
        
    }

    /**
     * @Route("/new/{id}", name="app_demande_modification_new", methods={"GET", "POST"})
     */
    public function new(Request $request, DemandeModificationRepository $demandeModificationRepository,EntityManagerInterface $entityManager,NINinea $ninea): Response
    {
        $demandeModification = new DemandeModification();
        $session= new Session();
        $session->set('actived_temp',"");

        $session_errorSaisie_value = $session->get("erreurSaisie");

        if($session_errorSaisie_value != "3"){

          $demandeModification->setTypeDemande("1");

          $demandeModification->setMotif("Demande de modification");
          
          $demandeModification->setNinlock(false);
        }else{
          // $demandeModification->setTypeDemande($session_errorSaisie_value);
          $demandeModification->setTypeDemande("3");
          $demandeModification->setDateReactivation(new \DateTime());
          $demandeModification->setMotif("Demande de reactivation");
          $demandeModification->setNinlock(false);

        }

        $demandeModification->setEtat("a");
        $demandeModification->setNinea($ninea);
        $demandeModification->setCreatedBy($this->getUser());
        $demandeModification->setUpdatedBy($this->getUser());
        
    
        //Entete
        $tempNINinea = new TempNINinea();
        $tempNINinea->setNiLibelleactiviteglobale($ninea->getNiLibelleactiviteglobale());
        $tempNINinea->setNinEnseigne($ninea->getNinEnseigne());
       
        $tempNINinea->setFormeJuridique($ninea->getFormejuridique());
        $tempNINinea->setStatut($ninea->getStatut());
        $tempNINinea->setNinNinea( $ninea->getNinNinea());
        $tempNINinea->setNinEtat($ninea->getNinEtat());
        if($ninea->getCreatedBy())
            $tempNINinea->setCreatedBy($ninea->getCreatedBy());
        if($ninea->getModifiedBy())
            # $tempNINinea->setModifiedBy($ninea->getModifiedBy());
            $tempNINinea->setModifiedBy($this->getUser());
        if($ninea->getCreatedAt())
            $tempNINinea->setCreatedAt($ninea->getCreatedAt());
        if($ninea->getUpdatedAt())
            #$tempNINinea->setUpdatedAt($ninea->getUpdatedAt());
            $tempNINinea->setUpdatedAt(new \DateTime());
            
        $tempNINinea->setNiTypedocument($ninea->getNiTypedocument());
        $tempNINinea->setNomCommercial($ninea->getNomCommercial());
        $tempNINinea->setNinNumeroDocument($ninea->getNinNumeroDocument());
        $tempNINinea->setNinDateDocument($ninea->getNinDateDocument());
        $tempNINinea->setNinStatut($ninea->getNinStatut());
        
        

        //Personne
        $personne = new TempNiPersonne();

        

        if ($ninea->getFormejuridique()->getNiFormeunite()->getId() == 11  or $ninea->getFormejuridique()->getNiFormeunite()->getId() == 12 ){
            //Infos personne physique
            $personne->setNinCNI($ninea->getNiPersonne()->getNinCNI());
            $personne->setNinDateCNI($ninea->getNiPersonne()->getNinDateCNI());
            $personne->setNinQvh($ninea->getNiPersonne()->getNinQvh());
            $personne->setNinNom($ninea->getNiPersonne()->getNinNom());
            $personne->setNinPrenom($ninea->getNiPersonne()->getNinPrenom());
            $personne->setNinEmailPersonnel($ninea->getNiPersonne()->getNinEmailPersonnel());
            $personne->setNinTelephone($ninea->getNiPersonne()->getNinTelephone());
            $personne->setAdresse($ninea->getNiPersonne()->getAdresse());
            $personne->setNinVoie($ninea->getNiPersonne()->getNinVoie());
            $personne->setNumVoie($ninea->getNiPersonne()->getNumVoie());
            $personne->setCivilite($ninea->getNiPersonne()->getCivilite());
            $personne->setNinDateNaissance($ninea->getNiPersonne()->getNinDateNaissance());
            $personne->setNinLieuNaissance($ninea->getNiPersonne()->getNinLieuNaissance());
            $personne->setNationalite($ninea->getNiPersonne()->getNationalite());
            $personne->setNinSexe($ninea->getNiPersonne()->getNinSexe());
            $personne->setNinTypevoie($ninea->getNiPersonne()->getNinTypevoie());
        }else{
            //Infos personne morale
            $personne->setNinRaison($ninea->getNiPersonne()->getNinRaison());
            $personne->setNinSigle($ninea->getNiPersonne()->getNinSigle());
            
        //Dirigeant
        foreach ($ninea->getNinDirigeant() as $key) {
            $tempNiDirigeant= new TempNiDirigeant();
            $tempNiDirigeant->setNinCNI($key->getNinCNI());
            $tempNiDirigeant->setNinDateCNI($key->getNinDateCNI());
            $tempNiDirigeant->setNinQvh($key->getNinQvh());
            $tempNiDirigeant->setNinNom($key->getNinNom());
            $tempNiDirigeant->setNinPrenom($key->getNinPrenom());
            $tempNiDirigeant->setNinEmail($key->getNinEmail());
            $tempNiDirigeant->setNinTelephone1($key->getNinTelephone1());
            $tempNiDirigeant->setNinTelephone2($key->getNinTelephone2());
            $tempNiDirigeant->setNinAddresse($key->getNinAddresse());
            $tempNiDirigeant->setNinPosition($key->getNinPosition());
            
            $tempNiDirigeant->setNinCivilite($key->getNinCivilite());
            $tempNiDirigeant->setNinDatenais($key->getNinDatenais());
            $tempNiDirigeant->setNinLieunais($key->getNinLieunais());
            $tempNiDirigeant->setNinNationalite($key->getNinNationalite());
            $tempNiDirigeant->setNinSexe($key->getNinSexe());
            $tempNiDirigeant->setNiNinea($tempNINinea);
            $entityManager->persist($tempNiDirigeant);
            

        }

        }

        
        $personne->setNinNinea($tempNINinea);
        $entityManager->persist($personne);


        //Info coordonnées 
        if(count($ninea->getNiCoordonnees())>0){

            $coordonnee = new TempNiCoordonnees();

            $coordonnee->setNinTypevoie($ninea->getNiCoordonnees()[0]->getNinTypevoie());
            $coordonnee->setNinVoie($ninea->getNiCoordonnees()[0]->getNinVoie());
            $coordonnee->setNinnumVoie($ninea->getNiCoordonnees()[0]->getNinnumVoie());
            $coordonnee->setNinadresse1($ninea->getNiCoordonnees()[0]->getNinadresse1());
            $coordonnee->setNintelephon2($ninea->getNiCoordonnees()[0]->getNintelephon2());
            $coordonnee->setNinTelephon1($ninea->getNiCoordonnees()[0]->getNinTelephon1());
            $coordonnee->setNinEmail($ninea->getNiCoordonnees()[0]->getNinEmail());
            $coordonnee->setQvh($ninea->getNiCoordonnees()[0]->getQvh());
            $coordonnee->setNinBP($ninea->getNiCoordonnees()[0]->getNinBP());
            $coordonnee->setNinUrl($ninea->getNiCoordonnees()[0]->getNinUrl());
            $coordonnee->setNinNinea($tempNINinea);
            $entityManager->persist($coordonnee);

        }else{
            $coo=new NiCoordonnees();
            $coo->setNinNinea($ninea);
            $coo->setNinnumVoie("");
            $coo->setNinTelephon1("");
            $coo->setCreateBy($this->getUser());
            $coo->setUpdateBy($this->getUser());
            $entityManager->persist($coo);
            $coordonnee = new TempNiCoordonnees();
            $coordonnee->setNinNinea($tempNINinea);
            $entityManager->persist($coordonnee);
        }
       
        
        //Info Activités et produit

        foreach ($ninea->getNinActivite() as $key) {
            $tempNiActivite = new TempNiActivite();
            $tempNiActivite->setNinAutact($key->getNinAutact());
            $tempNiActivite->setRefNaema($key->getRefNaema());
            
            $tempNiActivite->setStatActivprincipale($key->getStatActivprincipale());
            $tempNiActivite->setNiNinea($tempNINinea);
            $entityManager->persist($tempNiActivite);

        }
        foreach ($ninea->getNinproduits() as $key) {
            $ninea->addNinproduit($key);
            $tempNinproduits= new TempNinproduits();
            $tempNinproduits->setRefproduits($key->getRefproduits());
            $tempNinproduits->setNINinea($tempNINinea);
            $entityManager->persist($tempNinproduits);
            
        }

        // Activités économiques
        if(count($ninea->getNinActivitesEconomiques())>0){
            $tempNiActiviteEconomique= new TempNiActiviteEconomique();
            $tempNiActiviteEconomique->setNinCapital($ninea->getNinActivitesEconomiques()[0]->getNinCapital());
            $tempNiActiviteEconomique->setNinEffect1($ninea->getNinActivitesEconomiques()[0]->getNinEffect1());
            $tempNiActiviteEconomique->setNinEffectifFem($ninea->getNinActivitesEconomiques()[0]->getNinEffectifFem());
            $tempNiActiviteEconomique->setNinEffectif($ninea->getNinActivitesEconomiques()[0]->getNinEffectif());
            $tempNiActiviteEconomique->setNinAffaire((float)$ninea->getNinActivitesEconomiques()[0]->getNinAffaire());
            $tempNiActiviteEconomique->setNinEffectifFemSAIS($ninea->getNinActivitesEconomiques()[0]->getNinEffectifFemSAIS());
            $tempNiActiviteEconomique->setNiNinea($tempNINinea);
            $tempNiActiviteEconomique->setNinOcc($ninea->getNinActivitesEconomiques()[0]->getNinOcc());
            $tempNiActiviteEconomique->setNinMode($ninea->getNinActivitesEconomiques()[0]->getNinMode());
            $tempNiActiviteEconomique->setNinNature($ninea->getNinActivitesEconomiques()[0]->getNinNature());
            $entityManager->persist($tempNiActiviteEconomique);
        }else{
            
            $coo=new NiActiviteEconomique();
            $coo->setNINinea($ninea);
            $entityManager->persist($coo);
            $tempNiActiviteEconomique= new TempNiActiviteEconomique();
            $tempNiActiviteEconomique->setNiNinea($tempNINinea);
            $entityManager->persist($tempNiActiviteEconomique);

        }


        

        $demandeModification->setTempNinea($tempNINinea);
        $demandeModificationRepository->add($demandeModification, true);

        return $this->redirectToRoute('app_demande_modification_show', ["id"=>$demandeModification->getId()], Response::HTTP_SEE_OTHER);
    

        return $this->renderForm('demande_modification/new.html.twig', [
            'demande_modification' => $demandeModification,
            
        
        ]);
    }

     /**
     * @Route("/rejeterDemandeModification/{id}", name="rejeterDemandeModification", methods={"GET", "POST"})
     */
    public function rejeterDemandeModification(Request $request,EntityManagerInterface $entityManager,DemandeModification $demandeModification): Response
    {
        $ninea = $demandeModification->getTempNinea();
        $tempNINinea = $demandeModification->getNinea();
        $demandeModification->setEtat("r");
        $demandeModification->setNinlock(false);

        $demande_reactivation  = $entityManager->getRepository(Nireactivation::class)->findOneBy(["ninea"=>$tempNINinea]);

        if (!$demande_reactivation) {
          
        } else {
          // mise a jour de son etat a "r"
          $demande_reactivation->setEtat("t")
                               ->setUpdatedBy($this->getUser())
                               ->setNinlock(false)
          ;
          
        }
        
        $demandeModification->setDescription($request->get("remarque"));
        $demandeModification->setUpdatedBy($this->getUser());
        $entityManager->flush();

        // TODO gerer la redirection apres validation
        if ($demandeModification->getTypeDemande() != "3") {
          
          return $this->redirectToRoute('app_demande_modification_index', [], Response::HTTP_SEE_OTHER);
        } else {
          
          return $this->redirectToRoute('reactivationsList', [], Response::HTTP_SEE_OTHER);
        }

        return $this->redirectToRoute('app_demande_modification_index', [], Response::HTTP_SEE_OTHER);

    }

     /**
     * @Route("/retournerDemandeModification/{id}", name="retournerDemandeModification", methods={"GET", "POST"})
     */
    public function retournerDemandeModification(Request $request,EntityManagerInterface $entityManager,DemandeModification $demandeModification): Response
    {
        $ninea = $demandeModification->getTempNinea();
        $tempNINinea = $demandeModification->getNinea();
        $demandeModification->setEtat("t");
        $demandeModification->setNinlock(false);

        $demande_reactivation  = $entityManager->getRepository(Nireactivation::class)->findOneBy(["ninea"=>$tempNINinea]);

        if (!$demande_reactivation) {
          
        } else {
          // mise a jour de son etat a "t"
          $demande_reactivation->setEtat("t")
                               ->setUpdatedBy($this->getUser())
                               ->setNinlock(false)
          ;
        }
                        
        $demandeModification->setDescription($request->get("remarque"));
        $demandeModification->setUpdatedBy($this->getUser());
        $entityManager->flush();

        // TODO gerer la redirection apres validation
        if ($demandeModification->getTypeDemande() != "3") {
          
          return $this->redirectToRoute('app_demande_modification_index', [], Response::HTTP_SEE_OTHER);
        } else {
          
          return $this->redirectToRoute('reactivationsList', [], Response::HTTP_SEE_OTHER);
        }

        return $this->redirectToRoute('app_demande_modification_index', [], Response::HTTP_SEE_OTHER);
        
    }


    /**
     * @Route("/validerDemandeModification/{id}", name="validerDemandeModification", methods={"GET", "POST"})
     */
    public function validerDemandeModification(Request $request,EntityManagerInterface $entityManager,DemandeModification $demandeModification): Response
    {

        $ninea = $demandeModification->getTempNinea();

        $tempNINinea = $demandeModification->getNinea();

        $historyNinea = new HistoryNINinea(); // cree l'objet historique ninea 
        

        $demandeModification->setEtat("v");
        $demandeModification->setUpdatedBy($this->getUser());

        $demande_reactivation  = $entityManager->getRepository(Nireactivation::class)->findOneBy(["ninea"=>$tempNINinea]);

        if (!$demande_reactivation) {
          
        } else {
          // mise a jour de son etat a "v"
          $demande_reactivation->setEtat("v")->setUpdatedBy($this->getUser());

          
          $tempNINinea->setNinEtat("1");
          $tempNINinea->setStatut('v');
        }
                
        //Entete verser la table de travail NINinea dans la table HistoryNINinea
        $historyNinea->setNiLibelleactiviteglobale($tempNINinea->getNiLibelleactiviteglobale());
        $historyNinea->setNinEnseigne($tempNINinea->getNinEnseigne());
        $historyNinea->setFormeUnite($tempNINinea->getFormeUnite());
        $historyNinea->setFormeJuridique($tempNINinea->getFormejuridique());
        $historyNinea->setStatut($tempNINinea->getStatut());
        $historyNinea->setNinNinea( $tempNINinea->getNinNinea());
        $historyNinea->setNinEtat($tempNINinea->getNinEtat());
        $historyNinea->setUpdatedAt(new \DateTime('now'));
        $historyNinea->setCreatedAt($tempNINinea->getUpdatedAt());
        $historyNinea->setModifiedBy($this->getUser());
        $historyNinea->setCreatedBy( $tempNINinea->getModifiedBy());
        $historyNinea->setNinSigle( $tempNINinea->getNinSigle());

        $historyNinea->setNiTypedocument($tempNINinea->getNiTypedocument());
        $historyNinea->setNomCommercial($tempNINinea->getNomCommercial());
        $historyNinea->setNinNumeroDocument($tempNINinea->getNinNumeroDocument());
        $historyNinea->setNinDateDocument($tempNINinea->getNinDateDocument());
        $historyNinea->setObservationsrccm($tempNINinea->getObservationsrccm());

        $historyNinea->setNinRegcomModif($tempNINinea->getNinRegcomModif());
        $historyNinea->setNinDatregModif($tempNINinea->getNinDatregModif());

        $historyNinea->setNinRegcomReprise($tempNINinea->getNinRegcomReprise());
        $historyNinea->setNinDatregReprise($tempNINinea->getNinDatregReprise());

        $historyNinea->setNinAdministration($tempNINinea->getNinAdministration());
        $historyNinea->setNinStatutH($tempNINinea->getNinStatut());
        
        $entityManager->persist($historyNinea);        

        
        //Entete verser la table tempNINinea dans la table de travail NINinea      
        $tempNINinea->setNiLibelleactiviteglobale($ninea->getNiLibelleactiviteglobale());
        $tempNINinea->setNinEnseigne($ninea->getNinEnseigne());
        $tempNINinea->setFormeJuridique($ninea->getFormejuridique());
        $tempNINinea->setStatut($ninea->getStatut());
        $tempNINinea->setNinNinea( $ninea->getNinNinea());
        $tempNINinea->setNinEtat($ninea->getNinEtat());
        $tempNINinea->setUpdatedAt($ninea->getUpdatedAt());
        $tempNINinea->setCreatedAt($ninea->getCreatedAt());
        $tempNINinea->setModifiedBy($ninea->getModifiedBy());
        $tempNINinea->setCreatedBy($ninea->getCreatedBy());

        $tempNINinea->setNiTypedocument($ninea->getNiTypedocument());
        $tempNINinea->setNomCommercial($ninea->getNomCommercial());
        $tempNINinea->setNinNumeroDocument($ninea->getNinNumeroDocument());
        $tempNINinea->setNinDateDocument($ninea->getNinDateDocument());

        $tempNINinea->setNinRegcomModif($ninea->getNinRegcomModif());
        $tempNINinea->setNinDatregModif($ninea->getNinDatregModif());
        
        // TODO mettre à jour le registre de commerce et la date de reprise
        if ($demandeModification->getTypeDemande() != "3") {
          
        } else {
          
          $historyNinea->setNinRegcomReprise($tempNINinea->getNinRegcomReprise());
          $historyNinea->setNinDatregReprise($tempNINinea->getNinDatregReprise());

          $tempNINinea->setNinRegcomReprise($ninea->getNinRegcomReprise());
          $tempNINinea->setNinDatregReprise($ninea->getNinDatregReprise());
        }
        
       
        

        //Personne
        $historyPersonne = new HistoryNiPersonne();
        $personne = $tempNINinea->getNiPersonne();

        

        if ($ninea->getFormejuridique()->getNiFormeunite()->getId() == 11  or $ninea->getFormejuridique()->getNiFormeunite()->getId() == 12 ){
            
          
          //Infos personne physique verser les données de la table NiPersonne dans la table historyNiPersonne
            $historyPersonne->setNinCNI($personne->getNinCNI());
            if($personne->getNinDateCNI())
             $historyPersonne->setNinDateCNI($tempNINinea->getNiPersonne()->getNinDateCNI());
            $historyPersonne->setNinQvh($personne->getNinQvh());
            $historyPersonne->setNinNom($personne->getNinNom());
            $historyPersonne->setNinPrenom($personne->getNinPrenom());
            $historyPersonne->setNinEmailPersonnel($personne->getNinEmailPersonnel());
            $historyPersonne->setNinTelephone($personne->getNinTelephone());
            $historyPersonne->setAdresse($personne->getAdresse());
            $historyPersonne->setNinVoie($personne->getNinVoie());
            $historyPersonne->setNumVoie($personne->getNumVoie());
            $historyPersonne->setCivilite($personne->getCivilite());
            $historyPersonne->setNinDateNaissance($personne->getNinDateNaissance());
            $historyPersonne->setNinLieuNaissance($personne->getNinLieuNaissance());
            $historyPersonne->setNationalite($personne->getNationalite());
            $historyPersonne->setNinSexe($personne->getNinSexe());
            $historyPersonne->setNinTypevoie($personne->getNinTypevoie());
            $entityManager->persist($historyPersonne);

            $historyNinea->setHistoryNiPersonne($historyPersonne);
            $entityManager->persist($historyNinea);            

          //Infos personne physique
            $personne->setNinCNI($ninea->getTempNiPersonnes()[0]->getNinCNI());
            if($ninea->getTempNiPersonnes()[0]->getNinDateCNI())
             $personne->setNinDateCNI($ninea->getTempNiPersonnes()[0]->getNinDateCNI());
            $personne->setNinQvh($ninea->getTempNiPersonnes()[0]->getNinQvh());
            $personne->setNinNom($ninea->getTempNiPersonnes()[0]->getNinNom());
            $personne->setNinPrenom($ninea->getTempNiPersonnes()[0]->getNinPrenom());
            $personne->setNinEmailPersonnel($ninea->getTempNiPersonnes()[0]->getNinEmailPersonnel());
            $personne->setNinTelephone($ninea->getTempNiPersonnes()[0]->getNinTelephone());
            $personne->setAdresse($ninea->getTempNiPersonnes()[0]->getAdresse());
            $personne->setNinVoie($ninea->getTempNiPersonnes()[0]->getNinVoie());
            $personne->setNumVoie($ninea->getTempNiPersonnes()[0]->getNumVoie());
            $personne->setCivilite($ninea->getTempNiPersonnes()[0]->getCivilite());
            $personne->setNinDateNaissance($ninea->getTempNiPersonnes()[0]->getNinDateNaissance());
            $personne->setNinLieuNaissance($ninea->getTempNiPersonnes()[0]->getNinLieuNaissance());
            $personne->setNationalite($ninea->getTempNiPersonnes()[0]->getNationalite());
            $personne->setNinSexe($ninea->getTempNiPersonnes()[0]->getNinSexe());
            $personne->setNinTypevoie($ninea->getTempNiPersonnes()[0]->getNinTypevoie());
        }else{
            $historyPersonne->setNinRaison($personne->getNinRaison());
            $historyPersonne->setNinSigle($personne->getNinSigle());
          
            $entityManager->persist($historyPersonne);
            $historyNinea->setHistoryNiPersonne($historyPersonne);

            $entityManager->persist($historyNinea);            
          
            //Infos personne morale
            $personne->setNinRaison($ninea->getTempNiPersonnes()[0]->getNinRaison());
            $personne->setNinSigle($ninea->getTempNiPersonnes()[0]->getNinSigle());
            
            
        //Dirigeant verser la table de travail NiDirigeant dans la table HistoryNiDirigeant
        foreach ($tempNINinea->getNinDirigeant() as $key) {
            $historyNiDirigeant= new HistoryNiDirigeant();
            $historyNiDirigeant->setNinCNI($key->getNinCNI());
            $historyNiDirigeant->setNinDateCNI($key->getNinDateCNI());
            $historyNiDirigeant->setNinQvh($key->getNinQvh());
            $historyNiDirigeant->setNinNom($key->getNinNom());
            $historyNiDirigeant->setNinPrenom($key->getNinPrenom());
            $historyNiDirigeant->setNinEmail($key->getNinEmail());
            $historyNiDirigeant->setNinTelephone1($key->getNinTelephone1());
            $historyNiDirigeant->setNinTelephone2($key->getNinTelephone2());
            $historyNiDirigeant->setNinAddresse($key->getNinAddresse());
            $historyNiDirigeant->setNinPosition($key->getNinPosition());
            
            
            $historyNiDirigeant->setNinCivilite($key->getNinCivilite());
            $historyNiDirigeant->setNinDatenais($key->getNinDatenais());
            $historyNiDirigeant->setNinLieunais($key->getNinLieunais());
            $historyNiDirigeant->setNinNationalite($key->getNinNationalite());
            $historyNiDirigeant->setNinSexe($key->getNinSexe());
            $historyNiDirigeant->setNiNinea($historyNinea);
            $entityManager->persist($historyNiDirigeant);
            
            
        }

        //Dirigeant coipier la table dirigeant dans 
        foreach ($tempNINinea->getNinDirigeant() as $key) {
            $entityManager->remove($key);
        }
        foreach ($ninea->getTempNiDirigeants() as $key) {
            $tempNiDirigeant= new NiDirigeant();
            $tempNiDirigeant->setNinCNI($key->getNinCNI());
            $tempNiDirigeant->setNinDateCNI($key->getNinDateCNI());
            $tempNiDirigeant->setNinQvh($key->getNinQvh());
            $tempNiDirigeant->setNinNom($key->getNinNom());
            $tempNiDirigeant->setNinPrenom($key->getNinPrenom());
            $tempNiDirigeant->setNinEmail($key->getNinEmail());
            $tempNiDirigeant->setNinTelephone1($key->getNinTelephone1());
            $tempNiDirigeant->setNinTelephone2($key->getNinTelephone2());
            $tempNiDirigeant->setNinAddresse($key->getNinAddresse());
            $tempNiDirigeant->setNinPosition($key->getNinPosition());
            
            
            $tempNiDirigeant->setNinCivilite($key->getNinCivilite());
            $tempNiDirigeant->setNinDatenais($key->getNinDatenais());
            $tempNiDirigeant->setNinLieunais($key->getNinLieunais());
            $tempNiDirigeant->setNinNationalite($key->getNinNationalite());
            $tempNiDirigeant->setNinSexe($key->getNinSexe());
            $tempNiDirigeant->setNiNinea($tempNINinea);
            $entityManager->persist($tempNiDirigeant);
            
            
        }

      }

        
       // $personne->setNinNinea($tempNINinea);
        //$entityManager->persist($personne);


        //Info coordonnées verser les donnees de la table de travail dans la table histry pour les coordonees 
        $coordonnee = $tempNINinea->getNiCoordonnees()[0];
        $historyNiCoordonnee = new HistoryNiCoordonnees();
        $historyNiCoordonnee->setNinTypevoie($coordonnee->getNinTypevoie());
        $historyNiCoordonnee->setNinVoie($coordonnee->getNinVoie());
        $historyNiCoordonnee->setNinnumVoie($coordonnee->getNinnumVoie());
        $historyNiCoordonnee->setNinadresse1($coordonnee->getNinadresse1());
        $historyNiCoordonnee->setNintelephon2($coordonnee->getNintelephon2());
        $historyNiCoordonnee->setNinTelephon1($coordonnee->getNinTelephon1());
        $historyNiCoordonnee->setNinEmail($coordonnee->getNinEmail());
        $historyNiCoordonnee->setQvh($coordonnee->getQvh());
        $historyNiCoordonnee->setNinBP($coordonnee->getNinBP());
        $historyNiCoordonnee->setNinUrl($coordonnee->getNinUrl());
        $historyNiCoordonnee->setNinNinea($historyNinea);
        $entityManager->persist($historyNiCoordonnee);

        //Info coordonnées 
        $coordonnee = $tempNINinea->getNiCoordonnees()[0];
        $coordonnee->setNinTypevoie($ninea->getTempNiCoordonnees()[0]->getNinTypevoie());
        $coordonnee->setNinVoie($ninea->getTempNiCoordonnees()[0]->getNinVoie());
        if($ninea->getTempNiCoordonnees()[0]->getNinnumVoie())
        $coordonnee->setNinnumVoie($ninea->getTempNiCoordonnees()[0]->getNinnumVoie());
        if($ninea->getTempNiCoordonnees()[0]->getNinadresse1())
        $coordonnee->setNinadresse1($ninea->getTempNiCoordonnees()[0]->getNinadresse1());
        if($ninea->getTempNiCoordonnees()[0]->getNintelephon2())
        $coordonnee->setNintelephon2($ninea->getTempNiCoordonnees()[0]->getNintelephon2());
        if($ninea->getTempNiCoordonnees()[0]->getNintelephon1())
        $coordonnee->setNinTelephon1($ninea->getTempNiCoordonnees()[0]->getNinTelephon1());
        $coordonnee->setNinEmail($ninea->getTempNiCoordonnees()[0]->getNinEmail());
        $coordonnee->setQvh($ninea->getTempNiCoordonnees()[0]->getQvh());
        $coordonnee->setNinBP($ninea->getTempNiCoordonnees()[0]->getNinBP());
        $coordonnee->setNinUrl($ninea->getTempNiCoordonnees()[0]->getNinUrl());
        $coordonnee->setNinNinea($tempNINinea);
        
       
        //Info Activités et produit
       foreach ($tempNINinea->getNinActivite() as $key) {
        $historyNiActivite = new HistoryNiActivite();
        if($key->getNinAutact())
           $historyNiActivite->setNinAutact($key->getNinAutact());

        if($key->getRefNaema()){
            $historyNiActivite->setRefNaema($key->getRefNaema());
            //dd($key->getRefNaema());
        }
       
        if($key->isStatActivprincipale())
            $historyNiActivite->setStatActivprincipale(true);
        else
            $historyNiActivite->setStatActivprincipale(false);
    
            $historyNiActivite->setNINinea($historyNinea);
            $entityManager->persist($historyNiActivite);
        }


        //Info Activités et produit
       foreach ($tempNINinea->getNinActivite() as $key) {
            $entityManager->remove($key);
        }

        foreach ($ninea->getTempNiActivites() as $key) {
            $tempNiActivite = new NiActivite();
            if($key->getNinAutact())
               $tempNiActivite->setNinAutact($key->getNinAutact());

            if($key->getRefNaema()){
                $tempNiActivite->setRefNaema($key->getRefNaema());
                //dd($key->getRefNaema());
            }
           
            if($key->isStatActivprincipale())
                $tempNiActivite->setStatActivprincipale(true);
            else
                $tempNiActivite->setStatActivprincipale(false);

            

            $tempNiActivite->setNINinea($tempNINinea);
            $entityManager->persist($tempNiActivite);

        }

        foreach ($tempNINinea->getNinproduits() as $key) {
          $historyNinproduits= new HistoryNinproduits();
          $historyNinproduits->setRefproduits($key->getRefproduits());
          $historyNinproduits->setNINinea($historyNinea);
          $entityManager->persist($historyNinproduits);
            
          $entityManager->persist($historyNinproduits);
        }



        foreach ($tempNINinea->getNinproduits() as $key) {
            $entityManager->remove($key);
        }
        foreach ($ninea->getTempNinproduits() as $key) {
            //$ninea->addNinproduit($key);
            $tempNinproduits= new Ninproduits();
            $tempNinproduits->setRefproduits($key->getRefproduits());
            $tempNinproduits->setNINinea($tempNINinea);
            $entityManager->persist($tempNinproduits);
            
        }

        // Activités économiques

        $tempNiActiviteEconomique= $tempNINinea->getNinActivitesEconomiques()[0];
        $historyNiActiviteEconomique= new HistoryNiActiviteEconomique();
        $historyNiActiviteEconomique->setNinCapital($tempNiActiviteEconomique->getNinCapital());
        $historyNiActiviteEconomique->setNinEffect1($tempNiActiviteEconomique->getNinEffect1());
        $historyNiActiviteEconomique->setNinEffectifFem($tempNiActiviteEconomique->getNinEffectifFem());
        $historyNiActiviteEconomique->setNinEffectif($tempNiActiviteEconomique->getNinEffectif());
        $historyNiActiviteEconomique->setNinAffaire((float) $tempNiActiviteEconomique->getNinAffaire());
        $historyNiActiviteEconomique->setNinEffectifFemSAIS($tempNiActiviteEconomique->getNinEffectifFemSAIS());
        $historyNiActiviteEconomique->setNinOcc($tempNiActiviteEconomique->getNinOcc());
        $historyNiActiviteEconomique->setNinMode($tempNiActiviteEconomique->getNinMode());
        $historyNiActiviteEconomique->setNinNature($tempNiActiviteEconomique->getNinNature());
        $historyNiActiviteEconomique->setNiNinea($historyNinea);
        $entityManager->persist($historyNiActiviteEconomique);



        // Activités économiques

        $tempNiActiviteEconomique= $tempNINinea->getNinActivitesEconomiques()[0];
        $tempNiActiviteEconomique->setNinCapital($ninea->getTempNiActiviteEconomiques()[0]->getNinCapital());
        $tempNiActiviteEconomique->setNinEffect1($ninea->getTempNiActiviteEconomiques()[0]->getNinEffect1());
        $tempNiActiviteEconomique->setNinEffectifFem($ninea->getTempNiActiviteEconomiques()[0]->getNinEffectifFem());
        $tempNiActiviteEconomique->setNinEffectif($ninea->getTempNiActiviteEconomiques()[0]->getNinEffectif());
        $tempNiActiviteEconomique->setNinAffaire((float) $ninea->getTempNiActiviteEconomiques()[0]->getNinAffaire());
        $tempNiActiviteEconomique->setNinEffectifFemSAIS($ninea->getTempNiActiviteEconomiques()[0]->getNinEffectifFemSAIS());
        $tempNiActiviteEconomique->setNinOcc($ninea->getTempNiActiviteEconomiques()[0]->getNinOcc());
        $tempNiActiviteEconomique->setNinMode($ninea->getTempNiActiviteEconomiques()[0]->getNinMode());
        $tempNiActiviteEconomique->setNinNature($ninea->getTempNiActiviteEconomiques()[0]->getNinNature());
        $tempNiActiviteEconomique->setNiNinea($tempNINinea);
      //  $entityManager->persist($tempNiActiviteEconomique);


        

        //$demandeModification->setTempNinea($tempNINinea);
        $entityManager->flush();


        // TODO gerer la redirection apres validation
        if ($demandeModification->getTypeDemande() != "3") {
          
          return $this->redirectToRoute('app_demande_modification_index', [], Response::HTTP_SEE_OTHER);
        } else {
          
          return $this->redirectToRoute('reactivationsList', [], Response::HTTP_SEE_OTHER);
        }

        return $this->redirectToRoute('app_demande_modification_index', [], Response::HTTP_SEE_OTHER);
    

        
    }

    /**
     * @Route("/temp_editPersonne/{id}/{demande}", name="temp_ninea_editPersonne", methods={"GET", "POST"})
     */
    public function temp_editPersonne(Request $request, EntityManagerInterface $entityManager,$id="",$demande=""): Response
    {
        $lastpersonne=  $entityManager->getRepository(TempNiPersonne::class)->find($id);
        $demande=$entityManager->getRepository(DemandeModification::class)->find($demande);
        
        $session= new Session();
        $session->set('actived_temp',"");
        $nom = $lastpersonne->getNinNom() ;
        $prenom =  $lastpersonne->getNinPrenom()   ;
        //$adresse =   $lastpersonne[0]->getAdresse()  ;

        if ( $lastpersonne->getCivilite()) {
           $civilite =  $lastpersonne->getCivilite()->getId() ;
        }else
            $civilite ="" ;

         if ( $lastpersonne->getNinDateNaissance())
           $datenais =   $lastpersonne->getNinDateNaissance()->format("Y-m-d");
         else
            $datenais = "";

         if ( $lastpersonne->getNationalite())
            $nationalite =  $lastpersonne->getNationalite()->getId();
          else
            $nationalite = "";

          if ( $lastpersonne->getNinSexe())
            $nsexe =  $lastpersonne->getNinSexe()->getId()    ;
          else
           $nsexe = "";

          if ( $lastpersonne->getNinDateCNI())
              $datecni =  $lastpersonne->getNinDateCNI()->format("Y-m-d");
          else
              $datecni = "";
              $datepassport = "";

          //QVH POUR PERSONNE
          if ( $lastpersonne->getNinQvh()) {
            $qvh_personne = $lastpersonne->getNinQvh();
          }else
              $qvh_personne ="" ;

          if ( $lastpersonne->getNinQvh()) {
            $cacr_personne = $lastpersonne->getNinQvh()->getQvhCACRID()->getId();
          }else
            $cacr_personne ="" ;

          if ( $lastpersonne->getNinQvh()) {
            $cav_personne = $lastpersonne->getNinQvh()->getQvhCACRID()->getCacrCAVID()->getId();
          }else
              $cav_personne ="" ;

          if ( $lastpersonne->getNinQvh()) {
              $departement_personne = $lastpersonne->getNinQvh()->getQvhCACRID()->getCacrCAVID()->getCavDEPID()->getId();
          }else
              $departement_personne ="" ;

          if ( $lastpersonne->getNinQvh()) {
             $region_personne = $lastpersonne->getNinQvh()->getQvhCACRID()->getCacrCAVID()->getCavDEPID()->getDepRegCD()->getId();
          }else
              $region_personne ="" ;


        $departements = $entityManager->getRepository(Departement::class)->findBy(array("depRegCD"=>$region_personne));
        $cavs = $entityManager->getRepository(CAV::class)->findBy(array("cavDEPID"=>$departement_personne));
        $cacrs = $entityManager->getRepository(CACR::class)->findBy(array("cacrCAVID"=>$cav_personne));

        $lieunais =   $lastpersonne->getNinLieuNaissance();
        $cni =  $lastpersonne->getNinCNI() ;
        $passport =  $lastpersonne->getNinCNI();
        $raison =  $lastpersonne->getNinRaison();
        $sigle =  $lastpersonne->getNinSigle();
        $email =  $lastpersonne->getNinEmailPersonnel();
      

        $sexe = $entityManager->getRepository(NiSexe::class)->findAll();
        $nationalites = $entityManager->getRepository(Pays::class)->findAll();
        $civilites = $entityManager->getRepository(NiCivilite::class)->findAll();


        $regions = $entityManager->getRepository(Region::class)->findAll();

     
          if ($lastpersonne->getNinNinea()->getFormejuridique()->getNiFormeunite()->getId() == 11 or $lastpersonne->getNinNinea()->getFormejuridique()->getNiFormeunite()->getId() == 12)
          {

              //récupération personne physique
              $nom = $request->get("nom");
             
              $prenom = $request->get("prenom");
             
              $civilite = $request->get("civilite");
              $datenais = $request->get("datenais");
              $lieunais = $request->get("lieunais");
              $email = $request->get('email');
              $telephone = $request->get('telephone');
              $nationalite = $request->get("nationalite");
              $qvh=$request->get('qvh');

              $nsexe = $request->get("sexe");

              $lastpersonne->setNinNom($nom);
              $lastpersonne->setNinPrenom($prenom);
              $lastpersonne->setNinTelephone($telephone);
              $lastpersonne->setNinEmailPersonnel($email);
              $lastpersonne->setCivilite($entityManager->getRepository(NiCivilite::class)->find($civilite));
              $lastpersonne->setNinDateNaissance(new \DateTime($datenais));
              $lastpersonne->setNinLieuNaissance($lieunais);
              $lastpersonne->setNationalite($entityManager->getRepository(Pays::class)->find($nationalite));
              $lastpersonne->setNinSexe($entityManager->getRepository(NiSexe::class)->find($nsexe));
              $lastpersonne->setNinQvh($entityManager->getRepository(QVH::class)->find($qvh));
              $lastpersonne->setAdresse($request->get('adresse'));


              if( $nationalite=="07"){
                  $cni = $request->get("cni");
                  $datecni = $request->get("dateCni");
                  $lastpersonne->setNinCNI($cni);
                  $lastpersonne->setNinDateCNI(new \DateTime($datecni));
              }
              else {
                  $passport = $request->get("passport");
                  $datepassport = $request->get("datepassport");
                  $lastpersonne->setNinCNI($passport);
                  $lastpersonne->setNinDateCNI(new \DateTime($datepassport));
              }

           $lastpersonne->setNinRaison("");
           $lastpersonne->setNinSigle("");

          }else{
              //recupération personne morale
           $raison = $request->get("raison");
           $sigle = $request->get("sigle");
           $lastpersonne->setNinRaison($raison);
           $lastpersonne->setNinSigle($sigle);

          }

         
           
          $entityManager->flush();

        return $this->redirectToRoute('app_demande_modification_show', ["id"=>$demande->getId()], Response::HTTP_SEE_OTHER);
        

       
    }

     /**
     * @Route("/temp_editCoordonnees/{id}/{demande}", name="temp_editCoordonnees", methods={"GET", "POST"})
     */
    public function temp_editCoordonnees(Request $request, EntityManagerInterface $entityManager, $id="",$demande=""): Response
    {

        $session= new Session();
        $session->set('actived_temp',2);
        $coordonnee=$entityManager->getRepository(TempNiCoordonnees::class)->find($id);
        $demande=$entityManager->getRepository(DemandeModification::class)->find($demande);
       

        $typevoie = $request->get("typevoie");
        $qvh =  $request->get("qvh");
        $numvoie = $request->get("numvoie");
        $voie = $request->get("voie");
        $adresse1 = $request->get("adresse1");
        $telephone1 = $request->get("telephone1");
        $telephone2 = $request->get("telephone2");
        $email = $request->get("email");
        $boitepostale =  $request->get("bp");   
        $url =  $request->get("url");   

       
        if($typevoie!=null)
          $coordonnee->setNinTypevoie($entityManager->getRepository(NiTypevoie::class)->find($typevoie));
        $coordonnee->setNinVoie($voie);
        $coordonnee->setNinnumVoie($numvoie);
        $coordonnee->setNinadresse1($adresse1);
        $coordonnee->setNintelephon2($telephone2);
        $coordonnee->setNinTelephon1($telephone1);
        $coordonnee->setNinEmail($email);
        $coordonnee->setQvh($entityManager->getRepository(QVH::class)->find($qvh));
        $coordonnee->setNinBP($boitepostale);
        $coordonnee->setNinUrl($url);
        $coordonnee->setUpdatedBy($this->getUser());
       
        $entityManager->flush();
        return $this->redirectToRoute('app_demande_modification_show', ["id"=>$demande->getId()], Response::HTTP_SEE_OTHER);

        

     
    }

     /**
     * @Route("/temp_editEntete/{id}/{demande}", name="temp_editEntete", methods={"GET", "POST"})
     */
    public function temp_editEntete(Request $request, EntityManagerInterface $entityManager, $id="",$demande=""): Response
    {
      
      
        
        $ninea=  $entityManager->getRepository(TempNINinea::class)->find($id);
        $demande=$entityManager->getRepository(DemandeModification::class)->find($demande);
        
        $session=new Session();
        $session->set('actived',"");
        
        $session_erreurSaisie_value = $session->get("erreurSaisie"); // ça va nous servir apres 
        if($session_erreurSaisie_value != "3"){
          
          
        }else{
            // on cree ici la demande de nireactivation
            $demande_reactivation = new Nireactivation();
            $demande_reactivation->setDateReactivation(new \DateTime($request->get("ninDatregReprise")))
                                 ->setCreatedBy($this->getUser())
                                 ->setUpdatedBy($this->getUser())
                                 ->setEtat("a")
                                 ->setTempNinea($ninea)
                                 ->setNinea($demande->getNinea())
                                 ->setRemarque("demande de reactivation ")
            ;

            $entityManager->persist($demande_reactivation);
            $entityManager->flush();
          
        }
        
        $ninRegcom = "";
        $ninDatreg = ""; 


      
        
        $ninea->setNinEnseigne($request->get('enseigne'));
        $ninea->setNomCommercial($request->get('commercial'));
        if($request->get('typdocument'))
          $ninea->setNiTypedocument($this->getDoctrine()->getRepository(NinTypedocuments::class)->find($request->get('typdocument')));
        $ninea->setNinNumeroDocument(str_replace("_","",$request->get('document')));
       
        if($request->get('datedocument'))
         $ninea->setNinDateDocument(new \DateTime($request->get('datedocument')));

        $ninea->setNinRegcomModif($request->get('ninRegcomModif'));
        if($request->get('ninDatregModif'))
          $ninea->setNinDatregModif(new \DateTime($request->get('ninDatregModif')));


       
        if($request->get('ninRegcomReprise'))
          $ninea->setNinRegcomReprise(str_replace("_","",$request->get('ninRegcomReprise')));
          
        
        if($request->get('ninDatregReprise'))
          $ninea->setNinDatregReprise(new \DateTime($request->get('ninDatregReprise')));
        
       

        $entityManager->flush();


        return $this->redirectToRoute('app_demande_modification_show', ["id"=>$demande->getId()], Response::HTTP_SEE_OTHER);
      

    }


    /**
    * @Route("/temp_activiteEtProduitsHisto/{id}/{demande}", name="temp_activiteEtProduitsHisto", methods={"GET", "POST"})
    */
   public function temp_activiteEtProduitsHisto(Request $request, EntityManagerInterface $entityManager, $id="",$demande=""): Response
   {
       
       $demande=$entityManager->getRepository(DemandeModification::class)->find($demande);

       $niNinea =   $demande->getTempNinea();
      
       $naemas = $entityManager->getRepository(NAEMA::class)->findAll();
     
      
         $niNinea->setNiLibelleactiviteglobale($request->get('libelleactiviteglobale'));


         $ninactivites = $entityManager->getRepository(TempNiActivite::class)->findBy(array("niNinea"=>$niNinea),array('id'=>'desc'));
         $ninproduits = $entityManager->getRepository(TempNinproduits::class)->findBy(array("nINinea"=>$niNinea),array('id'=>'desc'));
       
 
        // var_dump($ninactivites);
         $nbActivites=$request->get('nbActivites');
        // var_dump($nbActivites);
        //var_dump($ninproduits);

        //dd($nbActivites);

         for($indice = 1; $indice <= (int)($nbActivites); $indice++){
           //var_dump($ninproduits);

           $refProduit=$request->get('refProduit'.strval($indice));
           $refNaema=$request->get('refNaema'.strval($indice));
           $libelleActivite=$request->get('ninAutact'.strval($indice));

           
           $bActiviteTrouve=false;
          // var_dump($refProduit);
         // dd($ninactivites);
          foreach ($ninactivites as $act) {
           if($act->getRefNaema()->getId()==$refNaema){
                $bActiviteTrouve=true;
                $ninactivite=$act;
                break;
           }
          }

           
           if($bActiviteTrouve==false){
             $ninactivite = new TempNiActivite();
              
            
             if(count($niNinea->getTempNiActivites())>0)
              $ninactivite->setStatActivPrincipale(false);
             else
              $ninactivite->setStatActivPrincipale(true);

             
           $ninactivite->setNinAutact($libelleActivite);
           $ninactivite->setNINinea($niNinea);
           $ninactivite->setRefNaema($entityManager->getRepository(NAEMA::class)->find($refNaema));
          // $niNineaproposition->addNinActivite($ninactivite);
           $niNinea->addTempNiActivite($ninactivite);
           $entityManager->persist($ninactivite);

           }
           else {
            // $ninactivite=$act;
             $ninactivite->setNinAutact($libelleActivite);
             
            // var_dump($ninactivite);
           }


           foreach ($refProduit as $key) {

             $bProduitTrouve=false;
             foreach ($ninproduits as $prod) {
               if($prod->getRefproduits()->getId()==$key){
                    $bProduitTrouve=true;
                    $ninproduit = $prod;
                    //var_dump($ninactivite);
                    break;
               }
            }

             if($bProduitTrouve==false){
               $ninproduit = new TempNinproduits();
               $ninproduit->setRefproduits($entityManager->getRepository(RefProduits::class)->find($key));
               $niNinea->addTempNinproduit($ninproduit);
               
               $entityManager->persist($ninproduit);
             }
             else{
             //  var_dump($ninproduit);
             }
         
           }

           //Gestion de la suppression des produits
           foreach ($ninproduits as $ninprod) {
             if($ninprod->getRefproduits()->getNaema()->getId()==$refNaema){
               $bProduitASupprimer=true;
               foreach ($refProduit as $refprod) {
                 if($ninprod->getRefproduits()->getId()==$refprod){
                   $bProduitASupprimer=false;
                   break;
                 }
               }

               if($bProduitASupprimer==true){
                 $niNinea->removeTempNinproduit($ninprod);
                // $entityManager->remove($ninprod);
               }
             }
            
           }

         }

         $session= new Session();
         $session->set('actived_temp',3);
       
         $entityManager->flush();

          // $request->getSession()->getFlashBag()->add('message',"L'activité  a été ajoutée avec succés.");
        return $this->redirectToRoute('app_demande_modification_show', ["id"=>$demande->getId()], Response::HTTP_SEE_OTHER);

    
          
   }


     /**
     * @Route("/temp_nininea_editActivitesEconomiques/{id}/{demande}", name="temp_nininea_editActivitesEconomiques", methods={"GET", "POST"})
     */
    public function temp_editActivitesEconomiques(Request $request, EntityManagerInterface $entityManager, $id="",$demande=""): Response
    {

        $session= new Session();
        $session->set('actived_temp',4);
        
        $demande=$entityManager->getRepository(DemandeModification::class)->find($demande);
        

        if ($request->get('modifierActivitesEcos')) 
        {

          $acteconom=$entityManager->getRepository(TempNiActiviteEconomique::class)->find($id);
       
          $ninAffaire = str_replace(" ","" , $request->get("ninAffaire"));
          $ninAnneeCa =  $request->get("ninAnneeCa");
          $ninCapital = str_replace(" ","" , $request->get("ninCapital"));
          $ninEffectif = $request->get("ninEffectif");
          $ninEffect1 = $request->get("ninEffect1");
          $ninEffectifFem = $request->get("ninEffectifFem");
          $ninEffectifFemSAIS = $request->get("ninEffectifFemSAIS");
          $ninsource = $request->get("ninOcc");
          $ninmode = $request->get("ninMode");
          $ninature = $request->get("ninNature");
          if ($ninsource)
          {
            $acteconom->setNinOcc($this->getDoctrine()->getRepository(NiSourcefinancement::class)->find($ninsource));
            
          }
          if ($ninmode)
          {
            $acteconom->setNinMode($this->getDoctrine()->getRepository(NiModaliteexploitation::class)->find($ninmode));

          }

          if($ninature)
          {
            $acteconom->setNinNature($this->getDoctrine()->getRepository(NiNatureLocaliteExploitation::class)->find($ninature));

          }

           $acteconom->setNinAffaire((float) $ninAffaire);
           $acteconom->setNinAnneeCa($ninAnneeCa);
           if($ninCapital)
            $acteconom->setNinCapital($ninCapital);
           if($ninEffectif)
            $acteconom->setNinEffectif($ninEffectif);
           if($ninEffect1) 
             $acteconom->setNinEffect1($ninEffect1);
           if($ninEffectifFem)  
              $acteconom->setNinEffectifFem($ninEffectifFem);
           if($ninEffectifFemSAIS)  
             $acteconom->setNinEffectifFemSAIS($ninEffectifFemSAIS);  
           $entityManager->flush();

           
        }

        return $this->redirectToRoute('app_demande_modification_show', ["id"=>$demande->getId()], Response::HTTP_SEE_OTHER);
       
    }


    /**
     * @Route("/temp_suppActiviteEtProduitsHisto/{id}/{demande}", name="temp_suppActiviteEtProduitsHisto", methods={"GET", "POST"})
     */
    public function temp_suppActiviteEtProduitsHisto(Request $request, EntityManagerInterface $entityManager,$id="",$demande=""): Response
    {
        $session= new Session();
        $session->set('actived_temp',3);

        $demande=$entityManager->getRepository(DemandeModification::class)->find($demande);

        $activite =  $entityManager->getRepository(TempNiActivite::class)->find($id);
       // $niNinea= $activite->getNINinea();

      //  $activite->getModifiedBy($this->getUser());
       // $activite->setDateDeCloture(new \DateTime());
        $entityManager->remove($activite);

        $entityManager->flush();
        return $this->redirectToRoute('app_demande_modification_show', ["id"=>$demande->getId()], Response::HTTP_SEE_OTHER);
        

    }


      /**
     * @Route("/temp_modifierDirigeantsHisto/{id}/{demande}", name="temp_modifierDirigeantsHisto", methods={"GET", "POST"})
     */
    public function temp_modifierDirigeantsHisto(Request $request, EntityManagerInterface $entityManager,$id="",$demande=""): Response
    {
        $session= new Session();
        $session->set('actived_temp',5);

        $demande=$entityManager->getRepository(DemandeModification::class)->find($demande);
      
        $dirigeant =  $entityManager->getRepository(TempNiDirigeant::class)->find($id);
       
        if($dirigeant){
          $niNinea= $dirigeant->getNINinea();
       } 

        //var_dump($civilites);
        if(!$dirigeant)
        {
          $dirigeantNouveau =  new TempNiDirigeant();

          $session= new Session();
          $session->set('actived',5);

          $nationalite = $entityManager->getRepository(NiStatut::class)->find($request->get("nationalite"));
          $cni = $request->get('cni');
          $datecni = $request->get('datecni');
          $nationalite = $request->get("nationalite");
          if( $nationalite=="SN"){
            $cni = $request->get("cni");
            $datecni = $request->get("dateCni");
            $dirigeantNouveau->setNinCni($cni);
            $dirigeantNouveau->setNinDateCni(new \DateTime($datecni));
            }
            else {
                $passport = $request->get("passport");
                $datepassport = $request->get("datepassport");
                $dirigeantNouveau->setNinCni($passport);
                $dirigeantNouveau->setNinDateCni(new \DateTime($datepassport));
            }
             
            $nom = $request->get("nom");
            $prenom = $request->get("prenom");
            //$adresse = $request->get("adresse");
            $civilite = $request->get("civilite");
            $datenais = $request->get("datenais");
            $lieunais = $request->get("lieunais");
            $nsexe = $request->get("sexe");
            $email = $request->get("email");
            $qualification = $request->get("qualification");
            $telephone = $request->get("telephone");
            $adresse = $request->get("adresse");

            
           

            $dirigeantNouveau->setNinAddresse($adresse);
            $dirigeantNouveau->setNinNom($nom);
            $dirigeantNouveau->setNinPrenom($prenom);
            //$personne->setAdresse($adresse);
            $dirigeantNouveau->setNinCivilite($entityManager->getRepository(NiCivilite::class)->find($civilite));
            $dirigeantNouveau->setNinDatenais(new \DateTime($datenais));
            $dirigeantNouveau->setNinLieunais($lieunais);
            $dirigeantNouveau->setNinTelephone1($telephone);
            $dirigeantNouveau->setNinEmail($email);
            $dirigeantNouveau->setNinPosition($entityManager->getRepository(Qualite::class)->find($qualification));

            $dirigeantNouveau->setNinNationalite($entityManager->getRepository(Pays::class)->find($nationalite));
            $dirigeantNouveau->setNinSexe($entityManager->getRepository(NiSexe::class)->find($nsexe));
            
           
            $dirigeantNouveau->setNINinea( $demande->getTempNinea());

          

            //var_dump($dirigeantNouveau);
            
            $entityManager->persist($dirigeantNouveau);
            $entityManager->flush();
            return $this->redirectToRoute('app_demande_modification_show', ["id"=>$demande->getId()], Response::HTTP_SEE_OTHER);
            
        // return $this->redirectToRoute('n_i_ninea_edit', ["id"=> $niNinea->getId()], Response::HTTP_SEE_OTHER);
      
        }
        else 
        {
          $dirigeantNouveau = $dirigeant;

          $session= new Session();
          $session->set('actived',5);

          $nationalite = $entityManager->getRepository(NiStatut::class)->find($request->get("nationalite"));
          $cni = $request->get('cni');
          $datecni = $request->get('datecni');
          $nationalite = $request->get("nationalite");
          if( $nationalite=="SN"){
            $cni = $request->get("cni");
            $datecni = $request->get("dateCni");
            $dirigeantNouveau->setNinCni($cni);
            $dirigeantNouveau->setNinDateCni(new \DateTime($datecni));
            }
            else {
                $passport = $request->get("passport");
                $datepassport = $request->get("datepassport");
                $dirigeantNouveau->setNinCni($passport);
                $dirigeantNouveau->setNinDateCni(new \DateTime($datepassport));
            }
             
            $nom = $request->get("nom");
            $prenom = $request->get("prenom");
            //$adresse = $request->get("adresse");
            $civilite = $request->get("civilite");
            $datenais = $request->get("datenais");
            $lieunais = $request->get("lieunais");
            $nsexe = $request->get("sexe");
            $email = $request->get("email");
            $qualification = $request->get("qualification");
            $telephone = $request->get("telephone");
            $adresse = $request->get("adresse");

            
           

            $dirigeantNouveau->setNinAddresse($adresse);
            $dirigeantNouveau->setNinNom($nom);
            $dirigeantNouveau->setNinPrenom($prenom);
            //$personne->setAdresse($adresse);
            $dirigeantNouveau->setNinCivilite($entityManager->getRepository(NiCivilite::class)->find($civilite));
            $dirigeantNouveau->setNinDatenais(new \DateTime($datenais));
            $dirigeantNouveau->setNinLieunais($lieunais);
            $dirigeantNouveau->setNinTelephone1($telephone);
            $dirigeantNouveau->setNinEmail($email);
            $dirigeantNouveau->setNinPosition($entityManager->getRepository(Qualite::class)->find($qualification));

            $dirigeantNouveau->setNinNationalite($entityManager->getRepository(Pays::class)->find($nationalite));
            $dirigeantNouveau->setNinSexe($entityManager->getRepository(NiSexe::class)->find($nsexe));
           
            
        

           // $dirigeant->setDateDeCloture(new \DateTime());

            //var_dump($dirigeantNouveau);
            
           // $entityManager->persist($dirigeantNouveau);
            $entityManager->flush();
            return $this->redirectToRoute('app_demande_modification_show', ["id"=>$demande->getId()], Response::HTTP_SEE_OTHER);
            
        // return $this->redirectToRoute('n_i_ninea_edit', ["id"=> $niNinea->getId()], Response::HTTP_SEE_OTHER);
    
      
        }
       


       // var_dump($dirigeant);
       return $this->redirectToRoute('app_demande_modification_show', ["id"=>$demande->getId(),"dirigeant"=> $dirigeant->getId()], Response::HTTP_SEE_OTHER);

       //return $this->redirectToRoute('n_i_ninea_edit', ["id"=> $niNinea->getId(),"dirigeant"=> $dirigeant->getId()], Response::HTTP_SEE_OTHER);


    }

   

     /**
     * @Route("/tempsoumission/{id}", name="tempsoumission", methods={"GET","POST"})
     */
    public function tempsoumission(DemandeModification $demandeModification,EntityManagerInterface $entityManager): Response
    {
        $demandeModification->setEtat("c");

        /**on traite la consequence de la demande de reprise sur l'etat de la suspension 
         * on decide de mettre un etat cr == 'consequence de la demande de reactivation ' sur la cessation/suspension precedante 
         */
        $ninea = $demandeModification->getNinea();
        $current_cessation = $entityManager->getRepository(NiCessation::class)->findOneBy(["ninea"=>$ninea]);
        if($current_cessation)
          $current_cessation->setEtat("cr");
        $entityManager->flush();
        return $this->redirectToRoute('suiviDemandeModification', [], Response::HTTP_SEE_OTHER);
        

    }

    /**
     * @Route("/{id}/{dirigeant}", name="app_demande_modification_show", methods={"GET"})
     */
    public function show(DemandeModification $demandeModification,EntityManagerInterface $entityManager,$dirigeant=""): Response
    {
        $nINinea = $demandeModification->getTempNinea();
        $formeunites = $entityManager->getRepository(NiFormeunite::class)->findAll();
        $formejuridiques = $entityManager->getRepository(NiFormejuridique::class)->findAll();
        $regions = $entityManager->getRepository(Region::class)->findAll();
        $departements = $entityManager->getRepository(Departement::class)->findAll();
        $cacrs = $entityManager->getRepository(CACR::class)->findAll();
        $cavs = $entityManager->getRepository(CAV::class)->findAll();
        $departements = $entityManager->getRepository(Departement::class)->findAll();
        $qvhs = $entityManager->getRepository(QVH::class)->findAll();
       
        $sources =  $entityManager->getRepository(NiSourcefinancement::class)->findAll();
        $occupations =  $entityManager->getRepository(NiModaliteexploitation::class)->findAll();
        $natures =  $entityManager->getRepository(NiNatureLocaliteExploitation::class)->findAll();

        $sexe = $entityManager->getRepository(NiSexe::class)->findAll();
        $nationalites = $entityManager->getRepository(Pays::class)->findAll();
        $regions = $entityManager->getRepository(Region::class)->findAll();
        $civilites = $entityManager->getRepository(NiCivilite::class)->findAll();
        $typevoies = $entityManager->getRepository(NiTypevoie::class)->findAll();
        $coordoonnes = $entityManager->getRepository(TempNiCoordonnees::class)->findBy(array("ninNinea"=>$nINinea),array('id'=>'desc'));
        $lastacteEcononomique=$entityManager->getRepository(TempNiActiviteEconomique::class)->findBy(array("niNinea"=>$nINinea),array('id'=>'desc'),1,0);
        if(count($lastacteEcononomique)>0)
          $lastactiviteEco =$lastacteEcononomique[0];
        else
          $lastactiviteEco=null;
        
        $activiteseconmiques = $entityManager->getRepository(TempNiActiviteEconomique::class)->findBy(array("niNinea"=>$nINinea),array('id'=>'desc'));
        

        if(count($coordoonnes)>0)
         $coordoonne =$coordoonnes[0];
        else
         $coordoonne=null;

        
        
        $ninactivites = $entityManager->getRepository(TempNiActivite::class)->findBy(array("niNinea"=>$nINinea),array('statActivprincipale'=>'desc'));
       
        $ninproduits = $entityManager->getRepository(TempNinproduits::class)->findBy(array("nINinea"=>$nINinea));
        
        $activiteglobale = $nINinea->getNiLibelleactiviteglobale();
       
        $naemas = $entityManager->getRepository(NAEMA::class)->findAll();
        $produits = $entityManager->getRepository(RefProduits::class)->findAll();
        $Odirigeant = $entityManager->getRepository(TempNiDirigeant::class)->find($dirigeant);
        
        $Dirigeants = $entityManager->getRepository(TempNiDirigeant::class)->findBy(array("niNinea"=>$nINinea),array('id'=>'desc'));
        $qualifications = $entityManager->getRepository(Qualite::class)->findAll();
        $tempNINinea=$demandeModification->getTempNinea();
        
        return $this->render('demande_modification/show.html.twig', [
            'demande_modification' => $demandeModification,
            'ninea'=>$tempNINinea,
            'tempNINinea'=>$tempNINinea,
            'formeunites' => $formeunites,             
            'Odirigeant' => $Odirigeant,             
            'qualifications' => $qualifications,             
            'Dirigeants' => $Dirigeants,             
            'formejuridiques' => $formejuridiques, 
            'registreCommerce'=>"",
            'regions' => $regions,
            'sources' => $sources,
            'occupations' => $occupations,
            'natures' => $natures,
            'sexes' => $sexe,
            'nationalites' => $nationalites,
            'civilites' => $civilites,
            'typevoies' => $typevoies,
            'departements' => $departements,
            'cacrs' => $cacrs,
            'cavs' => $cavs,
            'qvhs' => $qvhs,
            'coordoonnes'=>$coordoonnes,
            'lastcoordoonnee'=>$coordoonne,
            'lastactiviteEco'=>$lastactiviteEco,
            'activiteseconmiques' => $activiteseconmiques,
            'activiteglobale' => $activiteglobale,
            'naemas' => $naemas,
            'ninactivites' => $ninactivites,
            'ninproduits' => $ninproduits,
            'produits' => $produits,
            'statut' => "c",
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_demande_modification_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, DemandeModification $demandeModification, DemandeModificationRepository $demandeModificationRepository): Response
    {
        $form = $this->createForm(DemandeModificationType::class, $demandeModification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $demandeModificationRepository->add($demandeModification, true);

            return $this->redirectToRoute('app_demande_modification_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('demande_modification/edit.html.twig', [
            'demande_modification' => $demandeModification,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_demande_modification_delete", methods={"POST"})
     */
    public function delete(Request $request, DemandeModification $demandeModification, DemandeModificationRepository $demandeModificationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$demandeModification->getId(), $request->request->get('_token'))) {
            $demandeModificationRepository->remove($demandeModification, true);
        }

        return $this->redirectToRoute('app_demande_modification_index', [], Response::HTTP_SEE_OTHER);
    }
}