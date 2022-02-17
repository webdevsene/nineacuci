<?php

namespace App\Controller;

use App\Entity\FluxDesTresoreries;
use App\Form\FluxDesTresoreriesType;
use App\Repository\FluxDesTresoreriesRepository;
use App\Repository\RefAggRepository;
use App\Repository\RepertoireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/flux/tresoreries")
 */
class FluxDesTresoreriesController extends AbstractController
{
    private $requestStack;
     
     public function __construct(RequestStack $requestStack, 
                                 RepertoireRepository $reperRepo, 
                                 FluxDesTresoreriesRepository $fdtRepo,
                                 RefAggRepository $refAggRepo)
     {
         $this->requestStack = $requestStack;
         $this->reperRepo = $reperRepo;
         $this->fdtRepo = $fdtRepo;
         $this->refAggRepo = $refAggRepo;
     }


    /**
     * @Route("/", name="flux_des_tresoreries_index", methods={"GET"})
     */
    public function index(FluxDesTresoreriesRepository $fluxDesTresoreriesRepository): Response
    {
        return $this->render('flux_des_tresoreries/index.html.twig', [
            'flux_des_tresoreries' => $fluxDesTresoreriesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="flux_des_tresoreries_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $fluxDesTresorery = new FluxDesTresoreries();
        $form = $this->createForm(FluxDesTresoreriesType::class, $fluxDesTresorery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($fluxDesTresorery);
            $entityManager->flush();

            return $this->redirectToRoute('flux_des_tresoreries_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('flux_des_tresoreries/new.html.twig', [
            'flux_des_tresorery' => $fluxDesTresorery,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="flux_des_tresoreries_show", methods={"GET"})
     */
    public function show(FluxDesTresoreries $fluxDesTresorery): Response
    {
        return $this->render('flux_des_tresoreries/show.html.twig', [
            'flux_des_tresorery' => $fluxDesTresorery,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="flux_des_tresoreries_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, FluxDesTresoreries $fluxDesTresorery, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FluxDesTresoreriesType::class, $fluxDesTresorery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('flux_des_tresoreries_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('flux_des_tresoreries/edit.html.twig', [
            'flux_des_tresorery' => $fluxDesTresorery,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="flux_des_tresoreries_delete", methods={"POST"})
     */
    public function delete(Request $request, FluxDesTresoreries $fluxDesTresorery, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fluxDesTresorery->getId(), $request->request->get('_token'))) {
            $entityManager->remove($fluxDesTresorery);
            $entityManager->flush();
        }

        return $this->redirectToRoute('flux_des_tresoreries_index', [], Response::HTTP_SEE_OTHER);
    }

    
     /**
     * @Route("/cucicodeNum/{id}", name="cucicodeNum", methods={"GET","POST"})
     */
    public function cucicodeNum(Request $request, $id="")
    {
        $tab=[];
        if ($request->isXmlHttpRequest()) {
            
            // $rep=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$id]);

            $rep = $this->reperRepo->findOneBy(["codeCuci"=>$id]);


            $session = $this->requestStack->getSession();
            // stores an attribute in the session for later reuse
            $session->set('codeCuci', $id);
        }
    
              
        return new JsonResponse( $rep->getDenominationSocial());
    }

    
    /**
     * @Route("/fluxtresorjson/{annee}", name="fluxtresorjson", methods={"GET","POST"})
     */
    public function fluxtresorjson( $annee="")
    {
        $tab=[];
        $tab1=[];
        $tab2=[];
        $tab3=[];
        $category = 3;

        $session = $this->requestStack->getSession();

        $codeCuci= $session->get('codeCuci');   

        //$flux = $this->fdtRepo->findByCodeCuci($codeCuci, $annee);
        $flux = $this->fdtRepo->findByCodeCuciAnneeAndCategory($codeCuci, $annee);
            
            foreach ($flux as $key ) {

                 $tab1[$key->getRefCode()] = [$key->getRefCode(),$key->getNet1(), $key->getNet2()];
                
    
            } 
    
            $refAgg = $this->refAggRepo
                           ->findBy(["category"=>3,"surlignee"=>0],  array('code' => 'DESC'));
                
            $refAggParent=$this->refAggRepo
                               ->findBy(["category"=>3,"surlignee"=>1],array('code' => 'DESC'));
    
            foreach ($refAgg as $key ) {
    
                 array_push($tab2,[$key->getCode(),$key->getLibelle(),$key->getParent(),$key->getOrdre(),$key->getSurlignee()]); // c'est ici qu'on ajoutera la note et le signe
            } 
    
    
            foreach ($refAggParent as $key ) {
    
                 array_push($tab3,[$key->getCode(),$key->getLibelle(),$key->getParent(),$key->getOrdre(),$key->getSurlignee()]);
            } 
    
    
             array_push($tab,$tab1);
             array_push($tab,$tab2);
             array_push($tab,$tab3);
        
        return new JsonResponse( $tab);
    }
}
