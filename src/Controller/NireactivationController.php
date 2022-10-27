<?php

namespace App\Controller;

use App\Entity\CACR;
use App\Entity\CAV;
use App\Entity\Departement;
use App\Entity\NAEMA;
use App\Entity\NiActivite;
use App\Entity\NiActiviteEconomique;
use App\Entity\NiCivilite;
use App\Entity\NiCoordonnees;
use App\Entity\NiFormejuridique;
use App\Entity\NiFormeunite;
use App\Entity\Nireactivation;
use App\Entity\NINinea;
use App\Entity\NiNineaproposition;
use App\Entity\Ninproduits;
use App\Entity\NiSexe;
use App\Entity\NiTypevoie;
use App\Entity\Pays;
use App\Entity\QVH;
use App\Entity\RefProduits;
use App\Entity\Region;
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


/**
 * @Route("/nireactivation")
 * @Security("is_granted('ROLE_DEMANDE_NINEA') or is_granted('ROLE_VALIDER_DEMANDE_NINEA') or is_granted('ROLE_NINEA_ADMIN')")
 */
class NireactivationController extends AbstractController
{
    /**
     * @Route("/", name="app_nireactivation_index", methods={"GET"})
     */
    public function index(NireactivationRepository $nireactivationRepository): Response
    {
        return $this->render('nireactivation/index.html.twig', [
            'nireactivations' => $nireactivationRepository->findAll(),
        ]);
    }


    /**
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

            $ninea=$nINineaRepository->findByField($numNinea, $nineamere,$raison, $datenais,$enseigne,
                                        $cni, $numreg, $datereg, $sigle, $telephone, $email)
            ;

            /// TODO found all suspendue NINEA
            $ninea=$nINineaRepository->findNineaPersonnephysique($numNinea, $nineamere,$raison, $datenais,$enseigne  );

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
     * @Route("/reactivationsList", name="reactivationsList", methods={"GET"})
     */
    public function reactivationsList(): Response
    {
        return $this->render('nireactivation/reactivationsList.html.twig', [
            'nireactivations' => $this->getDoctrine()->getRepository(Nireactivation::class)->findBy(array("etat"=>"v"), null, 70, null),
        ]);
    }









     /**
     * @Route("/editEntete/{id}", name="editEnteteReactivation", methods={"GET", "POST"})
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

        return $this->redirectToRoute('modifier_Ninea_Reactivation', ["id"=>$ninea->getId()], Response::HTTP_SEE_OTHER);
      
      

    }


     /**
     * @Route("/modifier_Ninea/{id}", name="modifier_Ninea_Reactivation", methods={"GET", "POST"})
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
           
            $ninea = $request->get('nineamere');
            if ($ninea)
             $nireactivation->setNinea($entityManager->getRepository(NINinea::class)->findOneBy(['ninNinea' => $ninea]));
             else{
                $request->getSession()->getFlashBag()->add('message',"NINEA ne doit pas être vide.");
                return $this->redirectToRoute('app_nireactivation_new', [], Response::HTTP_SEE_OTHER);
            }


            $nireactivationRepository->add($nireactivation, true);

            return $this->redirectToRoute('app_nireactivation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('nireactivation/new.html.twig', [
            'nireactivation' => $nireactivation,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/{id}", name="app_nireactivation_show", methods={"GET"})
     */
    public function show(Nireactivation $nireactivation): Response
    {
        return $this->render('nireactivation/show.html.twig', [
            'nireactivation' => $nireactivation,
            'ninea'=>$nireactivation->getNinea()
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
            return $this->redirectToRoute('app_nireactivation_index', [], Response::HTTP_SEE_OTHER);
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
            $doc_create = str_replace("_", "", $vars->getNinRegcom()); // init docu creation

            $doc_create_txt = "RCCM";
            $doc_rccm_txt = "DATE D'IMMATRICULATION AU RCCM";
            if ($doc_create==null) {
                $doc_create = $vars->getNinBordereau();
                $doc_create_txt = "BORDERAU";
            }
            if ($doc_create==null) {
                $doc_create = $vars->getNinTitrefoncier();
                $doc_create_txt = "TITRE FONCIER";
            }
            if ($doc_create==null) {
                $doc_create = $vars->getNinAgrement();
                $doc_create_txt = "AGREMENT";
            }
            if ($doc_create==null) {
                $doc_create = $vars->getNinArrete();
                $doc_create_txt = "ARRETE";
            }
            if ($doc_create==null) {
                $doc_create = $vars->getNinRecepisse();
                $doc_create_txt = "RECIPISSE";
            }
            if ($doc_create==null) {
                $doc_create = $vars->getNinAccord();
                $doc_create_txt = "ACCORD";
            }
            if ($doc_create==null) {
                $doc_create = $vars->getNinBail();
                $doc_create_txt = "BAIL";
            }
            if ($doc_create==null) {
                $doc_create = $vars->getNinPermisoccuper();
                $doc_create_txt = "PERMIS D'OCCUPER";
            }
            if ($doc_create==null) {
                $doc_create = $vars->getNiPersonne() ? $vars->getNiPersonne()->getNinCNI() : "";
                $doc_create_txt = "CARTE NATIONALE D'IDENTITE";
            }

            
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
