<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Entity\Bilan;
use App\Entity\ImmoBrut;
use App\Entity\AchatProduction;
use App\Entity\Effectifs;
use App\Entity\ProductionDeExercice;
use App\Entity\CuciImmoPlus;

use App\Entity\CompteDeResultats;
use App\Entity\FluxDesTresoreries;
use App\Entity\NINinea;
use App\Entity\NiNineaproposition;
use App\Entity\Repertoire;
use App\Entity\User;
use App\Repository\NINineaRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("/accueil")
 * @Security("is_granted('ROLE_CONSULTATION_NINEA') or is_granted('ROLE_BREA_AGENT_SAISIE') or is_granted('ROLE_BSE_AGENT_SAISIE') or is_granted('ROLE_BREA_ADMIN') or is_granted('ROLE_BSE_ADMIN') or is_granted('ROLE_NINEA_ADMIN') or is_granted('ROLE_DEMANDE_NINEA') or is_granted('ROLE_VALIDER_DEMANDE_NINEA')")
 */
class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        ini_set("memory_limit", -1);
        ini_set ( 'max_execution_time', -1);

      

        if ($this->getUser()) {
            $this->getUser()->setNombreEssai(0);
            $entityManager->flush();
        }


        if ($this->getUser()->getPremierConnexion()) {
            return $this->redirectToRoute('user_change_password', ['id'=>$this->getUser()->getId()], Response::HTTP_SEE_OTHER);
        }

        
        //  get nombre de bilan Actif 
        $current_year = date("Y");
        
        // get nb repertoire 
        $nombr_rep = $this->getDoctrine()->getRepository(Repertoire::class)->findNombreDeRepertoireCurrentYear($current_year-1);
        $nombr_rep_miseAjour = $this->getDoctrine()->getRepository(Repertoire::class)->findNombreDeRepertoireCurrentYearMiseAjour($current_year);

        
        $count_bilan_actif = $this->getDoctrine()->getRepository(Bilan::class)->findNombreBilan($current_year-1, 'Actif');
        $count_immoBrut = $this->getDoctrine()->getRepository(ImmoBrut::class)->findNombreBilan($current_year-1);
        $immoPlus = $this->getDoctrine()->getRepository(CuciImmoPlus::class)->findNombreBilan($current_year-1);
        $effectifs = $this->getDoctrine()->getRepository(Effectifs::class)->findNombreEffectif($current_year-1);
        $productionDeExercice = $this->getDoctrine()->getRepository(ProductionDeExercice::class)->findNombreProduction($current_year-1);
        $achatProduction = $this->getDoctrine()->getRepository(AchatProduction::class)->findNombreAchat($current_year-1);
        
        

        //get nombre de bilan passif 
        $count_bilan_passif = $this->getDoctrine()->getRepository(Bilan::class)->findNombreBilan($current_year-1, 'Passif');


        // get nombre d'enregistrement compte de resultat
        $count_compte_result = $this->getDoctrine()->getRepository(CompteDeResultats::class)->findNombreCompteDeResultats($current_year-1);

        
        // get total etat de flux de tresor 
        $count_flux_tresorerie = $this->getDoctrine()->getRepository(FluxDesTresoreries::class)->findNombreFluxDesTresoreries($current_year-1);

        
        // get count all user 
        $count_all_user = $this->getDoctrine()->getRepository(User::class)->findNombreUtilisateurParDivision();


        



        return $this->render('accueil/index.html.twig', [
            'tousRepertoire' => $nombr_rep,
            'tousActif' => $count_bilan_actif,
            'tousPassif' => $count_bilan_passif,
            'touscompteresultat' => $count_compte_result,
            'tousfluxtresorerie' => $count_flux_tresorerie,
            'alluser' => $count_all_user,
            'nombr_rep_miseAjour' => $nombr_rep_miseAjour,
            'immoBrut'=>$count_immoBrut,
            'immoPlus'=>$immoPlus,
            'achatProduction'=>$achatProduction,
            'effectifs'=>$effectifs,
            'productionDeExercice'=>$productionDeExercice,
            
            'annee_financiere' => $current_year-1,
           
            
        ]);
    }


    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboard(EntityManagerInterface $entityManager): Response
    {
        // get nb repertoire 
        $nombr_rep = $this->getDoctrine()->getRepository(Repertoire::class)->findAll();

        return $this->render('accueil/index.html.twig', [
            'tousRepertoires' => count($nombr_rep),
        ]);
    }


     /**
     * @Route("/ninea", name="ninea_accueil")
     */
    public function ninea_accueil(Request $request,EntityManagerInterface $entityManager): Response
    { 

        if ($this->getUser()) {
            $this->getUser()->setNombreEssai(0);
            $entityManager->flush();
        }
       
        if ($this->getUser()->getPremierConnexion()) {
            return $this->redirectToRoute('user_change_passwordNINEA', ['id'=>$this->getUser()->getId()], Response::HTTP_SEE_OTHER);
        }
        
       
        if ($this->IsGranted("ROLE_NINEA_ADMIN" ) || $this->IsGranted("ROLE_DEMANDE_NINEA" ) || $this->IsGranted("ROLE_VALIDER_DEMANDE_NINEA" )){
            
        }else
          return $this->redirectToRoute('n_i_ninea_index2',[], Response::HTTP_SEE_OTHER);
         
        
        $dateDebut="";
        $dateFin="";
        $nbreDemandes = [];
        $nbreDemandesValidees =[];
        $nbreDemandesparAgent =[];
        $nombreDemandesValideeparAgent = [];
        $nbreDemandeEnAttenteParSRSD = [];

        if($request->get("filtrer")){
            $dateDebut=$request->get("dateDebut");
            $dateFin=$request->get("dateFin");

            if ($this->IsGranted("ROLE_NINEA_ADMIN" ) )
            $nbreDemandesValidees = $entityManager->getRepository(NiNineaproposition::class)->findDemandeValideeByCentre($dateDebut,$dateFin);
  
            if ($this->IsGranted("ROLE_NINEA_ADMIN" ))
            
                $nbreDemandesparAgent = $entityManager->getRepository(NiNineaproposition::class)->findDemandeValideeByUser(null,$dateDebut,$dateFin);
        
            if ($this->IsGranted("ROLE_NINEA_ADMIN" ))
                $nombreDemandesValideeparAgent = $entityManager->getRepository(NINinea::class)->findValidationByUser2($dateDebut,$dateFin);
        } else 
        {
            if ($this->IsGranted("ROLE_NINEA_ADMIN" ) || $this->IsGranted("ROLE_VALIDER_DEMANDE_NINEA"))
                $nbreDemandesValidees = $entityManager->getRepository(NiNineaproposition::class)->findDemandeValideeByCentre(null,null);
            
            if ($this->IsGranted("ROLE_NINEA_ADMIN") || $this->IsGranted("ROLE_DEMANDE_NINEA"))                
                $nbreDemandesparAgent = $entityManager->getRepository(NiNineaproposition::class)->findDemandeValideeByUser($this->getUser(), null, null);

            if ($this->IsGranted("ROLE_NINEA_ADMIN") || $this->IsGranted("ROLE_DEMANDE_NINEA"))
                $nbreDemandes = $entityManager->getRepository(NiNineaproposition::class)->findDemandesByUser($this->getUser(), null, null);
        
            if ($this->IsGranted("ROLE_NINEA_ADMIN"))
                $nombreDemandesValideeparAgent = $entityManager->getRepository(NINinea::class)->findValidationByUser2(null,null);

            if ($this->IsGranted("ROLE_NINEA_ADMIN"|| $this->IsGranted("ROLE_VALIDER_DEMANDE_NINEA") ))
            {
                $nbreDemandeEnAttenteParSRSD = $entityManager->getRepository(NiNineaproposition::class)->findDemandeEnAttenteByCentre();
            }
        }

       

        $session = new Session();
        
        $demandes_rejetees = count($entityManager->getRepository(NiNineaproposition::class)->findByDemande($this->getUser(), 'r'));

        $demandes_validees = count($entityManager->getRepository(NiNineaproposition::class)->findByDemande($this->getUser(), 'v'));
        
        $demandes_encoursvalidation = count($entityManager->getRepository(NiNineaproposition::class)->findByDemandeEnValidation('c'));

        
        $session->set("rejeter", $demandes_rejetees);

        $session->set("valider", $demandes_validees);
        
        $session->set("en_validation", $demandes_encoursvalidation);
        
        $conn = $this->getDoctrine()->getManager()->getConnection(); // cree la cnx 
        
        // total demande envoyees par agent/user
        $req = "SELECT count(created_by_id) as totaldmd FROM ni_nineaproposition as nin WHERE nin.created_by_id='".$this->getUser()->getId()."';";
        
        // total demande en atteente par agent/user
        $req_sql = "SELECT count(created_by_id) as totaldmdStandby FROM ni_nineaproposition as nin WHERE nin.created_by_id='".$this->getUser()->getId()."' AND nin.statut='c';";
        
        $dbChanges = $conn->prepare($req);


        $stmt=$dbChanges->executeQuery();

        // dd($stmt);
        $req_sql = $conn->prepare($req_sql);

        
        $stmt=$dbChanges->executeQuery();
        $req_sql=$req_sql->executeQuery();

        
        /**
         * determiner ici le delai d'attente 2j des demandes en statut C
         */
        
        $obj = $entityManager->getRepository(NiNineaproposition::class)->findByDemandeEnValidation('c');

        $tabObj = [];

        foreach ($obj as $key ) {

            if ($this->nbrJoursAttendu($key->getUpdatedAt())>=2) {
                array_push($tabObj,[$key->getNinnumerodemande(),$key->getStatut(),$key->getUpdatedAt(), $this->nbrJoursAttendu($key->getUpdatedAt())]);
            }

        }
        
        if($session->has('delais')) {
            // $this->monPanier = $this->session->get('monPanier');
            $session->remove('delais');
        }
        
        $session->set("delais", count($tabObj));
        
        $formeunites=$entityManager->getRepository(NINinea::class)->findbyformeUnite();
        

        return $this->render('accueil/ninea_accueil.html.twig', [
            "nbreDemandesValidees"=>$nbreDemandesValidees,
            "nbreDemandesparAgent" => $nbreDemandesparAgent,
            "nbreDemandes" => $nbreDemandes,
            "nombreDemandesValideesparAgent" => $nombreDemandesValideeparAgent,
            "nbreDemandeEnAttenteParSRSD" => $nbreDemandeEnAttenteParSRSD,
            "dateDebut" => $dateDebut,
            "dateFin" => $dateFin,
            "totalDemandeValide" =>  count($entityManager->getRepository(NINinea::class)->findBy(array("ninStatut" => "v"))),
            "nbDemandesR" => $demandes_rejetees,
            "nbDemandesV" => $demandes_validees,
            "nbDemandesC" => $demandes_encoursvalidation,
            "nbDemandesE" => $stmt->fetch(),
            "totaldmdStandby" => $req_sql->fetch(),
            "delais" => count($tabObj),
            "formeunites"=>$formeunites
        ]);
    }



    /**
     * cette fonction retourne le delai d'attente en nombre de jour d'une demande depuis sa date de mise a jour 
     */
    public function nbrJoursAttendu($dateTime): int
    {
        $earlier = new DateTime("now");  // date d'aujourd8

        //$later = $found_one_user->getDateExpiration(); // plutard

        if (!$dateTime) {
            $abs_diff = 0;
        }else {
            $abs_diff = $dateTime->diff($earlier)->format("%r%a");
        }


        return $abs_diff;
    }


}