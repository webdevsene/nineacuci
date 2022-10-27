<?php

namespace App\Controller;

use App\Entity\RefNomenclatureRc;
use App\Form\RefNomenclatureRcType;
use App\Repository\RefNomenclatureRcRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ref/nomenclature/rc")
 */
class RefNomenclatureRcController extends AbstractController
{
    /**
     * @Route("/", name="app_ref_nomenclature_rc_index", methods={"GET"})
     */
    public function index(RefNomenclatureRcRepository $refNomenclatureRcRepository): Response
    {
        return $this->render('ref_nomenclature_rc/index.html.twig', [
            'ref_nomenclature_rcs' => $refNomenclatureRcRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_ref_nomenclature_rc_new", methods={"GET", "POST"})
     */
    public function new(Request $request, RefNomenclatureRcRepository $refNomenclatureRcRepository): Response
    {
        $refNomenclatureRc = new RefNomenclatureRc();
        $form = $this->createForm(RefNomenclatureRcType::class, $refNomenclatureRc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $refNomenclatureRcRepository->add($refNomenclatureRc, true);

            return $this->redirectToRoute('app_ref_nomenclature_rc_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ref_nomenclature_rc/new.html.twig', [
            'ref_nomenclature_rc' => $refNomenclatureRc,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ref_nomenclature_rc_show", methods={"GET"})
     */
    public function show(RefNomenclatureRc $refNomenclatureRc): Response
    {
        return $this->render('ref_nomenclature_rc/show.html.twig', [
            'ref_nomenclature_rc' => $refNomenclatureRc,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_ref_nomenclature_rc_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, RefNomenclatureRc $refNomenclatureRc, RefNomenclatureRcRepository $refNomenclatureRcRepository): Response
    {
        $form = $this->createForm(RefNomenclatureRcType::class, $refNomenclatureRc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $refNomenclatureRcRepository->add($refNomenclatureRc, true);

            return $this->redirectToRoute('app_ref_nomenclature_rc_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ref_nomenclature_rc/edit.html.twig', [
            'ref_nomenclature_rc' => $refNomenclatureRc,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ref_nomenclature_rc_delete", methods={"POST"})
     */
    public function delete(Request $request, RefNomenclatureRc $refNomenclatureRc, RefNomenclatureRcRepository $refNomenclatureRcRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$refNomenclatureRc->getId(), $request->request->get('_token'))) {
            $refNomenclatureRcRepository->remove($refNomenclatureRc, true);
        }

        return $this->redirectToRoute('app_ref_nomenclature_rc_index', [], Response::HTTP_SEE_OTHER);
    }
}
