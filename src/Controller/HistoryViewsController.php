<?php

namespace App\Controller;

use App\Entity\CACR;
use App\Entity\CAV;
use App\Entity\Departement;
use App\Entity\HistoryNiActivite;
use App\Entity\HistoryNiActiviteEconomique;
use App\Entity\HistoryNiCoordonnees;
use App\Entity\HistoryNiDirigeant;
use App\Entity\HistoryNINinea;
use App\Entity\HistoryNinproduits;
use App\Entity\HistoryNiPersonne;
use App\Entity\NAEMA;
use App\Entity\NiActivite;
use App\Entity\NiActiviteEconomique;
use App\Entity\NiCivilite;
use App\Entity\NiCoordonnees;
use App\Entity\NiDirigeant;
use App\Entity\NiFormejuridique;
use App\Entity\NiFormeunite;
use App\Entity\NINinea;
use App\Entity\NiNineaproposition;
use App\Entity\Ninproduits;
use App\Entity\NiSexe;
use App\Entity\NiTypevoie;
use App\Entity\Pays;
use App\Entity\Qualite;
use App\Entity\QVH;
use App\Entity\RefProduits;
use App\Entity\Region;
use App\Entity\TempNiActivite;
use App\Entity\TempNiActiviteEconomique;
use App\Entity\TempNiCoordonnees;
use App\Entity\TempNiDirigeant;
use App\Entity\TempNINinea;
use App\Entity\TempNiNineaproposition;
use App\Entity\TempNinproduits;
use App\Entity\TempNiPersonne;
use App\Repository\HistoryNINineaRepository;
use App\Repository\NINineaRepository;
use App\Repository\TempNiNineaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * @Route("/ninea/history")
 * @Security("is_granted('ROLE_CONSULTATION_NINEA') or is_granted('ROLE_DEMANDE_NINEA') or is_granted('ROLE_VALIDER_DEMANDE_NINEA') or is_granted('ROLE_NINEA_ADMIN')")
 */
class HistoryViewsController extends AbstractController
{
    /**
     * @Route("/views", name="app_history_views")
     */
    public function index(EntityManagerInterface $entityManager, HistoryNINineaRepository $historyniniearep, Request $request): Response
    {

      $id = "";
      $dateDebut = "";
      $dateFin = "";

      $historyninea = "";
      
      if ($request->get("filtreModif") ) {
        
        $id = $request->get('numNinea');
        $dateDebut = $request->get('datedebutModif');
        $dateFin = $request->get('datefinModif');
        
        $historyninea = $historyniniearep->distinctGroupTempNINinea($id, $dateDebut, $dateFin);
        
        if (count($historyninea) < 1 )
        {
          $request->getSession()->getFlashBag()->add('messageDonnee',"Aucune donnée trouvée.");
          
        }else {
          return $this->render('history_views/index.html.twig', [
            'controller_name' => 'HistoryViewsController',
            'historynineas' => $historyninea,
        ]);

        }
        
      }else {
        
       //  $historyninea = $historyniniearep->distinctGroupTempNINineaNoFilter();
        $historyninea = $historyniniearep->distinctHistoryNINinea(); 
      }


      $Tabhistoryninea = [] ; 

      // ici faut tester si ceci $historyninea est un tableau ou pas 
      if (is_array($historyninea)) {

        foreach ($historyninea as $key ) {
          $obj = $key['ninNinea'];
  
          $obj_history_corr = $entityManager->getRepository(HistoryNINinea::class)->findOneBy(["ninNinea"=>$obj]);
  
          array_push($Tabhistoryninea, $obj_history_corr);
        }
      }else {
        $Tabhistoryninea =  $historyninea;
      }


        return $this->render('history_views/index.html.twig', [
            'controller_name' => 'HistoryViewsController',
            'historynineas' => $Tabhistoryninea,
        ]);
    }




    /**
     * @Route("/nineaHistoryListRecapHistory/{id}", name="app_history_ninea_list_RecapHistory", methods={"GET", "POST"})
     */
    public function historyNineaListRecapHistory( $coordonnee="", $dirigeant="", $activiteEco="", NINineaRepository $nINineaRepository, Request $request, EntityManagerInterface $entityManager,$id=""): Response
    {

        /* TODO comment recuperer les donnes historisees 
        $gedmo = $this->getDoctrine()->getRepository("Gedmo\Loggable\Entity\LogEntry"::class);   
        
        $nineapropsition = $this->getDoctrine()->getRepository(NiNineaproposition::class)->find(181);
        
        $logs = $gedmo->getLogEntries($nineapropsition);
        
        dd($logs);
        $tab = [];
        
        foreach($logs as $logData){
            array_push($tab, [$logData->getData(), $logData->getVersion(), $logData->getUsername()]);
        }
        */

        // $historyninea = $entityManager->getRepository(TempNINinea::class)->findBy(['ninNinea'=>"000000331"]);


        $ninea = $entityManager->getRepository(NINinea::class)->findOneBy(["ninNinea"=>$id]);

        // on recupere sa premiere historisation 

        $obj_history_corr = $entityManager->getRepository(HistoryNINinea::class)->findOneBy(["ninNinea"=>$ninea->getNinNinea()]);
        
        $Odirigeant = $entityManager->getRepository(NiDirigeant::class)->find($dirigeant);
        $Oactiviteeconomique = $entityManager->getRepository(NiActiviteEconomique::class)->find($activiteEco);
        $Ocooedonnee = $entityManager->getRepository(NiCoordonnees::class)->find($coordonnee);
        //var_dump($ninea);
        $nineaproposition = $this->getDoctrine()->getRepository(NiNineaproposition::class)->findOneBy(["ninNinea" =>$ninea->getNinNinea() ]);
        
        $typevoies = $entityManager->getRepository(NiTypevoie::class)->findAll();
       
        $regions = $entityManager->getRepository(Region::class)->findAll();
        $departements = $entityManager->getRepository(Departement::class)->findAll();
        $cacrs = $entityManager->getRepository(CACR::class)->findAll();
        $cavs = $entityManager->getRepository(CAV::class)->findAll();
        $departements = $entityManager->getRepository(Departement::class)->findAll();
        $qvhs = $entityManager->getRepository(QVH::class)->findAll();

        $sexe = $entityManager->getRepository(NiSexe::class)->findAll();
        $nationalites = $entityManager->getRepository(Pays::class)->findAll();
        $regions = $entityManager->getRepository(Region::class)->findAll();
        $civilites = $entityManager->getRepository(NiCivilite::class)->findAll();
        $typevoies = $entityManager->getRepository(NiTypevoie::class)->findAll();
        $produits = $entityManager->getRepository(RefProduits::class)->findAll();
        $qualifications = $entityManager->getRepository(Qualite::class)->findAll();
        $naemas = $entityManager->getRepository(NAEMA::class)->findAll();


        $ninactivites = $entityManager->getRepository(NiActivite::class)->findBy(array("nINinea"=>$ninea),array('statActivprincipale'=>'desc'));
        $ninproduits = $entityManager->getRepository(Ninproduits::class)->findBy(array("nINinea"=>$ninea));


        $lastcoordoonnees=$entityManager->getRepository(NiCoordonnees::class)->findBy(array("ninNinea"=>$ninea),array('id'=>'desc'),1,0);
        //var_dump($dirigeant);
        $coordoonnes = $entityManager->getRepository(NiCoordonnees::class)->findBy(array("ninNinea"=>$ninea),array('id'=>'desc'));

        $lastacteEcononomique=$entityManager->getRepository(NiActiviteEconomique::class)->findBy(array("nINinea"=>$ninea),array('id'=>'desc'),1,0);
        $activiteseconmiques = $entityManager->getRepository(NiActiviteEconomique::class)->findBy(array("nINinea"=>$ninea),array('id'=>'desc'));

        $Dirigeants = $entityManager->getRepository(NiDirigeant::class)->findBy(array("nINinea"=>$ninea),array('id'=>'desc'));

        if($Oactiviteeconomique!=null){
            $lastactiviteEco=$Oactiviteeconomique;
        }
        else{
            if(count($lastacteEcononomique)>0)
              $lastactiviteEco=$lastacteEcononomique[0];
            else
             $lastactiviteEco=null; 
        }

        
        if($Ocooedonnee!=null){
            $lastcoordoonnee=$Ocooedonnee;
        }
        else{
          if(count($lastcoordoonnees)>0)
            $lastcoordoonnee=$lastcoordoonnees[0];
          else
            $lastcoordoonnee=null;
            
        }
        

        //liste etablissements secondaires
        $nineaLength = strlen($ninea->getNinNinea() );
        $nineafils=[];
        $nineamere=null;
        if($nineaLength == 9)
        {

          $nineafils =$entityManager->getRepository(NINinea::class)->findETSByNineamere($ninea->getNinNinea());

        }else{
           $nineamere = substr($ninea->getNinNinea(),0, 9);  
          $nineamere = $entityManager->getRepository(NINinea::class)->findOneBy(["ninNinea" =>$nineamere ]);
          //dd($nineamere);
        }
       
        
        //libelle de l' activité globale
        $activiteglobale = $ninea->getNiLibelleactiviteglobale();

        // obtenir un tableau des dates de modification
        $tabEditedAt = [];
        
        $historyninea = $entityManager->getRepository(TempNINinea::class)->findBy(["ninNinea"=>str_replace(" ", "", $ninea->getNinNinea())], array("id"=>"DESC"));
                
        /*if($historyninea){
          foreach ($historyninea as $key => $obj) {
            array_push($tabEditedAt, ["editedAt"=>$obj->getCreatedAt(), "identity"=>$obj->getId(), "ninNinea"=>$obj->getNinNinea()]);
          }
        }*/
        
        // dd($tabEditedAt[0]['updatedAt']);
      
        return $this->render('history_views/_partialShowRecapHistory.html.twig', [
            'ninea' => $ninea,
            'nineaproposition' => $nineaproposition,
            'regions' => $regions,
            'sexes' => $sexe,
            'nationalites' => $nationalites,
            'civilites' => $civilites,
            'typevoies' => $typevoies,
            'departements' => $departements,
            'cacrs' => $cacrs,
            'cavs' => $cavs,
            'qvhs' => $qvhs,
            'produits' => $produits,
            'lastcoordoonnee' => $lastcoordoonnee,
            'coordoonnes'  => $coordoonnes,
            'lastactiviteEco' => $lastactiviteEco,
            'activiteseconmiques'  => $activiteseconmiques,
            'Dirigeants'  => $Dirigeants,
            'qualifications' => $qualifications,
            'Odirigeant' => $Odirigeant,
            'ninproduits' => $ninproduits,
            'ninactivites' => $ninactivites,
            'naemas' => $naemas,
            'nineafils'  => $nineafils,
            "nineamere"  => $nineamere,
            "activiteglobale"  => $activiteglobale,
            "tabEditedAts"  => $historyninea,
            "objHistoryCorr"  => $obj_history_corr,

        ]);

    }


    /**
     * @Route("/nineaHistoryList/{id}", name="app_history_ninea_list", methods={"GET", "POST"})
     */
    public function historyNineaList($id="", $coordonnee="", $dirigeant="", $activiteEco="", NINineaRepository $nINineaRepository, Request $request, EntityManagerInterface $entityManager): Response
    {

        /* TODO comment recuperer les donnes historisees 
        $gedmo = $this->getDoctrine()->getRepository("Gedmo\Loggable\Entity\LogEntry"::class);   
        
        $nineapropsition = $this->getDoctrine()->getRepository(NiNineaproposition::class)->find(181);
        
        $logs = $gedmo->getLogEntries($nineapropsition);
        
        dd($logs);
        $tab = [];
        
        foreach($logs as $logData){
            array_push($tab, [$logData->getData(), $logData->getVersion(), $logData->getUsername()]);
        }
        */

        // $historyninea = $entityManager->getRepository(TempNINinea::class)->findBy(['ninNinea'=>"000000331"]);

        $date_de_modification =  $request->get('inputDate_modification'); 
        
        
        
        
        // $ninea = $entityManager->getRepository(NINinea::class)->findOneBy(["ninNinea"=>$id]);
        $ninea = $entityManager->getRepository(TempNINinea::class)->find($id);

        // on recupere sa premiere historisation 

        $obj_history_corr = $entityManager->getRepository(HistoryNINinea::class)->findOneBy(["ninNinea"=>$ninea->getNinNinea()]);


        $Odirigeant = $entityManager->getRepository(TempNiDirigeant::class)->find($dirigeant);
        $Oactiviteeconomique = $entityManager->getRepository(TempNiActiviteEconomique::class)->find($activiteEco);
        $Ocooedonnee = $entityManager->getRepository(TempNiCoordonnees::class)->find($coordonnee);
        
        $typevoies = $entityManager->getRepository(NiTypevoie::class)->findAll();
        
        $regions = $entityManager->getRepository(Region::class)->findAll();
        $departements = $entityManager->getRepository(Departement::class)->findAll();
        $cacrs = $entityManager->getRepository(CACR::class)->findAll();
        $cavs = $entityManager->getRepository(CAV::class)->findAll();
        $departements = $entityManager->getRepository(Departement::class)->findAll();
        $qvhs = $entityManager->getRepository(QVH::class)->findAll();
        
        $sexe = $entityManager->getRepository(NiSexe::class)->findAll();
        $nationalites = $entityManager->getRepository(Pays::class)->findAll();
        $regions = $entityManager->getRepository(Region::class)->findAll();
        $civilites = $entityManager->getRepository(NiCivilite::class)->findAll();
        $typevoies = $entityManager->getRepository(NiTypevoie::class)->findAll();
        $produits = $entityManager->getRepository(RefProduits::class)->findAll();
        $qualifications = $entityManager->getRepository(Qualite::class)->findAll();
        $naemas = $entityManager->getRepository(NAEMA::class)->findAll();

        
        $ninactivites = $entityManager->getRepository(TempNiActivite::class)->findBy(array("niNinea"=>$ninea),array('statActivprincipale'=>'desc'));
        $ninproduits = $entityManager->getRepository(TempNinproduits::class)->findBy(array("nINinea"=>$ninea));
        
        
        $lastcoordoonnees=$entityManager->getRepository(TempNiCoordonnees::class)->findBy(array("ninNinea"=>$ninea),array('id'=>'desc'),1,0);
        //var_dump($dirigeant);
        $coordoonnes = $entityManager->getRepository(TempNiCoordonnees::class)->findBy(array("ninNinea"=>$ninea),array('id'=>'desc'));
        
        $lastacteEcononomique=$entityManager->getRepository(TempNiActiviteEconomique::class)->findBy(array("niNinea"=>$ninea),array('id'=>'desc'),1,0);
        $activiteseconmiques = $entityManager->getRepository(TempNiActiviteEconomique::class)->findBy(array("niNinea"=>$ninea),array('id'=>'desc'));
        
        $Dirigeants = $entityManager->getRepository(TempNiDirigeant::class)->findBy(array("niNinea"=>$ninea),array('id'=>'desc'));


        $Personnes = $entityManager->getRepository(TempNiPersonne::class)->findBy(array("ninNinea"=>$ninea),array('id'=>'desc'));


        if($Oactiviteeconomique!=null){
            $lastactiviteEco=$Oactiviteeconomique;
        }
        else{
            if(count($lastacteEcononomique)>0)
              $lastactiviteEco=$lastacteEcononomique[0];
            else
             $lastactiviteEco=null; 
        }

        
        if($Ocooedonnee!=null){
            $lastcoordoonnee=$Ocooedonnee;
        }
        else{
          if(count($lastcoordoonnees)>0)
            $lastcoordoonnee=$lastcoordoonnees[0];
          else
            $lastcoordoonnee=null;
            
        }
        

        //liste etablissements secondaires
        $nineaLength = strlen($ninea->getNinNinea() );
        $nineafils=[];
        $nineamere=null;
        if($nineaLength == 9)
        {

          $nineafils =$entityManager->getRepository(NINinea::class)->findETSByNineamere($ninea->getNinNinea());

        }else{
           $nineamere = substr($ninea->getNinNinea(),0, 9);  
          $nineamere = $entityManager->getRepository(NINinea::class)->findOneBy(["ninNinea" =>$nineamere ]);
          //dd($nineamere);
        }
       
        
        //libelle de l' activité globale
        $activiteglobale = $ninea->getNiLibelleactiviteglobale();

        // obtenir un tableau des dates de modification
        $tabEditedAt = [];
        
        $historyninea = $entityManager->getRepository(TempNINinea::class)->findBy(["ninNinea"=>str_replace(" ", "", $ninea->getNinNinea())], array('id' => "DESC" ));
        
        
        /*if($historyninea){
          foreach ($historyninea as $key => $obj) {
            array_push($tabEditedAt, ["editedAt"=>$obj->getCreatedAt(), "identity"=>$obj->getId(), "ninNinea"=>$obj->getNinNinea()]);
          }
        }*/
        
        // dd($tabEditedAt[0]['updatedAt']);
      
        return $this->render('history_views/_partialShow.html.twig', [
            'ninea' => $ninea,
            'personne' => $Personnes[0],
            'regions' => $regions,
            'sexes' => $sexe,
            'nationalites' => $nationalites,
            'civilites' => $civilites,
            'typevoies' => $typevoies,
            'departements' => $departements,
            'cacrs' => $cacrs,
            'cavs' => $cavs,
            'qvhs' => $qvhs,
            'produits' => $produits,
            'lastcoordoonnee' => $lastcoordoonnee,
            'coordoonnes'  => $coordoonnes,
            'lastactiviteEco' => $lastactiviteEco,
            'activiteseconmiques'  => $activiteseconmiques,
            'Dirigeants'  => $Dirigeants,
            'qualifications' => $qualifications,
            'Odirigeant' => $Odirigeant,
            'ninproduits' => $ninproduits,
            'ninactivites' => $ninactivites,
            'naemas' => $naemas,
            'nineafils'  => $nineafils,
            "nineamere"  => $nineamere,
            "activiteglobale"  => $activiteglobale,
            "tabEditedAts"  => $historyninea,
            "objHistoryCorr"  => $obj_history_corr,

        ]);

    }



    /**
     * @Route("/nineaHistoryFirstList/{id}", name="app_history_ninea_first_list", methods={"GET", "POST"})
     */
    public function historyNineaFirstList($id="", $coordonnee="", $dirigeant="", $activiteEco="", NINineaRepository $nINineaRepository, Request $request, EntityManagerInterface $entityManager): Response
    {


        
        
        // $ninea = $entityManager->getRepository(NINinea::class)->findOneBy(["ninNinea"=>$id]);
        $ninea = $entityManager->getRepository(HistoryNINinea::class)->find($id);

        // on recupere sa premiere historisation 

        $obj_history_corr = $entityManager->getRepository(HistoryNINinea::class)->findOneBy(["ninNinea"=>$ninea->getNinNinea()]);

        $Odirigeant = $entityManager->getRepository(HistoryNiDirigeant::class)->find($dirigeant);
        $Oactiviteeconomique = $entityManager->getRepository(HistoryNiActiviteEconomique::class)->find($activiteEco);
        $Ocooedonnee = $entityManager->getRepository(HistoryNiCoordonnees::class)->find($coordonnee);
        
        $typevoies = $entityManager->getRepository(NiTypevoie::class)->findAll();
        
        $regions = $entityManager->getRepository(Region::class)->findAll();
        $departements = $entityManager->getRepository(Departement::class)->findAll();
        $cacrs = $entityManager->getRepository(CACR::class)->findAll();
        $cavs = $entityManager->getRepository(CAV::class)->findAll();
        $departements = $entityManager->getRepository(Departement::class)->findAll();
        $qvhs = $entityManager->getRepository(QVH::class)->findAll();
        
        $sexe = $entityManager->getRepository(NiSexe::class)->findAll();
        $nationalites = $entityManager->getRepository(Pays::class)->findAll();
        $regions = $entityManager->getRepository(Region::class)->findAll();
        $civilites = $entityManager->getRepository(NiCivilite::class)->findAll();
        $typevoies = $entityManager->getRepository(NiTypevoie::class)->findAll();
        $produits = $entityManager->getRepository(RefProduits::class)->findAll();
        $qualifications = $entityManager->getRepository(Qualite::class)->findAll();
        $naemas = $entityManager->getRepository(NAEMA::class)->findAll();

        
        $ninactivites = $entityManager->getRepository(HistoryNiActivite::class)->findBy(array("niNinea"=>$ninea),array('statActivprincipale'=>'desc'));
        $ninproduits = $entityManager->getRepository(HistoryNinproduits::class)->findBy(array("niNinea"=>$ninea));
        
        
        $lastcoordoonnees=$entityManager->getRepository(HistoryNiCoordonnees::class)->findBy(array("ninNinea"=>$ninea),array('id'=>'desc'),1,0);
        //var_dump($dirigeant);
        $coordoonnes = $entityManager->getRepository(HistoryNiCoordonnees::class)->findBy(array("ninNinea"=>$ninea),array('id'=>'desc'));
        
        $lastacteEcononomique=$entityManager->getRepository(HistoryNiActiviteEconomique::class)->findBy(array("niNinea"=>$ninea),array('id'=>'desc'),1,0);
        $activiteseconmiques = $entityManager->getRepository(HistoryNiActiviteEconomique::class)->findBy(array("niNinea"=>$ninea),array('id'=>'desc'));
        
        $Dirigeants = $entityManager->getRepository(HistoryNiDirigeant::class)->findBy(array("niNinea"=>$ninea),array('id'=>'desc'));

        // $Personnes = $entityManager->getRepository(HistoryNiPersonne::class)->find($ninea->getHistoryNiPersonne()->getId());

        $Personnes []= $ninea->getHistoryNiPersonne();


        if($Oactiviteeconomique!=null){
            $lastactiviteEco=$Oactiviteeconomique;
        }
        else{
            if(count($lastacteEcononomique)>0)
              $lastactiviteEco=$lastacteEcononomique[0];
            else
             $lastactiviteEco=null; 
        }

        
        if($Ocooedonnee!=null){
            $lastcoordoonnee=$Ocooedonnee;
        }
        else{
          if(count($lastcoordoonnees)>0)
            $lastcoordoonnee=$lastcoordoonnees[0];
          else
            $lastcoordoonnee=null;
            
        }
        

        //liste etablissements secondaires
        $nineaLength = strlen($ninea->getNinNinea() );
        $nineafils=[];
        $nineamere=null;
        if($nineaLength == 9)
        {

          $nineafils =$entityManager->getRepository(NINinea::class)->findETSByNineamere($ninea->getNinNinea());

        }else{
           $nineamere = substr($ninea->getNinNinea(),0, 9);  
          $nineamere = $entityManager->getRepository(NINinea::class)->findOneBy(["ninNinea" =>$nineamere ]);
          //dd($nineamere);
        }
       
        
        //libelle de l' activité globale
        $activiteglobale = $ninea->getNiLibelleactiviteglobale();

        // obtenir un tableau des dates de modification
        $tabEditedAt = [];
        
        $historyninea = $entityManager->getRepository(TempNINinea::class)->findBy(["ninNinea"=>str_replace(" ", "", $ninea->getNinNinea())], array('id' => "DESC" ));
        
        
        /*if($historyninea){
          foreach ($historyninea as $key => $obj) {
            array_push($tabEditedAt, ["editedAt"=>$obj->getCreatedAt(), "identity"=>$obj->getId(), "ninNinea"=>$obj->getNinNinea()]);
          }
        }*/
        
        // dd($tabEditedAt[0]['updatedAt']);
      
        return $this->render('history_views/_partialFirstShow.html.twig', [
            'ninea' => $ninea,
            'personne' => $Personnes[0],
            'regions' => $regions,
            'sexes' => $sexe,
            'nationalites' => $nationalites,
            'civilites' => $civilites,
            'typevoies' => $typevoies,
            'departements' => $departements,
            'cacrs' => $cacrs,
            'cavs' => $cavs,
            'qvhs' => $qvhs,
            'produits' => $produits,
            'lastcoordoonnee' => $lastcoordoonnee,
            'coordoonnes'  => $coordoonnes,
            'lastactiviteEco' => $lastactiviteEco,
            'activiteseconmiques'  => $activiteseconmiques,
            'Dirigeants'  => $Dirigeants,
            'qualifications' => $qualifications,
            'Odirigeant' => $Odirigeant,
            'ninproduits' => $ninproduits,
            'ninactivites' => $ninactivites,
            'naemas' => $naemas,
            'nineafils'  => $nineafils,
            "nineamere"  => $nineamere,
            "activiteglobale"  => $activiteglobale,
            "tabEditedAts"  => $historyninea,
            "objHistoryCorr"  => $obj_history_corr,

        ]);

    }




     /**
     * @Route("/editEntete/{id}", name="app_history_views_editEntete", methods={"GET", "POST"})
     */
    public function modifierEntete(Request $request, EntityManagerInterface $entityManager, NINinea $ninea): Response
    {    


      $ninea->setNinmajdate(new \DateTime());

      $session=new Session();
      $session->set('actived',"");
      
       $ninRegcom = "";
       $ninDatreg = "";

      if ($request->get('modifierEntete')) {


          $ninEnseigne = $request->get('ninEnseigne');
          $ninDatreg = $request->get('ninDatreg');
          $ninRegcom= $request->get('ni_nineaproposition_ninRegcom');

          $ninea->setNinEnseigne($ninEnseigne);
          $ninea->setNinDatreg(new \DateTime($ninDatreg));
          $ninea->setNinRegcom( str_replace("_","",$ninRegcom));

          $entityManager->flush();

        }

        return $this->redirectToRoute('app_history_views_show', ["id"=>$ninea->getId()], Response::HTTP_SEE_OTHER);
      
      

    }


     /**
     * @Route("/show/{id}", name="app_history_views_show", methods={"GET", "POST"})
     */
    public function modifier_Ninea(Request $request,  $id="", EntityManagerInterface $entityManager, $dirigeant=""): Response
    {
        $nINinea = $entityManager->getRepository(NINinea::class)->find($id);
        $formeunites = $entityManager->getRepository(NiFormeunite::class)->findAll();
        $formejuridiques = $entityManager->getRepository(NiFormejuridique::class)->findAll();
        $regions = $entityManager->getRepository(Region::class)->findAll();
        $departements = $entityManager->getRepository(Departement::class)->findAll();
        $cacrs = $entityManager->getRepository(CACR::class)->findAll();
        $cavs = $entityManager->getRepository(CAV::class)->findAll();
        $departements = $entityManager->getRepository(Departement::class)->findAll();
        $qvhs = $entityManager->getRepository(QVH::class)->findAll();

        $sexe = $entityManager->getRepository(NiSexe::class)->findAll();
        $nationalites = $entityManager->getRepository(Pays::class)->findAll();
        $regions = $entityManager->getRepository(Region::class)->findAll();
        $civilites = $entityManager->getRepository(NiCivilite::class)->findAll();
        $typevoies = $entityManager->getRepository(NiTypevoie::class)->findAll();
        $coordoonnes = $entityManager->getRepository(NiCoordonnees::class)->findBy(array("ninNinea"=>$nINinea),array('id'=>'desc'));
        $lastacteEcononomique=$entityManager->getRepository(NiActiviteEconomique::class)->findBy(array("nINinea"=>$nINinea),array('id'=>'desc'),1,0);
        if(count($lastacteEcononomique)>0)
          $lastactiviteEco =$lastacteEcononomique[0];
        else
          $lastactiviteEco=null;
        
        $activiteseconmiques = $entityManager->getRepository(NiActiviteEconomique::class)->findBy(array("nINinea"=>$nINinea),array('id'=>'desc'));
        

        if(count($coordoonnes)>0)
         $coordoonne =$coordoonnes[0];
        else
         $coordoonne=null;
        
        $ninactivites = $entityManager->getRepository(NiActivite::class)->findBy(array("nINinea"=>$nINinea),array('statActivprincipale'=>'desc'));
        $ninproduits = $entityManager->getRepository(Ninproduits::class)->findBy(array("nINinea"=>$nINinea));
        $activiteglobale = $nINinea->getNiLibelleactiviteglobale();
        $naemas = $entityManager->getRepository(NAEMA::class)->findAll();
        $produits = $entityManager->getRepository(RefProduits::class)->findAll();

        return $this->render('history_views/_partialShow.html.twig', [
            'ninea' => $nINinea,
            'formeunites' => $formeunites,             
            'formejuridiques' => $formejuridiques, 
            'registreCommerce'=>"",
            'regions' => $regions,
            'sexes' => $sexe,
            'nationalites' => $nationalites,
            'civilites' => $civilites,
            'typevoies' => $typevoies,
            'departements' => $departements,
            'cacrs' => $cacrs,
            'cavs' => $cavs,
            'qvhs' => $qvhs,
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
       
     //   return $this->renderForm('ni_ninea/edit.html.twig', [
     //       'n_i_ninea' => $nINinea,
         //   'form' => $form,
     //   ]);
    }


    
     /**
     * @Route("/extLogEntriesNineas", name="app_history_extLogEntriesNineas", methods={"GET", "POST"})
     */
    public function extLogEntriesNineas() : Response
    {

      $data = [];

      /* TODO comment recuperer les donnes historisees */
      $gedmo = $this->getDoctrine()->getRepository("Gedmo\Loggable\Entity\LogEntry"::class);   
      
      $nineapropsition = $this->getDoctrine()->getRepository(NiNineaproposition::class)->find(168);
      $nineaNin = $this->getDoctrine()->getRepository(NINinea::class)->find(42);

      $logs = $gedmo->getLogEntries($nineaNin);

      $tab = [];

      foreach($logs as $logData){
        // array_push($tab, [$logData->getData(), $logData->getVersion(), $logData->getUsername()]);

        foreach ($logData->getData() as $key) {
          array_push($tab, ["index"=>$key]);
        }
      }

    
      return $this->json($tab,200, []);
    }
    
}
