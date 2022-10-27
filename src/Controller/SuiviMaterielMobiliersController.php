<?php

namespace App\Controller;

use App\Entity\Repertoire;
use App\Entity\SuiviMaterielMobilier;
use App\Entity\SuiviMaterielMobilierUtilSmt;
use App\Form\SuiviMaterielMobilierType;
use App\Form\SuiviMaterielMobilierUtilSmtType;
use App\Repository\RepertoireRepository;
use App\Repository\SuiviMaterielMobilierRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/suivis")
 * @IsGranted("ROLE_USER")
 */
class SuiviMaterielMobiliersController extends AbstractController
{
    private  $requestStack;
    
    public function __construct(RepertoireRepository $rep, RequestStack $requestStack)
    {
        // parent::__construct();
        $this->rep = $rep;
        $this->requestStack = $requestStack;
        
    }

    /**
     * @Route("/", name="app_suivi_materiel_mobiliers_index", methods={"GET"})
     */
    public function index(SuiviMaterielMobilierRepository $suiviMaterielMobilierRepository): Response
    {
        return $this->render('suivi_materiel_mobiliers/index.html.twig', [
            'suivi_materiel_mobiliers' => $suiviMaterielMobilierRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_suivi_materiel_mobiliers_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $session = $this->requestStack->getSession();

        $codeCuci = $session->get('codeCuci');
        $annee = $session->get('annee');


        $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]);

        $obj_suivi_materiel_mobilier = $this->getDoctrine()
                         ->getRepository(SuiviMaterielMobilier::class)
                         ->findOneBy(["repertoire"=>$repertoire, "anneeFinanciere"=>$annee]);
        
        $form= null; $submit_suivi = null ;


        if($request->get('submited')){
            $submit_suivi=1;
           
        }
        if(!$request->get('notsubmited')){
            $submit_suivi=$request->get('notsubmited'); 
        }


        if ($obj_suivi_materiel_mobilier) {
            $obj_suivi_materiel_mobilier_util = $obj_suivi_materiel_mobilier->getSuiviMaterielMobilierUtilSmt();

            $form = $this->createForm(SuiviMaterielMobilierUtilSmtType::class, $obj_suivi_materiel_mobilier_util); 
            $form->handleRequest($request);
        
            if ($form->isSubmitted() && $form->isValid()) {

                $obj_suivi_materiel_mobilier->setUpdatedAt(new DateTime('now'));
                                            # ->setUpdatedBy($this->getUser())
                

                return $this->redirectToRoute('app_etat_des_stocks_smt_new', [], Response::HTTP_SEE_OTHER);
                                
                                            
                $em->flush();
            }
            
        }else {
            
            $obj_suivi_materiel_util = new SuiviMaterielMobilierUtilSmt();
            $form = $this->createForm(SuiviMaterielMobilierUtilSmtType::class, $obj_suivi_materiel_util);
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) {

                $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$session->get('codeCuci')]); 
                
                foreach ($obj_suivi_materiel_util->getSuiviMaterielMobiliers() as $obj) {
                    $obj->setRepertoire($repertoire)
                        ->setCreatedBy($this->getUser())
                        ->setUpdatedBy($this->getUser())
                        ->setSubmit($submit_suivi)
                        ->setStatus('valide')
                        ->setAnneeFinanciere($session->get('annee'));
                }


                $em->persist($obj_suivi_materiel_util);
                $em->flush();
    
                return $this->redirectToRoute('app_etat_des_stocks_smt_new', [
                ], Response::HTTP_SEE_OTHER);

    
            }
                
        }
   

        
        return $this->renderForm('suivi_materiel_mobiliers/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_suivi_materiel_mobiliers_show", methods={"GET"})
     */
    public function show(SuiviMaterielMobilier $suiviMaterielMobilier): Response
    {
        return $this->render('suivi_materiel_mobiliers/show.html.twig', [
            'suivi_materiel_mobilier' => $suiviMaterielMobilier,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_suivi_materiel_mobiliers_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, SuiviMaterielMobilier $suiviMaterielMobilier, SuiviMaterielMobilierRepository $suiviMaterielMobilierRepository): Response
    {
        $form = $this->createForm(SuiviMaterielMobilierType::class, $suiviMaterielMobilier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $suiviMaterielMobilierRepository->add($suiviMaterielMobilier);
            return $this->redirectToRoute('app_suivi_materiel_mobiliers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('suivi_materiel_mobiliers/edit.html.twig', [
            'suivi_materiel_mobilier' => $suiviMaterielMobilier,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_suivi_materiel_mobiliers_delete", methods={"POST"})
     */
    public function delete(Request $request, SuiviMaterielMobilier $suiviMaterielMobilier, SuiviMaterielMobilierRepository $suiviMaterielMobilierRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$suiviMaterielMobilier->getId(), $request->request->get('_token'))) {
            $suiviMaterielMobilierRepository->remove($suiviMaterielMobilier);
        }

        return $this->redirectToRoute('app_suivi_materiel_mobiliers_index', [], Response::HTTP_SEE_OTHER);
    }
}
