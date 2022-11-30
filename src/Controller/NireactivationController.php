<?php

namespace App\Controller;

use App\Entity\CACR;
use App\Entity\CAV;
use App\Entity\DemandeModification;
use App\Entity\Departement;
use App\Entity\NAEMA;
use App\Entity\NiActivite;
use App\Entity\NiActiviteEconomique;
use App\Entity\NiCessation;
use App\Entity\NiCivilite;
use App\Entity\NiCoordonnees;
use App\Entity\NiDirigeant;
use App\Entity\NiFormejuridique;
use App\Entity\NiFormeunite;
use App\Entity\Nireactivation;
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
use App\Entity\TempNinproduits;
use App\Entity\TempNiPersonne;
use App\Form\NireactivationType;
use App\Repository\NINineaRepository;
use App\Repository\NireactivationRepository;
use App\Services\QrcodeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Knp\Snappy\Pdf;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @Route("/nireactivation")
 * @Security("is_granted('ROLE_DEMANDE_NINEA') or is_granted('ROLE_VALIDER_DEMANDE_NINEA') or is_granted('ROLE_NINEA_ADMIN')")
 */
class NireactivationController extends AbstractController
{
    /**
     * cette action permettra de lister de Suivi des reactivations pour l'utilisateur
     * @Route("/", name="app_nireactivation_index", methods={"GET"})
     */
    public function index(NireactivationRepository $nireactivationRepository, AuthorizationCheckerInterface $autorization, EntityManagerInterface $entityManager): Response
    {

        $demande_de_reprise = "";

        if ($autorization->isGranted('ROLE_DEMANDE_NINEA')) {
            $demande_de_reprise = $entityManager->getRepository(DemandeModification::class)->findBy(["typeDemande"=>"3", "createdBy"=>$this->getUser()], array("id"=>"DESC"));
        }
        
        if ($autorization->isGranted('ROLE_NINEA_ADMIN') || $autorization->isGranted('ROLE_VALIDER_DEMANDE_NINEA')) {
            // separer la visualisation de l historique selon profile agent repertoire / agent etat financier
            // la liste des demande de reactivation en attente de validation seulement pour le profile Validateur
            $demande_de_reprise = $entityManager->getRepository(DemandeModification::class)->findBy(["typeDemande"=>"3", "etat"=>array("a", "c", "v", "t", "r")], array("id"=>"DESC"));
        }        
        
        return $this->render('nireactivation/index.html.twig', [
            'nireactivations' => $demande_de_reprise,
        ]);
    }


    /**
     * retourner la liste des NINEAs suspendus
     * @Route("/nineaList", name="app_reprise_nineaList", methods={"GET"})
     */
    public function nineaList(NINineaRepository $nINineaRepository, Request $request): Response
    {

        $ninea = "";
        $numNinea = "";
        $nineamere ="";
        $raison = "";
        $datenais = "";
        $enseigne = "";
        $cni = "";   
        $numreg = "";
        $datereg = "";
        $sigle = "";
        $telephone = "";
        $email = "";

        $session = new Session();
        $session->set('erreurSaisie',"3");

        if ($request->get("filtre") ) {
            $numNinea = $request->get('numNinea');
            $nineamere = $request->get("nineamere");
            $raison = $request->get("raisonsociale");
            $datenais = $request->get("datenais");
            $enseigne = $request->get("enseigne");
            $cni = $request->get('cni/passport');   
            $numreg = str_replace(" ", "", $request->get("regcom"));
            $datereg = $request->get("dateregcom");
            $sigle = $request->get("sigle");
            $telephone = $request->get("telephone");
            $email = $request->get("email");

            /*$ninea=$nINineaRepository->findByField($numNinea, $nineamere,$raison, $datenais,$enseigne,
                                        $cni, $numreg, $datereg, $sigle, $telephone, $email)
            ;
            
            /// TODO found all suspendue NINEA
            */
            $user = $this->getUser();

            $user_adm_id = $user->getNiAdministration()->getId();
            $ninea=$nINineaRepository->findByFieldRechercheEtat($numNinea, $nineamere,$raison, $datenais,$enseigne, $user_adm_id  );
            // $ninea = $this->getDoctrine()->getRepository(NiCessation::class)->findByFieldRechercheEtat($numNinea, $nineamere,$raison, $datenais,$enseigne  ); 

            
            if (count($ninea) < 1 )
            {
                $request->getSession()->getFlashBag()->add('messageDonnee',"Aucune donnée trouvée.");

            }
                
        }else {

            //$ninea=  $nINineaRepository->findAll();
        }
        return $this->render('nireactivation/nineaList.html.twig', [
            'ninineas'      =>$ninea,
            "numNinea"      =>$numNinea ,
            "nineamere"     => $nineamere,
            "raison"         =>  $raison,
            "datenais"       =>  $datenais,
            "enseigne"      => $enseigne,
            "cni"           => $cni,   
            "numreg"        => $numreg,
            "datereg"       => $datereg,
            "sigle"         => $sigle,
            "telephone"     => $telephone,
            "email"         => $email ,

        ]);
    }

    /**
     * Presente la liste des reactivations à valider pour le profile validateur 
     * @Route("/reactivationsList", name="reactivationsList", methods={"GET", "POST"})
     */
    public function reactivationsList(NireactivationRepository $nireactivationRepository, AuthorizationCheckerInterface $autorization, EntityManagerInterface $entityManager): Response
    {
        // return $this->render('nireactivation/reactivationsList.html.twig', [
        return $this->render('nireactivation/index.html.twig', [
            'nireactivations' => $entityManager->getRepository(DemandeModification::class)->findBy(array("typeDemande"=>"3","etat"=>array("a","c"))),
        ]);
    }

    /**
     * Presente la liste des reactivations valide prêtes à l'impression 
     * @Route("/reactivationsListImprimer", name="reactivationsListImprimer", methods={"GET", "POST"})
     */
    public function reactivationsListImprimer(NireactivationRepository $nireactivationRepository, AuthorizationCheckerInterface $autorization, EntityManagerInterface $entityManager): Response
    {
        return $this->render('nireactivation/reactivationsList.html.twig', [
            'nireactivations' => $entityManager->getRepository(Nireactivation::class)->findBy(array("etat"=>"v")),
        ]);
    }



     /**
     * @Route("/editEntete/{id}", name="editEnteteReactivation", methods={"GET", "POST"})
     */
    public function modifierEntete(Request $request, EntityManagerInterface $entityManager, NINinea $ninea): Response
    {
        
        
        $ninea->setNinmajdate(new \DateTime());       
        
        $ninStatut = "";
        $ninRegcom = "";
        $ninDatreg = "";

      if ($request->get('modifierEntete')) {

          $ninStatut = $request->get('ninStatut');
          $ninEnseigne = $request->get('ninEnseigne');
          $ninDatreg = $request->get('ninDatreg');
          $ninRegcom= $request->get('ni_nineaproposition_ninRegcom');

          $ninea->setNinStatut($ninStatut);
          $ninea->setNinEnseigne($ninEnseigne);
          $ninea->setNinDatreg(new \DateTime($ninDatreg));
          $ninea->setNinRegcom( str_replace("_","",$ninRegcom));

          $entityManager->flush();

        }

        return $this->redirectToRoute('app_nireactivation_show', ["id"=>$ninea->getId()], Response::HTTP_SEE_OTHER);
      
        // return $this->render('nireactivation/_partialsShowReact.html.twig', []);
    }


     /**
     * @Route("/modifier_Reactivation/{id}", name="modifier_Ninea_Reactivation", methods={"GET", "POST"})
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

        return $this->render('nireactivation/modifier_Ninea_Reactivation.html.twig', [
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
     * @Route("/new", name="app_nireactivation_new", methods={"GET", "POST"})
     */
    public function new(Request $request,EntityManagerInterface $entityManager, NireactivationRepository $nireactivationRepository): Response
    {
        $nireactivation = new Nireactivation();
        $form = $this->createForm(NireactivationType::class, $nireactivation);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $nireactivation->setEtat("a");
            $nireactivation->setCreatedBy($this->getUser());
            $nireactivation->setUpdatedBy($this->getUser());
           
            $ninea_val = $request->get('nineamere');
            $ninea= "";
            if ($ninea_val){

                $ninea=$entityManager->getRepository(NINinea::class)->findOneBy(['ninNinea' => $ninea_val]);
                $nireactivation->setNinea($ninea);

            }
             else{
                $request->getSession()->getFlashBag()->add('message',"NINEA ne doit pas être vide.");
                return $this->redirectToRoute('app_nireactivation_new', [], Response::HTTP_SEE_OTHER);
            }

            //Entete pres initialiser les informations de l'entete 
            // on est entrain de temporiser dans cette etape
            $tempNINinea = new TempNINinea();
            $tempNINinea->setNinEnseigne($ninea->getNinEnseigne());
            $tempNINinea->setNinRegcom($ninea->getNinRegcom());
            $tempNINinea->setFormeJuridique($ninea->getFormejuridique());
            $tempNINinea->setStatut($ninea->getStatut());
            $tempNINinea->setNinNinea( $ninea->getNinNinea());
            $tempNINinea->setNinEtat($ninea->getNinEtat());
            if($ninea->getCreatedBy())
             $tempNINinea->setCreatedBy($ninea->getCreatedBy());
            if($ninea->getModifiedBy())
                $tempNINinea->setModifiedBy($ninea->getModifiedBy());
            if($ninea->getCreatedAt())
             $tempNINinea->setCreatedAt($ninea->getCreatedAt());
            if($ninea->getUpdatedAt())
             $tempNINinea->setUpdatedAt($ninea->getUpdatedAt());
            //  $tempNINinea->setNiTypedocument($ninea->setNiTypedocument());
            $tempNINinea->setNinDatreg($ninea->getNinDatreg());
            $tempNINinea->setNinRaison($ninea->getNinRaison());
            $tempNINinea->setNinTitrefoncier($ninea->getNinTitrefoncier());
            $tempNINinea->setNinAgrement($ninea->getNinAgrement());
            $tempNINinea->setNinArrete($ninea->getNinArrete());
            $tempNINinea->setNinRecepisse($ninea->getNinRecepisse());
            $tempNINinea->setNinAccord($ninea->getNinAccord());
            $tempNINinea->setNinBordereau($ninea->getNinBordereau());
            $tempNINinea->setNinBail($ninea->getNinBail());
            $tempNINinea->setNinPermisoccuper($ninea->getNinPermisoccuper());



            //Personne temporiser les informations sur la personne morale ou physique
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
           
            //Info Activités et produit

            foreach ($ninea->getNinActivite() as $key) {
                $tempNiActivite = new TempNiActivite();
                $tempNiActivite->setNinAutact($key->getNinAutact());
                $tempNiActivite->setRefSyscoa($key->getRefSyscoa());
                $tempNiActivite->setRefNaema($key->getRefNaema());
                $tempNiActivite->setRefCiti($key->getRefCiti());
                
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

            $tempNiActiviteEconomique= new TempNiActiviteEconomique();
            $tempNiActiviteEconomique->setNinCapital($ninea->getNinActivitesEconomiques()[0]->getNinCapital());
            $tempNiActiviteEconomique->setNinEffect1($ninea->getNinActivitesEconomiques()[0]->getNinEffect1());
            $tempNiActiviteEconomique->setNinEffectifFem($ninea->getNinActivitesEconomiques()[0]->getNinEffectifFem());
            $tempNiActiviteEconomique->setNinEffectif($ninea->getNinActivitesEconomiques()[0]->getNinEffectif());
            $tempNiActiviteEconomique->setNinAffaire($ninea->getNinActivitesEconomiques()[0]->getNinAffaire());
            $tempNiActiviteEconomique->setNinEffectifFemSAIS($ninea->getNinActivitesEconomiques()[0]->getNinEffectifFemSAIS());
            $tempNiActiviteEconomique->setNiNinea($tempNINinea);
            $entityManager->persist($tempNiActiviteEconomique);


           
    
            $nireactivation->setTempNinea($tempNINinea);            
            


            $nireactivationRepository->add($nireactivation, true);

            // return $this->redirectToRoute('app_nireactivation_index', [], Response::HTTP_SEE_OTHER);
            return $this->redirectToRoute('app_nireactivation_show', ["id"=>$nireactivation->getId()], Response::HTTP_SEE_OTHER);
            
        }

        return $this->renderForm('nireactivation/new.html.twig', [
            'nireactivation' => $nireactivation,
            'demande_modification' => $nireactivation,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/{id}", name="app_nireactivation_show", methods={"GET"})
     */
    public function show(Nireactivation $nireactivation, EntityManagerInterface $entityManager): Response
    {


        $nINinea = $nireactivation->getNinea();
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
        $Odirigeant = "";
        $Dirigeants = $entityManager->getRepository(NiDirigeant::class)->findBy(array("nINinea"=>$nINinea),array('id'=>'desc'));
        $qualifications = $entityManager->getRepository(Qualite::class)->findAll();
        $tempNINinea=$nireactivation->getTempNinea();

        return $this->render('nireactivation/_partialsShowReact.html.twig', [
            'demande_modification' => $nireactivation,
            'ninea'=>$nireactivation->getNinea(),
            'tempNINinea'=>$tempNINinea,
            'formeunites' => $formeunites,             
            'Odirigeant' => $Odirigeant,             
            'qualifications' => $qualifications,             
            'Dirigeants' => $Dirigeants,             
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

    }

    /**
     * @Route("/{id}/edit", name="app_nireactivation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Nireactivation $nireactivation, NireactivationRepository $nireactivationRepository): Response
    {
        $form = $this->createForm(NireactivationType::class, $nireactivation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $nireactivation->setEtat("a");
            $nireactivation->setUpdatedBy($this->getUser());
            $nireactivation->setUpdatedAt(new \DateTime());
            $nireactivationRepository->add($nireactivation, true);
            return $this->redirectToRoute('app_nireactivation_show', ["id"=>$nireactivation->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('nireactivation/edit.html.twig', [
            'nireactivation' => $nireactivation,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/valider/{id}", name="app_nireactivation_valider", methods={"GET", "POST"})
     */
    public function valider(Request $request, EntityManagerInterface $entityManager, Nireactivation $nireactivation, NireactivationRepository $nireactivationRepository): Response
    {
        $nireactivation->setEtat("v");
        $nireactivation->setUpdatedBy($this->getUser());
        $nireactivation->setUpdatedAt(new \DateTime());
        $ninea=$nireactivation->getNinea();
        $ninea->setNinEtat("1");
        $entityManager->flush();

        return $this->redirectToRoute('app_nireactivation_index', [], Response::HTTP_SEE_OTHER);
      
    }


             /**
     * @Route("/rejet/{id}", name="nireactivation_rejet", methods={"GET", "POST"})
     */
    public function rejeter(Request $request, EntityManagerInterface $entityManager, Nireactivation $nireactivation): Response

      {
       // $niNineaproposition->setNinlock(false);

        $nireactivation->setRemarque($request->get("remarque"));
        $nireactivation->setEtat("r")     ;

            $entityManager->flush();
                  

            //$demandes_rejetees = count($entityManager->getRepository(NiNineaproposition::class)->findByDemande($this->getUser(), 'r'));
            
            //$session->set("rejeter", $demandes_rejetees);

            
            return $this->redirectToRoute('app_nireactivation_index', [], Response::HTTP_SEE_OTHER);
          
      }



    /**
     * @Route("/retourner/{id}", name="nireactivation__retourner", methods={"GET", "POST"})
     */
    
     public function retourner(Request $request, EntityManagerInterface $entityManager, Nireactivation $nireactivation): Response

     {
 
       $nireactivation->setRemarque($request->get("remarque"));
       $nireactivation->setEtat("t")     ;
 
           $entityManager->flush();
           
        return $this->redirectToRoute('app_nireactivation_index', [], Response::HTTP_SEE_OTHER);
         
     }


    /**
     * @Route("/{id}", name="app_nireactivation_delete", methods={"POST"})
     */
    public function delete(Request $request, Nireactivation $nireactivation, NireactivationRepository $nireactivationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$nireactivation->getId(), $request->request->get('_token'))) {
            $nireactivationRepository->remove($nireactivation, true);
        }

        return $this->redirectToRoute('app_nireactivation_index', [], Response::HTTP_SEE_OTHER);
    }



    /**
     * function pour telecharger dans  le navigateur le pdf generer par knpsnappy et wkhtmltopdf
     * correspondant a l'avis de reactivation comme avis d'immatriculation
     * @Route("/pdfActionDown/{id}", name="pdfActionDownReactivation", methods={"GET","POST"})
     * @param Pdf $knpSnappyPdf
     * @return void
     */
    public function pdfActionDown(Nireactivation $niReactivation, PDF $knpSnappyPdf, QrcodeService $qrcodeService, $id="")
    {
        //$vars = null ; //$this->getDoctrine()->getRepository(NINinea::class)->findBy([""]);

        
        //dd($qrcodeService->qrcode("ansd"));
        $qrCode = null ;

        
        $this->denyAccessUnlessGranted('ROLE_USER' , $niReactivation, 'Vous ne pouvez pas accéder à ce fichier. Contacter votre supérieur hiéarchique.');
        //$this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', $vars);
        
        // on retrouve ici le NINEA relatif a cette reactivation
        $vars = $this->getDoctrine()->getRepository(NINinea::class)->findOneBy(["ninNinea"=>$niReactivation->getNinea()->getNinNinea()]);
        
        
        if ($vars) {
            
            // recuperer l'administration qui a identifier 
            // $admin_csi = $this->getDoctrine()->getRepository(NINinea::class)->findOneBy(["ninAdministration"=>$vars->getNinAdministration()]);
            
            $admin_csi = $this->getDoctrine()->getRepository(NiNineaproposition::class)->findOneBy(["ninNinea"=>$vars->getNinNinea()]);
            
            $options = [
                
                'enable-javascript' => true, 
                'javascript-delay' => 1000, 
                'no-stop-slow-scripts' => true, 
                'no-background' => false, 
                'lowquality' => false,
                'encoding' => 'utf-8',
                'cookie' => array(),
                'enable-external-links' => false,
                'enable-internal-links' => true,
                'encoding'      => 'UTF-8',
                'background' => true,
                'margin-right'=>0,
            ];
            
            $qrCode = $qrcodeService->qrcode($vars->getNinNinea().'+'. $vars->getNinRegcom().'+'.$vars->getStatut(), $vars->getNinCreation()??null);
            
            // si FU correspond a personne physique ou autre PP imposable 
            // la denomination prend la concat. du nom+prenom
            
            
            $_formjuridique = null!=$vars->getFormeJuridique() ? $vars->getFormeJuridique()->getNiFormeunite()->getId() : "";
            $_denominationSocicale = null ;
            
            if ($_formjuridique!="11" && $_formjuridique!="12") {
                
                $_denominationSocicale = null!=$vars->getNiPersonne() ? $vars->getNiPersonne()->getNinRaison() : "";
                
            }else {
                $_denominationSocicale = null!=$vars->getNiPersonne() ? $vars->getNiPersonne()->getNinPrenom()." \t".$vars->getNiPersonne()->getNinNom() : "";
                
            }
            
            /**
             * TODO recuperer le document de creation selon forme juridique 
             * faut tester sur toutes les id forme juridique
             * $doc_creation_id = $vars->getFormeJuridique()->getId();
             */
            $doc_create = str_replace("_", "", $vars->getNinNumeroDocument()); // init docu creation

            $doc_create_txt = $vars->getNiTypedocument() ? $vars->getNiTypedocument()->getLibelle() : "";

            $date_document = $vars->getNinDateDocument();

            $doc_rccm_txt = "DATE D'IMMATRICULATION AU RCCM";
            
            $html = $this->renderView('nireactivation/_vimprimable_reactivation.html.twig', array(
                'some'  => $vars,
                'reactivat'  => $niReactivation,
                'title' => "REPUBLIQUE DU SENEGAL MINISTERE DE L'ECONOMIE, DU PLAN ET DE LA COOPERATION",
                'decret' => "Décret N° 2012 - 886 du 27/08/2012 abrogeant et remplaçant le décret  N° 95 - 364 du 14/04/1995",
                'qrcode' => $qrCode,
                'admin_csi' => $admin_csi,
                'denom_sociale' => $_denominationSocicale,
                'doc_create' => $doc_create,
                'doc_create_txt' => $doc_create_txt,
                'doc_rccm_txt' => $doc_rccm_txt,
                'date_document' => $date_document,
            )); 


            $knpSnappyPdf->setOptions($options);
            $filename =  "AVIS_DE_IMMATRICULATION_REACTIVATION".$vars->getNinRegcom();
            
            return new Response(
                $knpSnappyPdf->getOutputFromHtml($html),
                200,
                array(
                    'Content-Type'          => 'application/pdf',
                    'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
                )
            );
                        
        }
        throw new NotFoundHttpException();


    }

}
