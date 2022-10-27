<?php

namespace App\Controller;

use App\Entity\NiResponsable;
use App\Form\NiResponsableType;
use App\Repository\NiResponsableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ni/responsable")
 */
class NiResponsableController extends AbstractController
{
    /**
     * @Route("/", name="app_ni_responsable_index", methods={"GET"})
     */
    public function index(NiResponsableRepository $niResponsableRepository): Response
    {
        return $this->render('ni_responsable/index.html.twig', [
            'ni_responsables' => $niResponsableRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_ni_responsable_new", methods={"GET", "POST"})
     */
    public function new(Request $request, NiResponsableRepository $niResponsableRepository): Response
    {
        $niResponsable = new NiResponsable();
        $form = $this->createForm(NiResponsableType::class, $niResponsable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $niResponsableRepository->add($niResponsable, true);

            return $this->redirectToRoute('app_ni_responsable_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ni_responsable/new.html.twig', [
            'ni_responsable' => $niResponsable,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ni_responsable_show", methods={"GET"})
     */
    public function show(NiResponsable $niResponsable): Response
    {
        return $this->render('ni_responsable/show.html.twig', [
            'ni_responsable' => $niResponsable,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_ni_responsable_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, NiResponsable $niResponsable, NiResponsableRepository $niResponsableRepository): Response
    {
        $form = $this->createForm(NiResponsableType::class, $niResponsable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $niResponsableRepository->add($niResponsable, true);

            return $this->redirectToRoute('app_ni_responsable_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ni_responsable/edit.html.twig', [
            'ni_responsable' => $niResponsable,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ni_responsable_delete", methods={"POST"})
     */
    public function delete(Request $request, NiResponsable $niResponsable, NiResponsableRepository $niResponsableRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$niResponsable->getId(), $request->request->get('_token'))) {
            $niResponsableRepository->remove($niResponsable, true);
        }

        return $this->redirectToRoute('app_ni_responsable_index', [], Response::HTTP_SEE_OTHER);
    }
}
