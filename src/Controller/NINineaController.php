<?php

namespace App\Controller;

use App\Entity\NAEMA;
use App\Entity\NAEMAS;
use App\Entity\NiSexe;
use App\Entity\Region;
use App\Entity\SYSCOA;
use App\Entity\NINinea;
use App\Entity\NiActivite;
use App\Entity\NiCivilite;
use App\Entity\NiPersonne;
use App\Entity\NiTypevoie;
use App\Entity\Departement;
use App\Entity\CAV;
use App\Entity\CACR;
use App\Entity\QVH;

use App\Entity\Pays;
use App\Entity\NiFormeunite;
use App\Entity\NiPerception;
use App\Entity\CategoryNaema;
use App\Entity\CompteurNINEA;
use App\Entity\NiCoordonnees;
use App\Entity\NiNationalite;
use App\Entity\NiTypepersone;
use App\Services\DiversUtils;
use App\Entity\CategoryNaemas;
use App\Entity\Ninproduits;

use App\Entity\CategorySyscoa;
use Doctrine\ORM\EntityManager;
use App\Entity\NiFormejuridique;
use App\Entity\NiNineaproposition;
use App\Entity\CompteurDemandeNINEA;
use App\Entity\NiActiviteEconomique;
use App\Entity\NiDirigeant;
use App\Entity\NiStatut;
use App\Entity\Qualite;
use App\Entity\RefProduits;
use App\Form\NiActiviteEconomiqueType;
use App\Form\NiActiviteType;
use App\Form\NiCoordonneesType;
use App\Form\NiDirigeantType;
use App\Form\NiNineapropositionType;
use App\Form\NiNineaPropositionShowType;
use App\Repository\NiNineapropositionRepository;
use App\Repository\NiPersonneRepository;
use App\Form\NINineaType;
use App\Repository\NINineaRepository;
use App\Services\QrcodeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf as PDF;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Spipu\Html2Pdf\Html2Pdf;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("/ninea")
 * @Security("is_granted('ROLE_CONSULTATION_NINEA') or is_granted('ROLE_DEMANDE_NINEA') or is_granted('ROLE_VALIDER_DEMANDE_NINEA') or is_granted('ROLE_NINEA_ADMIN')")
 */
class NINineaController extends AbstractController
{
    private  $requestStack;
    
    public function __construct(RequestStack $requestStack)
    {
        // parent::__construct();
        $this->requestStack = $requestStack;
        
    }

    /**
     * @Route("/index2", name="n_i_ninea_index2", methods={"GET"})
     */
    public function index2(NINineaRepository $nINineaRepository, Request $request): Response
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
                                        $cni, $numreg, $datereg, $sigle, $telephone, $email);

            if (count($ninea) < 1 )
            {
                $request->getSession()->getFlashBag()->add('messageDonnee',"Aucune donnée trouvée.");

            }
                
        }else {

            //$ninea=  $nINineaRepository->findAll();
        }
        return $this->render('ni_ninea/index2.html.twig', [
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
     * @Route("/recherche_NINEA", name="recherche_NINEA", methods={"GET", "POST"})
     */
    public function recherche_NINEA(NINineaRepository $nINineaRepository, Request $request): Response
    {
       /*  $ninea = [];
        
        if ($request->get("rechercher") ) {
            $numNinea = $request->get('numNinea');
            $ninea=$nINineaRepository->findBy(["ninNinea"=>$numNinea]);
        } */

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
           

            $ninea=$nINineaRepository->findByFieldRechercheNINEA($numNinea, $nineamere,$raison, $datenais,$enseigne  );

                
        }else {

            //$ninea=  $nINineaRepository->findAll();
        }

        return $this->render('ni_ninea/recherche_NINEA.html.twig', [
            //'ninineas'      =>$ninea,
            'ninineas'      => $ninea,
            "numNinea"      => $numNinea ,
            "nineamere"     => $nineamere,
            "raison"        =>  $raison,
            "datenais"      =>  $datenais,
            "enseigne"      => $enseigne,

        ]);
    }



        /**
     * @Route("/recherche_NINEA_desactive", name="recherche_NINEA_desactive", methods={"GET", "POST"})
     */
    public function recherche_NINEA_desactive(NINineaRepository $nINineaRepository, Request $request): Response
    {
       /*  $ninea = [];
        
        if ($request->get("rechercher") ) {
            $numNinea = $request->get('numNinea');
            $ninea=$nINineaRepository->findBy(["ninNinea"=>$numNinea]);
        } */

        $ninea = "";
        $numNinea = "";
        $nineamere ="";
        $raison = "";
        $datenais = "";
        $enseigne = "";
      

        if ($request->get("filtre") ) {
            $numNinea = $request->get('numNinea');
            $nineamere = $request->get("nineamere");
            $raison = $request->get("raisonsociale");
            $datenais = $request->get("datenais");
            $enseigne = $request->get("enseigne");
           

            $ninea=$nINineaRepository->findByFieldRechercheNINEA($numNinea, $nineamere,$raison, $datenais,$enseigne  );

                
        }else {

            //$ninea=  $nINineaRepository->findAll();
        }

        return $this->render('ni_ninea/recherche_NINEA_desactive.html.twig', [
            //'ninineas'      =>$ninea,
            'ninineas'      => $ninea,
            "numNinea"      => $numNinea ,
            "nineamere"     => $nineamere,
            "raison"        =>  $raison,
            "datenais"      =>  $datenais,
            "enseigne"      => $enseigne,

        ]);
    }



    /**
     * @Route("/recherche_NINEA_Personnephysique", name="recherche_NINEA_Personnephysique", methods={"GET", "POST"})
     */
    public function recherche_NINEA_Personnephysique(NINineaRepository $nINineaRepository, Request $request): Response
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
           

            $ninea=$nINineaRepository->findNineaPersonnephysique($numNinea, $nineamere,$raison, $datenais,$enseigne  );

                
        }else {

            //$ninea=  $nINineaRepository->findAll();
        }

        return $this->render('ni_ninea/recherche_NINEA_Personne2.html.twig', [
            //'ninineas'      =>$ninea,
            'ninineas'      => $ninea,
            "numNinea"      => $numNinea ,
            "nineamere"     => $nineamere,
            "raison"        =>  $raison,
            "datenais"      =>  $datenais,
            "enseigne"      => $enseigne,

        ]);
    }

    
    /**
     * @Route("/recherche_NINEA_Personnemorale", name="recherche_NINEA_Personnemorale", methods={"GET", "POST"})
     */
    public function recherche_NINEA_Personnemorale(NINineaRepository $nINineaRepository, Request $request): Response
    {

        $ninea = "";
        $numNinea = "";
        $nineamere ="";
        $raison = "";
        $datenais = "";
        $enseigne = "";
      
        if ($request->get("filtre") ) {
            $numNinea = $request->get('numNinea');
            $nineamere = $request->get("nineamere");
            $raison = $request->get("raisonsociale");
            $datenais = $request->get("datenais");
            $enseigne = $request->get("enseigne");

            $ninea=$nINineaRepository->findNineaPersonnemorale($numNinea, $nineamere,$raison, $datenais,$enseigne  );

                
        }else {

            //$ninea=  $nINineaRepository->findAll();
        }

        return $this->render('ni_ninea/recherche_NINEA_Personne.html.twig', [
            //'ninineas'      =>$ninea,
            'ninineas'      => $ninea,
            "numNinea"      => $numNinea ,
            "nineamere"     => $nineamere,
            "raison"        =>  $raison,
            "datenais"      =>  $datenais,
            "enseigne"      => $enseigne,

        ]);
    }


    
    /**
     * @Route("/", name="n_i_ninea_index", methods={"GET"})
     */
    public function index(NINineaRepository $nINineaRepository, Request $request): Response
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
          $numreg = $request->get("regcom");
          $datereg = $request->get("dateregcom");
          $sigle = $request->get("sigle");
          $telephone = $request->get("telephone");
          $email = $request->get("email");

          $ninea=$nINineaRepository->findByField($numNinea, $nineamere,$raison, $datenais,$enseigne,
                                      $cni, $numreg, $datereg, $sigle, $telephone, $email);

              
      }else {

          $ninea=  $nINineaRepository->findBy(array(),array('ninNinea'=>'desc'),80,0);
      }
        return $this->render('ni_ninea/index.html.twig', [
            'ninineas' =>$ninea,
           
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
     * @Route("/demandeModification", name="demandeModification", methods={"GET"})
     */
    public function demandeModification(NINineaRepository $nINineaRepository, Request $request): Response
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
          $numreg = $request->get("regcom");
          $datereg = $request->get("dateregcom");
          $sigle = $request->get("sigle");
          $telephone = $request->get("telephone");
          $email = $request->get("email");

          $ninea=$nINineaRepository->findByField($numNinea, $nineamere,$raison, $datenais,$enseigne,
                                      $cni, $numreg, $datereg, $sigle, $telephone, $email);

              
      }else {

          $ninea=  $nINineaRepository->findBy(array(),array('ninNinea'=>'desc'),80,0);
      }
        return $this->render('ni_ninea/demandeModification.html.twig', [
            'ninineas' =>$ninea,
           
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
     * @Route("/imprimerNinea", name="imprimerNinea", methods={"GET"})
     */
    public function imprimerNinea(NINineaRepository $nINineaRepository, Request $request): Response
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
          $numreg = $request->get("regcom");
          $datereg = $request->get("dateregcom");
          $sigle = $request->get("sigle");
          $telephone = $request->get("telephone");
          $email = $request->get("email");

          $ninea=$nINineaRepository->findByField($numNinea, $nineamere,$raison, $datenais,$enseigne,
                                      $cni, $numreg, $datereg, $sigle, $telephone, $email);

              
      }else {

          $ninea=  $nINineaRepository->findBy(array(),array('ninNinea'=>'desc'),80,0);
      }
        return $this->render('ni_ninea/imprimerNinea.html.twig', [
            'ninineas' =>$ninea,
           
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
     * function sert à afficher un document pdf dans un iframe via une requete ajax 
     * @Route("/ninea/{id}", name="pdfAction", methods={"GET"})
     * @param Pdf $knpSnappyPdf
     * @return void
     */
    public function pdfAction(NINinea $vars, PDF $knpSnappyPdf, $id="")
    {
        //$vars = null ; //$this->getDoctrine()->getRepository(NINinea::class)->findBy([""]);

        $session = $this->requestStack->getSession();
        $session->set('trigger', $id);

        //$this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', $vars);


        if ($vars) {

            // recuperer l'administration qui a identifier 
            $admin_csi = $this->getDoctrine()->getRepository(NINinea::class)->findOneBy(["ninAdministration"=>$vars->getNinAdministration()]);

            $options = [
                
            'enable-javascript' => true, 
            'javascript-delay' => 1000, 
            'no-stop-slow-scripts' => true, 
            'no-background' => false, 
            'lowquality' => false,
            'encoding' => 'utf-8',
            'cookie' => array(),
            'enable-external-links' => true,
            'enable-internal-links' => true,
            'encoding'      => 'UTF-8',
            ];
        
            $html = $this->renderView('ni_ninea/_vimprimable.html.twig', array(
                'some'  => $vars,
                'title' => "REPUBLIQUE DU SENEGAL MINISTERE DE L'ECONOMIE, DU PLAN ET DE LA COOPERATION",
                'decret' => "Décret N° 2012 - 886 du 27/08/2012 abrogeant et remplaçant le décret  N° 95 - 364 du 14/04/1995",
            )); 

            $knpSnappyPdf->setOptions($options);
            $filename =  $vars->getNinRegcom().'pdf';
            
            
            /* return new PdfResponse(
                        $knpSnappyPdf->getOutputFromHtml($html),
                        'Avis d\'imm-'.'file-'.$vars->getNinRegcom().'.pdf',
                    ); */
            /* $reponse  = new PdfResponse(
                        $knpSnappyPdf->getOutputFromHtml($html),
                        200,
                        array(
                            'Content-Type'          => 'application/pdf',
                            )
                        );
                        
            return $reponse; */
            /** ceci 7lignes va permettre de stocker les avis sur le serveur de fichier  */
            $output = "";
            $output = __DIR__ . '/../../public/avis/'.$filename;
            if (file_exists($output)) {
                unlink($output);
            }else {
                
                $output = __DIR__ . '/../../public/avis/'.$filename;
            }
            
            header('Content-Type: application/pdf');
            // Remove the next line to let the browser display the PDF
            // echo $knpSnappyPdf->getOutputFromHtml($html);
            
            $knpSnappyPdf->generateFromHtml($html, $output, $options , false);   
            
            return new JsonResponse(array("name" => $filename)) ;
        }
        throw new NotFoundHttpException();


    }


    /**
     * function pour telecharger dans  le navigateur le pdf generer par knpsnappy et wkhtmltopdf
     * @Route("/pdfActionDown/{id}", name="pdfActionDown", methods={"GET","POST"})
     * @param Pdf $knpSnappyPdf
     * @return void
     */
    public function pdfActionDown(NINinea $vars, PDF $knpSnappyPdf, QrcodeService $qrcodeService, $id="")
    {
        //$vars = null ; //$this->getDoctrine()->getRepository(NINinea::class)->findBy([""]);

        $session = $this->requestStack->getSession();
        $session->set('trigger', $id);
        
        //dd($qrcodeService->qrcode("ansd"));
        $qrCode = null ;

        //$this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', $vars);
        $this->denyAccessUnlessGranted('ROLE_USER' , $vars, 'Vous ne pouvez pas accéder à ce fichier. Contacter votre supérieur hiéarchique.');

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

            
            $html = $this->renderView('ni_ninea/_vimprimable.html.twig', array(
                'some'  => $vars,
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
            $filename =  $vars->getNinRegcom();
            
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


    /**
     * function pour telecharger dans  le navigateur le pdf generer par knpsnappy et wkhtmltopdf
     * @Route("/htmlToPdfActionDown/{id}", name="htmlToPdfActionDown", methods={"GET"})
     * @param  Html2Pdf $htmlToPdf
     * @return void
     */
    public function htmlToPdfActionDown(NINinea $vars,  $id="")
    {
        //$vars = null ; //$this->getDoctrine()->getRepository(NINinea::class)->findBy([""]);

        $session = $this->requestStack->getSession();
        $session->set('trigger', $id);

        //$this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', $vars);
        $this->denyAccessUnlessGranted('ROLE_USER' , $vars, 'Vous ne pouvez pas accéder à ce fichier. Contacter votre supérieur hiéarchique.');

        if ($vars) {

            $html = $this->renderView('ni_ninea/_vimprimable.html.twig', array(
                'some'  => $vars,
                'title' => "REPUBLIQUE DU SENEGAL MINISTERE DE L'ECONOMIE, DU PLAN ET DE LA COOPERATION",
                'decret' => "Décret N° 2012 - 886 du 27/08/2012 abrogeant et remplaçant le décret  N° 95 - 364 du 14/04/1995",
            )); 

            try {
            
            $html2pdf = new Html2Pdf('P', 'A4', 'fr', true, 'UTF-8');
            $html2pdf->pdf->SetDisplayMode('real');
            //$html2pdf->AddFont('roboto', 'normal', resource_path('fonts') . '/roboto.php');
            $html2pdf->writeHTML($html);

            $filename =  $vars->getNinRegcom();
            return new Response(
                $html2pdf->Output($filename.'.'.'pdf'),
                200,
                array(
                    'Content-Type'          => 'application/pdf',
                    'Content-Disposition'   => 'inline; filename="'.$filename.'.'.'pdf"'
                )
            );
            } catch (Html2PdfException $e) {
                $html2pdf->clean();
             
                $formatter = new ExceptionFormatter($e);
                echo $formatter->gethtmlMessage();
            }        
        }
        throw new NotFoundHttpException();


    }

    
    /**
     * @Route("/new", name="n_i_ninea_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $nINinea = new NINinea();
        $form = $this->createForm(NINineaType::class, $nINinea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($nINinea);
            $entityManager->flush();

            return $this->redirectToRoute('n_i_ninea_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ni_ninea/new.html.twig', [
            'ninea' => $nINinea,
            'form' => $form,
        ]);
    }


    /**
     * @Route("show/{id}/{coordonnee}/{activiteEco}/{dirigeant}", name="nininea_show", methods={"GET", "POST"})
     */
    public function show($id="",  EntityManagerInterface $entityManager, $coordonnee="", $dirigeant="", $activiteEco=""): Response
    {
        $ninea = $entityManager->getRepository(NINinea::class)->find($id);
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
       
      
        return $this->render('ni_ninea/show.html.twig', [
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
            "activiteglobale"  => $activiteglobale

        ]);
    }



     /**
     * @Route("/rechercheNINEA/{id}", name="nininea_rechercheNINEA", methods={"GET", "POST"})
     */
    public function rechercherNINEA($id=""): Response
    {
         $ninea=$this->getDoctrine()->getRepository(NINinea::class)->findOneBy(['ninNinea'=> $id]);
         if ($ninea )       
             return new JsonResponse( 1);
        else
             return new JsonResponse(0);
    }

      /**
     * @Route("/num_ninea/{id}", name="num_ninea", methods={"GET", "POST"})
     */
    public function num_ninea(Request $request, EntityManagerInterface $entityManager, NINinea $ninea): Response
    {

      return $this->render('ni_ninea/num_ninea.html.twig', [
        'ninea' => $ninea ]);
      

    }


     /**
     * @Route("/editEntete/{id}", name="editEntete", methods={"GET", "POST"})
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

        return $this->redirectToRoute('modifier_Ninea', ["id"=>$ninea->getId()], Response::HTTP_SEE_OTHER);
      
      

    }


     /**
     * @Route("/modifier_Ninea/{id}", name="modifier_Ninea", methods={"GET", "POST"})
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

        return $this->render('ni_ninea/modifier_Ninea.html.twig', [
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
     * @Route("/edit/{id}/{dirigeant}", name="n_i_ninea_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request,  $id="", EntityManagerInterface $entityManager, $dirigeant=""): Response
    {
        $nINinea = $entityManager->getRepository(NINinea::class)->find($id);
        $Odirigeant = $entityManager->getRepository(NiDirigeant::class)->find($dirigeant);

        //var_dump($Odirigeant);

        $nineaproposition = $entityManager->getRepository(NiNineaproposition::class)->findOneBy(["ninNinea" =>$nINinea->getNinNinea() ]);
        $niTypevoies = $entityManager->getRepository(NiTypevoie::class)->findAll();
        $sexes = $entityManager->getRepository(NiSexe::class)->findAll();
        $nationalites = $entityManager->getRepository(Pays::class)->findAll();
        $civilites = $entityManager->getRepository(NiCivilite::class)->findAll();
        $niActiviteEconomiques=$entityManager->getRepository(NiActiviteEconomique::class)->findAll();
        $qualifications = $entityManager->getRepository(Qualite::class)->findAll();
        $produits = $entityManager->getRepository(RefProduits::class)->findAll();
        $naemas = $entityManager->getRepository(NAEMA::class)->findAll();

        $regions = $entityManager->getRepository(Region::class)->findAll();


        $lastcoordoonnee=$entityManager->getRepository(NiCoordonnees::class)->findBy(array("ninNinea"=>$nINinea),array('id'=>'desc'),1,0);
        //var_dump($dirigeant);
        $coordoonnes = $entityManager->getRepository(NiCoordonnees::class)->findBy(array("ninNinea"=>$nINinea),array('id'=>'desc'));

        $lastacteEcononomique=$entityManager->getRepository(NiActiviteEconomique::class)->findBy(array("nINinea"=>$nINinea),array('id'=>'desc'),1,0);
        $activiteseconmiques = $entityManager->getRepository(NiActiviteEconomique::class)->findBy(array("nINinea"=>$nINinea),array('id'=>'desc'));

        $Dirigeants = $entityManager->getRepository(NiDirigeant::class)->findBy(array("nINinea"=>$nINinea),array('id'=>'desc'));

        $ninactivites = $entityManager->getRepository(NiActivite::class)->findBy(array("nINinea"=>$nINinea),array('statActivprincipale'=>'desc'));
        $ninproduits = $entityManager->getRepository(Ninproduits::class)->findBy(array("nINinea"=>$nINinea));
        if(count($lastacteEcononomique)>0)
          $lastactiviteEco =$lastacteEcononomique[0];
        else
          $lastactiviteEco=null;

        if(count($lastcoordoonnee)>0)
          $lastcoordoonnee1=$lastcoordoonnee[0];
        else
          $lastcoordoonnee1=null;

        return $this->render('ni_ninea/edit.html.twig', [
            'ninea' => $nINinea,
            'nineaproposition' => $nineaproposition,
            'typevoies'  => $niTypevoies,
             'niActiviteEconomiques'=> $niActiviteEconomiques,
            'regions' => $regions,
            'sexes' => $sexes,
            'nationalites'  => $nationalites,
            'lastcoordoonnee' => $lastcoordoonnee1,
            'coordoonnes' => $coordoonnes,
            'civilites' => $civilites,
            'lastactiviteEco' => $lastactiviteEco,
            'activiteseconmiques' => $activiteseconmiques,
            'qualifications' => $qualifications,
            'Dirigeants'=> $Dirigeants,
            'Odirigeant'=> $Odirigeant, 
            'ninactivites' => $ninactivites,
            'ninproduits' => $ninproduits,
            'naemas' => $naemas,
            'produits' => $produits,
            
        ]);
       
     //   return $this->renderForm('ni_ninea/edit.html.twig', [
     //       'n_i_ninea' => $nINinea,
         //   'form' => $form,
     //   ]);
    }


    


              /**
     * @Route("/editPersonne/{id}", name="ninea_editPersonne", methods={"GET", "POST"})
     */
    public function editPersonne(Request $request, EntityManagerInterface $entityManager,$id=""): Response
    {
        $lastpersonne=  $entityManager->getRepository(NiPersonne::class)->find($id);

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

        if ($request->get("nom")) {
         
          if ($lastpersonne->getNineaproposition()->getNinFormejuridique()->getNiFormeunite()->getId() == 1)
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

              $nsexe = $request->get("sexe");

              $lastpersonne->setNinNom($nom);
              $lastpersonne->setNinPrenom($prenom);
              $lastpersonne->getNinTelephone($telephone);
              $lastpersonne->setNinEmailPersonnel($email);
              $lastpersonne->setCivilite($entityManager->getRepository(NiCivilite::class)->find($civilite));
              $lastpersonne->setNinDateNaissance(new \DateTime($datenais));
              $lastpersonne->setNinLieuNaissance($lieunais);
              $lastpersonne->setNationalite($entityManager->getRepository(Pays::class)->find($nationalite));
              $lastpersonne->setNinSexe($entityManager->getRepository(NiSexe::class)->find($nsexe));

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

           $lastpersonne->setUpdatedBy($this->getUser());
           
            $entityManager->flush();

            return $this->redirectToRoute('nininea_show', ["id"=>$lastpersonne->getNinNinea()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ni_ninea/editPersonne.html.twig', [
            
            'sexes' => $sexe,
            'nationalites' => $nationalites,
            'civilites' => $civilites,
            'lastpersonne' => $lastpersonne,
          
            'nom' => $nom,
            'prenom' => $prenom,
            'civilite' => $civilite,
            'datenais' => $datenais,
            'lieunais' => $lieunais,
            'nationalite' => $nationalite,
            'nsexe' => $nsexe,
            'cni' => $cni,
            'dateCni' => $datecni,
            'passport' => $passport,
            'datepassport' => $datepassport,
            'raison' => $raison,
            'sigle' => $sigle,
            'sexe'=> $sexe,
            'email' => $email,

            'region_personne' => $region_personne,
            'departement_personne' => $departement_personne,
            'cav_personne' => $cav_personne,
            'cacr_personne' => $cacr_personne,
            'qvh_personne' => $qvh_personne,
            'regions'=>$regions,
            'departements'=>$departements,
            'cavs'=>$cavs,
            'cacrs'=>$cacrs,
           
           
        ]);
    }



    
     /**
     * @Route("/editCoordonnees/{id}", name="ninea_editCoordonnees", methods={"GET", "POST"})
     */
    public function editCoordonnees(Request $request, EntityManagerInterface $entityManager, $id=""): Response
    {

        $session= new Session();
        $session->set('actived',2);

        if ($request->get('editer')) 
        {


        $lastcoordoonnee=$entityManager->getRepository(NiCoordonnees::class)->find($id);
        $coordonnee = new NiCoordonnees();

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

        $niNineaproposition= $lastcoordoonnee->getNiNineaproposition();
        $niNinea= $lastcoordoonnee->getNinNinea();

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

         $coordonnee->setCreateBy($this->getUser());
         $coordonnee->setUpdateBy($this->getUser());

         
         $coordonnee->setNinNinea($niNinea);
        $coordonnee->setNiNineaproposition($niNineaproposition);

        $lastcoordoonnee->setUpdateBy($this->getUser());
        $lastcoordoonnee->setDateFin(new \DateTime());

        $entityManager->persist($coordonnee);
        $entityManager->flush();

            return $this->redirectToRoute('n_i_ninea_edit', ["id"=> $niNinea->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ni_ninea/editCoordonnee.html.twig', [
            'lastcoordoonnee' => $lastcoordoonnee,
            'form' => $form,
            
            'regions' => $regions,
            'region' => $region,
            'typevoies' => $typevoies,
            'typevoie' => $typevoie,
            'voie' => $voie,
            'numvoie' => $numvoie,
           
            'qvh' => $qvh,
            "adresse1" => $adresse1,
            "adresse2" => $adresse2,
            "telephone1" => $telephone1,
            "telephone2" => $telephone2,
            "email" => $email,
            "departements" => $departements,
            'cacrs' => $cacrs,
            'cavs' => $cavs,
            'cacr' => $cacr,
            'cav' => $cav,
            'departement' => $departement,
            'boitepostale' => $boitepostale,

        ]);
    }



     /**
     * @Route("/editActivites/{id}", name="ninea_editActivites", methods={"GET", "POST"})
     */
     public function editActivites(Request $request, EntityManagerInterface $entityManager, $id=""): Response
    {

        $lastactivites=$entityManager->getRepository(NiActivite::class)->find($id);
        $form = $this->createForm(NiActiviteType::class, $lastactivites);
       
          $form->handleRequest($request);
          if ($form->isSubmitted() && $form->isValid()) {
         
            $entityManager->flush();

            return $this->redirectToRoute('nininea_show', ["id"=> $lastactivites->getNINinea()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ni_ninea/editActivite.html.twig', [
            'form' => $form,           
          

        ]);
    }
 


/**
     * @Route("/ajouterDirigeantsHisto/{id}", name="ajouterDirigeantsHisto", methods={"GET", "POST"})
     */
    public function ajouterDirigeantsHisto(NINinea $niNinea, Request $request, EntityManagerInterface $entityManager): Response
    {

        $sexe = $entityManager->getRepository(NiSexe::class)->findAll();
        $nationalites = $entityManager->getRepository(Pays::class)->findAll();
        $regions = $entityManager->getRepository(Region::class)->findAll();
        $civilites = $entityManager->getRepository(NiCivilite::class)->findAll();
        $qualifications = $entityManager->getRepository(Qualite::class)->findAll();

        //var_dump($civilites);
        if($request->get("valider"))
        {
          $dirigeant =  new NiDirigeant();

          $session= new Session();
          $session->set('actived',5);

          $nationalite = $entityManager->getRepository(NiStatut::class)->find($request->get("nationalite"));
          $cni = $request->get('cni');
          $datecni = $request->get('datecni');
          $nationalite = $request->get("nationalite");
          if( $nationalite=="SN"){
            $cni = $request->get("cni");
            $datecni = $request->get("dateCni");
            $dirigeant->setNinCni($cni);
            $dirigeant->setNinDateCni(new \DateTime($datecni));
        }
        else {
            $passport = $request->get("passport");
            $datepassport = $request->get("datepassport");
            $dirigeant->setNinCni($passport);
            $dirigeant->setNinDateCni(new \DateTime($datepassport));
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
          $qvh = $request->get("qvh");

          $dirigeant->setNinNom($nom);
          $dirigeant->setNinPrenom($prenom);
          //$personne->setAdresse($adresse);
          $dirigeant->setNinCivilite($entityManager->getRepository(NiCivilite::class)->find($civilite));
          $dirigeant->setNinDatenais(new \DateTime($datenais));
          $dirigeant->setNinLieunais($lieunais);
          $dirigeant->setNinTelephone1($telephone);
          $dirigeant->setNinEmail($email);
          $dirigeant->setNinPosition($entityManager->getRepository(Qualite::class)->find($qualification));

          $dirigeant->setNinNationalite($entityManager->getRepository(Pays::class)->find($nationalite));
          $dirigeant->setNinSexe($entityManager->getRepository(NiSexe::class)->find($nsexe));
          $dirigeant->setNinQvh($entityManager->getRepository(QVH::class)->find($qvh));
         
          $niNineaproposition=$niNinea->getNinNumerodemande();
          $dirigeant->setNINinea($niNinea);
          $dirigeant->setNinNineaProposition($niNineaproposition);
          
          $entityManager->persist($dirigeant);
          $entityManager->flush();
         
          return $this->redirectToRoute('n_i_ninea_edit', ["id"=> $niNinea->getId()], Response::HTTP_SEE_OTHER);
        
         
        }
    }

    

       /**
     * @Route("/voirActiviteEconomique/{id}", name="voirActiviteEconomique", methods={"GET", "POST"})
     */
    public function voirActiviteEconomique(Request $request, EntityManagerInterface $entityManager,$id=""): Response
    {
        $session= new Session();
        $session->set('actived',4);

        $activiteEco =  $entityManager->getRepository(NiActiviteEconomique::class)->find($id);
        $niNinea= $activiteEco->getNINinea();
        $lastcoordoonnees=$entityManager->getRepository(NiCoordonnees::class)->findBy(array("ninNinea"=>$niNinea),array('id'=>'desc'),1,0);
      //  var_dump($activiteEco);

        return $this->redirectToRoute('nininea_show', ["id"=> $niNinea->getId(),"coordonnee"=>$lastcoordoonnees[0]->getId(), "activiteEco"=> $activiteEco->getId()], Response::HTTP_SEE_OTHER);


    }

      /**
     * @Route("/voirDirigeant/{id}", name="voirDirigeant", methods={"GET", "POST"})
     */
    public function voirDirigeant(Request $request, EntityManagerInterface $entityManager,$id=""): Response
    {
        $session= new Session();
        $session->set('actived',5);

        $dirigeant =  $entityManager->getRepository(NiDirigeant::class)->find($id);
        $niNinea= $dirigeant->getNINinea();
        $lastcoordoonnees=$entityManager->getRepository(NiCoordonnees::class)->findBy(array("ninNinea"=>$niNinea),array('id'=>'desc'),1,0);
        $lastactiviteEco=$entityManager->getRepository(NiActiviteEconomique::class)->findBy(array("nINinea"=>$niNinea),array('id'=>'desc'),1,0);
       // var_dump($dirigeant);

        return $this->redirectToRoute('nininea_show', ["id"=> $niNinea->getId(),"coordonnee"=>$lastcoordoonnees[0]->getId(), "activiteEco"=>$lastactiviteEco[0]->getId(), "dirigeant"=> $dirigeant->getId()], Response::HTTP_SEE_OTHER);


    }


           /**
     * @Route("/voirCoordonee/{id}", name="voirCoordonee", methods={"GET", "POST"})
     */
    public function voirCoordonee(Request $request, EntityManagerInterface $entityManager,$id=""): Response
    {
        $session= new Session();
        $session->set('actived',2);

        $coordonnee =  $entityManager->getRepository(NiCoordonnees::class)->find($id);
        $niNinea= $coordonnee->getNinNinea();
      //  var_dump($activiteEco);

        return $this->redirectToRoute('nininea_show', ["id"=> $niNinea->getId(),"coordonnee"=> $coordonnee->getId()], Response::HTTP_SEE_OTHER);

    }

    

/**
     * @Route("/activiteEtProduitsHisto/{id}", name="activiteEtProduitsHisto", methods={"GET", "POST"})
     */
    public function activiteEtProduitsHisto(Request $request, EntityManagerInterface $entityManager, $id=""): Response
    {

        $niNinea =  $entityManager->getRepository(NINinea::class)->find($id);
      //  var_dump($niNinea);
        $naemas = $entityManager->getRepository(NAEMA::class)->findAll();
        $niNineaproposition=$niNinea->getNinNumerodemande();
        
       
        if ($request->get('ajouter')) {

          $ninactivites = $entityManager->getRepository(NiActivite::class)->findBy(array("nINinea"=>$niNinea),array('id'=>'desc'));
          $ninproduits = $entityManager->getRepository(Ninproduits::class)->findBy(array("nINinea"=>$niNinea),array('id'=>'desc'));
  
         // var_dump($ninactivites);
          $nbActivites=$request->get('nbActivites');
         // var_dump($nbActivites);
         //var_dump($ninproduits);
          for($indice = 1; $indice <= (int)($nbActivites); $indice++){
            //var_dump($ninproduits);

            $refProduit=$request->get('refProduit'.strval($indice));
            $refNaema=$request->get('refNaema'.strval($indice));
            $libelleActivite=$request->get('ninAutact'.strval($indice));

            
            $bActiviteTrouve=false;
           // var_dump($refProduit);
           foreach ($ninactivites as $act) {
            if($act->getRefNaema()->getId()==$refNaema){
                 $bActiviteTrouve=true;
                 $ninactivite=$act;
                // var_dump($ninactivite);
                 break;
            }
           }

            
            if($bActiviteTrouve==false){
              $ninactivite = new NiActivite();

             // var_dump($ninactivite);

              $ninactivite->setNiNineaproposition($niNineaproposition);
              if(count($niNinea->getNinActivite())>0)
              $ninactivite->setStatActivPrincipale(false);
              else
              $ninactivite->setStatActivPrincipale(true);

              
            $ninactivite->setNinAutact($libelleActivite);
            $ninactivite->setNINinea($niNinea);
            $ninactivite->setRefNaema($entityManager->getRepository(NAEMA::class)->find($refNaema));
           // $niNineaproposition->addNinActivite($ninactivite);
            $niNinea->addNinActivite($ninactivite);
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
                $ninproduit = new Ninproduits();
                $ninproduit->setRefproduits($entityManager->getRepository(RefProduits::class)->find($key));
                $niNinea->addNinproduit($ninproduit);
                
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
                  $niNinea->removeNinproduit($ninprod);
                  $entityManager->remove($ninprod);
                }
              }
             
            }

          }

          $session= new Session();
          $session->set('actived',3);
        
          $entityManager->flush();

           // $request->getSession()->getFlashBag()->add('message',"L'activité  a été ajoutée avec succés.");

           return $this->redirectToRoute('n_i_ninea_edit', ["id"=> $niNinea->getId()], Response::HTTP_SEE_OTHER);
        }
           
              return $this->renderForm('ni_nineaproposition/newActivite.html.twig', [
              
              'activite' => $form,
              'id' => $niNineaproposition->getId(),
              'statut' => $niNineaproposition->getStatut(),
              'act' => $niNineaproposition->getNinActivites(),
              'naemas' => $naemas,
              'produits' => $niNineaproposition->getNinproduits(),
              
        ]);
    }
 





      /**
     * @Route("/suppActiviteEtProduitsHisto/{id}", name="suppActiviteEtProduitsHisto", methods={"GET", "POST"})
     */
    public function suppActiviteEtProduitsHisto(Request $request, EntityManagerInterface $entityManager,$id=""): Response
    {
        $session= new Session();
        $session->set('actived',3);

        $activite =  $entityManager->getRepository(NiActivite::class)->find($id);
        $niNinea= $activite->getNINinea();

      //  $activite->getModifiedBy($this->getUser());
        $activite->setDateDeCloture(new \DateTime());

        $entityManager->flush();

        return $this->redirectToRoute('n_i_ninea_edit', ["id"=> $niNinea->getId()], Response::HTTP_SEE_OTHER);

    }


       /**
     * @Route("/modifierDirigeantsHisto/{id}", name="modifierDirigeantsHisto", methods={"GET", "POST"})
     */
    public function modifierDirigeantsHisto(Request $request, EntityManagerInterface $entityManager,$id=""): Response
    {
        $session= new Session();
        $session->set('actived',5);

        $dirigeant =  $entityManager->getRepository(NiDirigeant::class)->find($id);
        $niNinea= $dirigeant->getNINinea();

   //var_dump($civilites);
   if($request->get("valider"))
   {
     $dirigeantNouveau =  new NiDirigeant();

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
     $qvh = $request->get("qvh");

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
     $dirigeantNouveau->setNinQvh($entityManager->getRepository(QVH::class)->find($qvh));
    
     $niNineaproposition=$niNinea->getNinNumerodemande();
     $dirigeantNouveau->setNINinea($niNinea);
     $dirigeantNouveau->setNinNineaProposition($niNineaproposition);

     $dirigeant->setDateDeCloture(new \DateTime());

     //var_dump($dirigeantNouveau);
     
     $entityManager->persist($dirigeantNouveau);
     $entityManager->flush();
    
     return $this->redirectToRoute('n_i_ninea_edit', ["id"=> $niNinea->getId()], Response::HTTP_SEE_OTHER);
   
    
   }
   else if($request->get("enlever"))
   {
    $entityManager->remove($dirigeant);
    //$dirigeant->getModifiedBy($this->getUser());
    $dirigeant->setDateDeCloture(new \DateTime());

    $entityManager->flush();

    return $this->redirectToRoute('n_i_ninea_edit', ["id"=> $niNinea->getId()], Response::HTTP_SEE_OTHER);


   }


       // var_dump($dirigeant);
       return $this->redirectToRoute('n_i_ninea_edit', ["id"=> $niNinea->getId(),"dirigeant"=> $dirigeant->getId()], Response::HTTP_SEE_OTHER);


    }


          /**
     * @Route("/editDirigeant/{id}", name="ninea_editDirigeant", methods={"GET", "POST"})
     */
    public function editDirigeant(Request $request, EntityManagerInterface $entityManager,$id=""): Response
    {
        $lastdirigeant =  $entityManager->getRepository(NiDirigeant::class)->find($id);
        $anciendirigeant = new NiDirigeant();

        $anciendirigeant->setNinTelephone1( $lastdirigeant->getNinTelephone1());
        $anciendirigeant->setNinTelephone2( $lastdirigeant->getNinTelephone2());
        $anciendirigeant->setNinEmail( $lastdirigeant->getNinEmail());
        $anciendirigeant->setNinNom( $lastdirigeant->getNinNom());
        $anciendirigeant->setNinPrenom( $lastdirigeant->getNinPrenom());
        if ( $lastdirigeant->getNinCivilite()) {
            $anciendirigeant->setNinCivilite($lastdirigeant->getNinCivilite()) ;
         }else
             $civilite ="" ;

        if ( $lastdirigeant->getNinDatenais())
           $anciendirigeant->setNinDatenais(($lastdirigeant->getNinDatenais()));
        else
            $datenais = "";

        if ( $lastdirigeant->getNinNationalite())
            $anciendirigeant->setNinNationalite($lastdirigeant->getNinNationalite());
        else
            $nationalite = "";

        if ( $lastdirigeant->getNinSexe())
            $anciendirigeant->setNinSexe($lastdirigeant->getNinSexe())    ;
        else
           $nsexe = "";

        if ( $lastdirigeant->getNinDateCni())
              $anciendirigeant->setNinDateCni($lastdirigeant->getNinDateCni());
          else
              $datecni = "";
              $datepassport = "";

          if ($lastdirigeant->getNinPosition())          
            $anciendirigeant->setNinPosition($lastdirigeant->getNinPosition());
          else
            $qualification = "";

            //QVH POUR PERSONNE
          if ( $lastdirigeant->getNinQvh()) {
            $anciendirigeant->setNinQvh($lastdirigeant->getNinQvh());
          }else
              $qvh_dirig ="" ;

            $anciendirigeant->setNincni( $lastdirigeant->getNincni());

            $telephone1 = $lastdirigeant->getNinTelephone1();
            $telephone2 = $lastdirigeant->getNinTelephone2();
            $email = $lastdirigeant->getNinEmail();
            $nom = $lastdirigeant->getNinNom();
            $prenom = $lastdirigeant->getNinPrenom();

        if ( $lastdirigeant->getNinCivilite()) {
           $civilite =  $lastdirigeant->getNinCivilite()->getId() ;
        }else
            $civilite ="" ;

         if ( $lastdirigeant->getNinDatenais())
           $datenais =   $lastdirigeant->getNinDatenais()->format("Y-m-d");
         else
            $datenais = "";

         if ( $lastdirigeant->getNinNationalite())
            $nationalite =  $lastdirigeant->getNinNationalite()->getId();
          else
            $nationalite = "";

          if ( $lastdirigeant->getNinSexe())
            $nsexe =  $lastdirigeant->getNinSexe()->getId()    ;
          else
           $nsexe = "";

           if ( $lastdirigeant->getNinDateCni())
            {
                $datecni =  $lastdirigeant->getNinDateCni()->format("Y-m-d");
                $datepassport =  $lastdirigeant->getNinDateCni()->format("Y-m-d");
            }
              
            else
            {
                $datecni = "";
                $datepassport = "";
            }

          if ($lastdirigeant->getNinPosition())          
            $qualification = $lastdirigeant->getNinPosition()->getId();
          else
            $qualification = "";

            //QVH POUR PERSONNE
          if ( $lastdirigeant->getNinQvh()) {
            $qvh_dirig = $lastdirigeant->getNinQvh();
          }else
              $qvh_dirig ="" ;

          if ( $lastdirigeant->getNinQvh()) {
            $cacr_dirig = $lastdirigeant->getNinQvh()->getQvhCACRID()->getId();
          }else
            $cacr_dirig ="" ;

          if ( $lastdirigeant->getNinQvh()) {
            $cav_dirig = $lastdirigeant->getNinQvh()->getQvhCACRID()->getCacrCAVID()->getId();
          }else
              $cav_dirig ="" ;

          if ( $lastdirigeant->getNinQvh()) {
              $departement_dirig = $lastdirigeant->getNinQvh()->getQvhCACRID()->getCacrCAVID()->getCavDEPID()->getId();
          }else
              $departement_dirig ="" ;

          if ( $lastdirigeant->getNinQvh()) {
             $region_dirig = $lastdirigeant->getNinQvh()->getQvhCACRID()->getCacrCAVID()->getCavDEPID()->getDepRegCD()->getId();
          }else
              $region_dirig ="" ;

        $departements = $entityManager->getRepository(Departement::class)->findAll();
        $cavs = $entityManager->getRepository(CAV::class)->findAll();
        $cacrs = $entityManager->getRepository(CACR::class)->findAll();
      
        $lieunais =   $lastdirigeant->getNinLieunais();
        $cni =  $lastdirigeant->getNinCni() ;
        $passport =  $lastdirigeant->getNinCni();

        $sexe = $entityManager->getRepository(NiSexe::class)->findAll();
        $nationalites = $entityManager->getRepository(Pays::class)->findAll();
        $civilites = $entityManager->getRepository(NiCivilite::class)->findAll();
        $qualifications = $entityManager->getRepository(Qualite::class)->findAll();

        $regions = $entityManager->getRepository(Region::class)->findAll();

        if ($request->get("editer")) 

          {              
              $civilite = $request->get("civilite");
              $qualificationdirig = $request->get("qualification");
              $datenais = $request->get("datenais");
              $lieunais = $request->get("lieunais");
              $email = $request->get('email');
              $telephone1 = $request->get('telephone1');
              $telephone2 = $request->get('telephone2');
              $prenom = $request->get('prenom');
              $nom = $request->get('nom');
              $nationalite = $request->get("nationalite");
                        
              $qvh = $request->get("qvh_dirig"); 

              $lastdirigeant->setNinQvh($entityManager->getRepository(QVH::class)->find($qvh));
              $lastdirigeant->setNinPrenom($prenom);
              $lastdirigeant->setNinNom($nom);
              $lastdirigeant->setNinPosition($entityManager->getRepository(NiCivilite::class)->find($qualification));
              $lastdirigeant->setNinEmail($email);
              $lastdirigeant->setNinCivilite($entityManager->getRepository(NiCivilite::class)->find($civilite));
              $lastdirigeant->setNinDatenais(new \DateTime($datenais));
              $lastdirigeant->setNinLieunais($lieunais);
              $lastdirigeant->setNinTelephone1($telephone1);
              $lastdirigeant->getNinTelephone2($telephone2);

              $lastdirigeant->setNinNationalite($entityManager->getRepository(Pays::class)->find($nationalite));
              $lastdirigeant->setNinSexe($entityManager->getRepository(NiSexe::class)->find($nsexe));
              $lastdirigeant->setNinPosition($entityManager->getRepository(Qualite::class)->find($qualificationdirig));

              if( $nationalite=="07"){
                  $Cni = $request->get("cni");
                  $Datecni = $request->get("dateCni");
                  $lastdirigeant->setNinCni($Cni);
                  $lastdirigeant->setNinDateCni(new \DateTime($Datecni));
              }
              else {
                  $Passport = $request->get("passport");
                  $Datepassport = $request->get("datepassport");
                  $lastdirigeant->setNinCni($Passport);
                  $lastdirigeant->setNinDateCni(new \DateTime($Datepassport));
              }

                $lastdirigeant->setCreatedBy($this->getUser());
                $lastdirigeant->setModifiedBy($this->getUser());

                $entityManager->persist($anciendirigeant);

                $entityManager->flush();

                return $this->redirectToRoute('nininea_show', ["id"=>$lastdirigeant->getNINinea()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ni_ninea/editDirigeant.html.twig', [
            
            'sexes' => $sexe,
            'nationalites' => $nationalites,
            'civilites' => $civilites,
            'lastdirigeant' => $lastdirigeant,
          
            'qualification' => $qualification,
            'qualifications' => $qualifications,
            'civilite' => $civilite,
            'datenais' => $datenais,
            'lieunais' => $lieunais,
            'nationalite' => $nationalite,
            'nsexe' => $nsexe,
            'Cni' => $cni,
            'dateCni' => $datecni,
            'passport' => $passport,
            'datepassport' => $datepassport,
            'sexe'=> $sexe,
            'email' => $email,
            'telephone1' => $telephone1,
            'telephone2' => $telephone2,
            'email' => $email,
            'prenom' => $prenom, 
            'nom' => $nom,

            'region_dirig' => $region_dirig,
            'departement_dirig' => $departement_dirig,
            'cav_dirig' => $cav_dirig,
            'cacr_dirig' => $cacr_dirig,
            'qvh_dirig' => $qvh_dirig,
            'regions'=>$regions,
            'departements'=>$departements,
            'cavs'=>$cavs,
            'cacrs'=>$cacrs,
           
           
        ]);
    }


      /**
     * @Route("/editActivitesEconomiques/{id}", name="nininea_editActivitesEconomiques", methods={"GET", "POST"})
     */
    public function editActivitesEconomiques(Request $request, EntityManagerInterface $entityManager, $id=""): Response
    {


        $session= new Session();
        $session->set('actived',4);

        if ($request->get('modifierActivitesEcos')) 
        {


        $lastacteconom=$entityManager->getRepository(NiActiviteEconomique::class)->find($id);
        $acteconom = new NiActiviteEconomique();

        $ninAffaire = $request->get("ninAffaire");
          $ninAnneeCa =  $request->get("ninAnneeCa");
          $ninCapital = $request->get("ninCapital");
          $ninEffectif = $request->get("ninEffectif");
          $ninEffect1 = $request->get("ninEffect1");
          $ninEffectifFem = $request->get("ninEffectifFem");
          $ninEffectifFemSAIS = $request->get("ninEffectifFemSAIS");

           $acteconom->setNinAffaire($ninAffaire);
           $acteconom->setNinAnneeCa($ninAnneeCa);
           $acteconom->setNinCapital($ninCapital);
           $acteconom->setNinEffectif($ninEffectif);
           $acteconom->setNinEffect1($ninEffect1);
           $acteconom->setNinEffectifFem($ninEffectifFem);
           $acteconom->setNinEffectifFemSAIS($ninEffectifFemSAIS);  

        $niNineaproposition= $lastacteconom->getNiNineaproposition();
        $niNinea= $lastacteconom->getNINinea();

         $acteconom->setCreateBy($this->getUser());
        // $acteconom->setUpdatedBy($this->getUser());

         
         $acteconom->setNINinea($niNinea);
        $acteconom->setNiNineaproposition($niNineaproposition);

       // $lastacteconom->setUpdatedBy($this->getUser());
        $lastacteconom->setDeteDeCloture(new \DateTime());

        $entityManager->persist($acteconom);
        $entityManager->flush();

            return $this->redirectToRoute('n_i_ninea_edit', ["id"=> $niNinea->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ni_ninea/editActiviteEconomique.html.twig', [
            'form' => $form,           
            'nineapropsition' => $nineapropsition,
           
        ]);
    }

    /**
     * @Route("/delete/{id}", name="n_i_ninea_delete", methods={"POST","GET"})
     */
    public function delete(Request $request, NINinea $nINinea, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($nINinea);
        $entityManager->flush();
        return $this->redirectToRoute('n_i_ninea_index', [], Response::HTTP_SEE_OTHER);
    }
}