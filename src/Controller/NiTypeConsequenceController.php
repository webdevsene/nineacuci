<?php

namespace App\Controller;

use App\Entity\NiTypeConsequence;
use App\Form\NiTypeConsequenceType;
use App\Repository\NiTypeConsequenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ni/type/consequence")
 */
class NiTypeConsequenceController extends AbstractController
{
    /**
     * @Route("/", name="app_ni_type_consequence_index", methods={"GET"})
     */
    public function index(NiTypeConsequenceRepository $niTypeConsequenceRepository): Response
    {
        return $this->render('ni_type_consequence/index.html.twig', [
            'ni_type_consequences' => $niTypeConsequenceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_ni_type_consequence_new", methods={"GET", "POST"})
     */
    public function new(Request $request, NiTypeConsequenceRepository $niTypeConsequenceRepository): Response
    {
        $niTypeConsequence = new NiTypeConsequence();
        $form = $this->createForm(NiTypeConsequenceType::class, $niTypeConsequence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $niTypeConsequenceRepository->add($niTypeConsequence, true);

            return $this->redirectToRoute('app_ni_type_consequence_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ni_type_consequence/new.html.twig', [
            'ni_type_consequence' => $niTypeConsequence,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ni_type_consequence_show", methods={"GET"})
     */
    public function show(NiTypeConsequence $niTypeConsequence): Response
    {
        return $this->render('ni_type_consequence/show.html.twig', [
            'ni_type_consequence' => $niTypeConsequence,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_ni_type_consequence_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, NiTypeConsequence $niTypeConsequence, NiTypeConsequenceRepository $niTypeConsequenceRepository): Response
    {
        $form = $this->createForm(NiTypeConsequenceType::class, $niTypeConsequence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $niTypeConsequenceRepository->add($niTypeConsequence, true);

            return $this->redirectToRoute('app_ni_type_consequence_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ni_type_consequence/edit.html.twig', [
            'ni_type_consequence' => $niTypeConsequence,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ni_type_consequence_delete", methods={"POST"})
     */
    public function delete(Request $request, NiTypeConsequence $niTypeConsequence, NiTypeConsequenceRepository $niTypeConsequenceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$niTypeConsequence->getId(), $request->request->get('_token'))) {
            $niTypeConsequenceRepository->remove($niTypeConsequence, true);
        }

        return $this->redirectToRoute('app_ni_type_consequence_index', [], Response::HTTP_SEE_OTHER);
    }
}
