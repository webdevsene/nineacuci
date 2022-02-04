<?php

namespace App\Controller;

use App\Entity\NAEMAS;
use App\Entity\CategoryNaemas;
use App\Form\NAEMASType;
use App\Repository\NAEMASRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/naemas")
 */
class NAEMASController extends AbstractController
{

    /**
     * @Route("/naemascat/{id}", name="naemascat", methods={"GET"})
     */
    public function naemascat( $id="")
    {
         $tab=[];
         $categorynaemas=$this->getDoctrine()->getRepository(CategoryNaemas::class)->find($id);
         foreach ($categorynaemas->getNaemas() as $key ) {

             array_push($tab,[$key->getId(),$key->getLibelle()]);
         }        
        return new JsonResponse( $tab);
    }
 




    /**
     * @Route("/", name="n_a_e_m_a_s_index", methods={"GET"})
     */
    public function index(NAEMASRepository $nAEMASRepository): Response
    {
        return $this->render('naemas/index.html.twig', [
            'n_a_e_m_as' => $nAEMASRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="n_a_e_m_a_s_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $nAEMA = new NAEMAS();
        $form = $this->createForm(NAEMASType::class, $nAEMA);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($nAEMA);
            $entityManager->flush();

            return $this->redirectToRoute('n_a_e_m_a_s_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('naemas/new.html.twig', [
            'n_a_e_m_a' => $nAEMA,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="n_a_e_m_a_s_show", methods={"GET"})
     */
    public function show(NAEMAS $nAEMA): Response
    {
        return $this->render('naemas/show.html.twig', [
            'n_a_e_m_a' => $nAEMA,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="n_a_e_m_a_s_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, NAEMAS $nAEMA, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NAEMASType::class, $nAEMA);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('n_a_e_m_a_s_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('naemas/edit.html.twig', [
            'n_a_e_m_a' => $nAEMA,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="n_a_e_m_a_s_delete", methods={"POST"})
     */
    public function delete(Request $request, NAEMAS $nAEMA, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$nAEMA->getId(), $request->request->get('_token'))) {
            $entityManager->remove($nAEMA);
            $entityManager->flush();
        }

        return $this->redirectToRoute('n_a_e_m_a_s_index', [], Response::HTTP_SEE_OTHER);
    }
}
