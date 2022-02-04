<?php

namespace App\Controller;

use App\Entity\RefAgg;
use App\Form\RefAggType;
use App\Repository\RefAggRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ref/agg")
 */
class RefAggController extends AbstractController
{
    /**
     * @Route("/", name="ref_agg_index", methods={"GET"})
     */
    public function index(RefAggRepository $refAggRepository): Response
    {
        return $this->render('ref_agg/index.html.twig', [
            'ref_aggs' => $refAggRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="ref_agg_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $refAgg = new RefAgg();
        $form = $this->createForm(RefAggType::class, $refAgg);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($refAgg);
            $entityManager->flush();

            return $this->redirectToRoute('ref_agg_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ref_agg/new.html.twig', [
            'ref_agg' => $refAgg,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="ref_agg_show", methods={"GET"})
     */
    public function show(RefAgg $refAgg): Response
    {
        return $this->render('ref_agg/show.html.twig', [
            'ref_agg' => $refAgg,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ref_agg_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, RefAgg $refAgg, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RefAggType::class, $refAgg);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('ref_agg_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ref_agg/edit.html.twig', [
            'ref_agg' => $refAgg,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="ref_agg_delete", methods={"POST"})
     */
    public function delete(Request $request, RefAgg $refAgg, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$refAgg->getId(), $request->request->get('_token'))) {
            $entityManager->remove($refAgg);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ref_agg_index', [], Response::HTTP_SEE_OTHER);
    }
}
