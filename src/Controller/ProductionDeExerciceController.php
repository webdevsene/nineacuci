<?php

namespace App\Controller;

use App\Entity\ProductionDeExercice;
use App\Entity\ProductionDeExerciceUtil;
use App\Entity\Repertoire;
use App\Form\ProductionDeExerciceType;
use App\Form\ProductionDeExerciceUtilType;
use App\Repository\ProductionDeExerciceRepository;
use App\Repository\RepertoireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/production/exercice")
 * @IsGranted("ROLE_USER")
 */
class ProductionDeExerciceController extends AbstractController
{
    private  $requestStack;
    
    public function __construct(RepertoireRepository $rep, RequestStack $requestStack)
    {
        // parent::__construct();
        $this->rep = $rep;
        $this->requestStack = $requestStack;
        
    }
    /**
     * @Route("/", name="app_production_de_exercice_index", methods={"GET"})
     */
    public function index(ProductionDeExerciceRepository $productionDeExerciceRepository): Response
    {
        return $this->render('production_de_exercice/index.html.twig', [
            'production_de_exercices' => $productionDeExerciceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_production_de_exercice_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $session = $this->requestStack->getSession();

        $codeCuci = $session->get('codeCuci');
        $annee = $session->get('annee');
        # $codeCuci = $request->get('codeCuci');
        # $annee = $request->get('annee'); cceci ne marche pas 

        # dd($codeCuci.''.$annee);

        $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]);

        $prod_exer = $this->getDoctrine()
                         ->getRepository(ProductionDeExercice::class)
                         ->findOneBy(["repertoire"=>$repertoire, "anneeFinanciere"=>$annee]);
        
        $form = null;

        $submit_prod = false;
            
        if($request->get('submited')){
            $submit_prod=1;

        }
        
        #elseif(!$request->get('notsubmited'))
        else{
            $submit_prod=0;

        }
        
        if ($prod_exer) {
            $prod_de_exer_util = $prod_exer->getProductionDeExerciceUtil();

            $form = $this->createForm(ProductionDeExerciceUtilType::class, $prod_de_exer_util); 
            $form->handleRequest($request);
        
            if ($form->isSubmitted() && $form->isValid()) {
                $prod_exer->setUpdatedAt(new \DateTime());
                $em->flush();

                return $this->redirectToRoute('achat_production_new', [
                ], Response::HTTP_SEE_OTHER);
    
                    
            }

                
        } else {

            $prodExerciceUtil = new ProductionDeExerciceUtil();

            // creer le formulaire à partir de la class util
            $form = $this->createForm(ProductionDeExerciceUtilType::class, $prodExerciceUtil); 
        
            $form->handleRequest($request);
        
            if ($form->isSubmitted() && $form->isValid()) {
            
                /// recuperer le repertoire cuci correspondant
                $repertoire = $em->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$request->get("codecuci") ]);
            
                foreach ($prodExerciceUtil->getProductionDeExercices() as $key) {
                              
                    // # setter les valeur saisie 
                    $key->setRepertoire($repertoire);
                
                    $key->setAnneeFinanciere($request->get('annee'))
                             ->setSubmit($submit_prod)
                             ->setUpdatedAt(new \DateTime())
                             ->setCreatedBy($this->getUser())
                             ->setUpdatedBy($this->getUser());
                
                    $em->persist($prodExerciceUtil);
                    $em->flush();
                }
            

                # return $this->redirectToRoute('app_production_de_exercice_new', [], Response::HTTP_SEE_OTHER);
                
                return $this->redirectToRoute('achat_production_new', [
                ], Response::HTTP_SEE_OTHER);

            }    
        }
        return $this->renderForm('production_de_exercice/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_production_de_exercice_show", methods={"GET"})
     */
    public function show(ProductionDeExercice $productionDeExercice): Response
    {
        return $this->render('production_de_exercice/show.html.twig', [
            'production_de_exercice' => $productionDeExercice,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_production_de_exercice_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ProductionDeExercice $productionDeExercice, ProductionDeExerciceRepository $productionDeExerciceRepository): Response
    {
        $form = $this->createForm(ProductionDeExerciceType::class, $productionDeExercice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productionDeExerciceRepository->add($productionDeExercice);
            return $this->redirectToRoute('app_production_de_exercice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('production_de_exercice/edit.html.twig', [
            'production_de_exercice' => $productionDeExercice,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_production_de_exercice_delete", methods={"POST"})
     */
    public function delete(Request $request, ProductionDeExercice $productionDeExercice, ProductionDeExerciceRepository $productionDeExerciceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$productionDeExercice->getId(), $request->request->get('_token'))) {
            $productionDeExerciceRepository->remove($productionDeExercice);
        }

        return $this->redirectToRoute('app_production_de_exercice_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/nineaNumProduction/{id}", name="nineaNumProduction", methods={"GET"})
     */
    public function nineaNumAchat($id="")
    {
        $repertoire = $this->rep->findOneBy(['codeCuci' => $id]);
        $session=new Session();
        $session->set('codeCuci',$id);

        return new JsonResponse($repertoire->getDenominationSocial());
        
    }
}
