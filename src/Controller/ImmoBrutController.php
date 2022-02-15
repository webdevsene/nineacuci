<?php

namespace App\Controller;

use App\Entity\ImmoBrut;
use App\Form\ImmoBrutType;
use App\Repository\ImmoBrutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/immo/brut")
 */
class ImmoBrutController extends AbstractController
{
    /**
     * @Route("/", name="immo_brut_index", methods={"GET"})
     */
    public function index(ImmoBrutRepository $immoBrutRepository): Response
    {
        return $this->render('immo_brut/index.html.twig', [
            'immo_bruts' => $immoBrutRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="immo_brut_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $immoBrut = new ImmoBrut();
        $form = $this->createForm(ImmoBrutType::class, $immoBrut);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($immoBrut);
            $entityManager->flush();

            return $this->redirectToRoute('immo_brut_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('immo_brut/new.html.twig', [
            'immo_brut' => $immoBrut,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="immo_brut_show", methods={"GET"})
     */
    public function show(ImmoBrut $immoBrut): Response
    {
        return $this->render('immo_brut/show.html.twig', [
            'immo_brut' => $immoBrut,
        ]);
    }

         /**
     * @Route("/nineaNumImmoBrut/{id}", name="nineaNumImmoBrut", methods={"GET"})
     */
    public function nineaNumImmoBrut( $id="")
    {
        $tab=[];
        $rep=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$id]);
        $session=new Session();
       // $session->start();
        $session->set('codeCuci',$id);

    
              
        return new JsonResponse( $rep->getDenominationSocial());
    }


      /**
     * @Route("/immoBrutjson/{annee}", name="immoBrutjson", methods={"GET","POST"})
     */
    public function immoBrutjson( $annee="")
    {
        $tab=[];
        $tab1=[];
        $tab2=[];
        $tab3=[];


        $session=new Session();
        $codeCuci= $session->get('codeCuci');
        
        $immoBrut=$this->getDoctrine()->getRepository(ImmoBrut::class)->findByCodeCuci($codeCuci,$annee);
       


        $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]);


        $refAgg=$this->getDoctrine()->getRepository(RefAgg::class)->findBy(["category"=>4,"surlignee"=>0],  array('code' => 'ASC'));

        $refAggParent=$this->getDoctrine()->getRepository(RefAgg::class)->findBy(["category"=>4,"surlignee"=>1],array('code' => 'ASC'));

      

        foreach ($refAgg as $key ) {

             array_push($tab2,[$key->getCode(),$key->getLibelle(),$key->getParent(),$key->getOrdre(),$key->getSurlignee()]);
        } 


        foreach ($refAggParent as $key ) {

             array_push($tab3,[$key->getCode(),$key->getLibelle(),$key->getParent(),$key->getOrdre(),$key->getSurlignee()]);
        } 
  
         array_push($tab,$tab2);
         array_push($tab,$tab3);

              
        return new JsonResponse( $tab);
    }

    /**
     * @Route("/{id}/edit", name="immo_brut_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ImmoBrut $immoBrut, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ImmoBrutType::class, $immoBrut);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('immo_brut_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('immo_brut/edit.html.twig', [
            'immo_brut' => $immoBrut,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="immo_brut_delete", methods={"POST"})
     */
    public function delete(Request $request, ImmoBrut $immoBrut, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$immoBrut->getId(), $request->request->get('_token'))) {
            $entityManager->remove($immoBrut);
            $entityManager->flush();
        }

        return $this->redirectToRoute('immo_brut_index', [], Response::HTTP_SEE_OTHER);
    }
}
