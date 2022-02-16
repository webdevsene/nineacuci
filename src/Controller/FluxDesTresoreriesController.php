<?php

namespace App\Controller;

use App\Entity\FluxDesTresoreries;
use App\Form\FluxDesTresoreriesType;
use App\Repository\CompteDeResultatsRepository;
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
                                 CompteDeResultatsRepository $cdtRepo,
                                 RefAggRepository $refAggRepo)
     {
         $this->requestStack = $requestStack;
         $this->reperRepo = $reperRepo;
         $this->cdtRepo = $cdtRepo;
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
}
