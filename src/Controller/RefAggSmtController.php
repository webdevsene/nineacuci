<?php

namespace App\Controller;

use App\Entity\RefAggSmt;
use App\Entity\RefAgg;
use App\Form\RefAggSmtType;
use App\Repository\RefAggSmtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/smt")
 * @IsGranted("ROLE_USER")
 */
class RefAggSmtController extends AbstractController
{
    /**
     * @Route("/", name="app_ref_agg_smt_index", methods={"GET"})
     */
    public function index(RefAggSmtRepository $refAggSmtRepository): Response
    {
        return $this->render('ref_agg_smt/index.html.twig', [
            'ref_agg_smts' => $refAggSmtRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_ref_agg_smt_new", methods={"GET", "POST"})
     */
    public function new(Request $request, RefAggSmtRepository $refAggSmtRepository): Response
    {
        $refAggSmt = new RefAggSmt();
        $form = $this->createForm(RefAggSmtType::class, $refAggSmt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $refAggSmtRepository->add($refAggSmt);
            return $this->redirectToRoute('app_ref_agg_smt_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ref_agg_smt/new.html.twig', [
            'ref_agg_smt' => $refAggSmt,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ref_agg_smt_show", methods={"GET"})
     */
    public function show(RefAggSmt $refAggSmt): Response
    {
        return $this->render('ref_agg_smt/show.html.twig', [
            'ref_agg_smt' => $refAggSmt,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_ref_agg_smt_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, RefAggSmt $refAggSmt, RefAggSmtRepository $refAggSmtRepository): Response
    {
        $form = $this->createForm(RefAggSmtType::class, $refAggSmt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $refAggSmtRepository->add($refAggSmt);
            return $this->redirectToRoute('app_ref_agg_smt_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ref_agg_smt/edit.html.twig', [
            'ref_agg_smt' => $refAggSmt,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ref_agg_smt_delete", methods={"POST"})
     */
    public function delete(Request $request, RefAggSmt $refAggSmt, RefAggSmtRepository $refAggSmtRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$refAggSmt->getId(), $request->request->get('_token'))) {
            $refAggSmtRepository->remove($refAggSmt);
        }

        return $this->redirectToRoute('app_ref_agg_smt_index', [], Response::HTTP_SEE_OTHER);
    }
}
