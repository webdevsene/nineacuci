<?php

namespace App\Controller;

use App\Entity\NinTypedocuments;
use App\Form\NinTypedocumentsType;
use App\Repository\NinTypedocumentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/nin/typedocuments")
 */
class NinTypedocumentsController extends AbstractController
{
    /**
     * @Route("/", name="app_nin_typedocuments_index", methods={"GET"})
     */
    public function index(NinTypedocumentsRepository $ninTypedocumentsRepository): Response
    {
        return $this->render('nin_typedocuments/index.html.twig', [
            'nin_typedocuments' => $ninTypedocumentsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_nin_typedocuments_new", methods={"GET", "POST"})
     */
    public function new(Request $request, NinTypedocumentsRepository $ninTypedocumentsRepository): Response
    {
        $ninTypedocument = new NinTypedocuments();
        $form = $this->createForm(NinTypedocumentsType::class, $ninTypedocument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ninTypedocumentsRepository->add($ninTypedocument, true);

            return $this->redirectToRoute('app_nin_typedocuments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('nin_typedocuments/new.html.twig', [
            'nin_typedocument' => $ninTypedocument,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_nin_typedocuments_show", methods={"GET"})
     */
    public function show(NinTypedocuments $ninTypedocument): Response
    {
        return $this->render('nin_typedocuments/show.html.twig', [
            'nin_typedocument' => $ninTypedocument,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_nin_typedocuments_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, NinTypedocuments $ninTypedocument, NinTypedocumentsRepository $ninTypedocumentsRepository): Response
    {
        $form = $this->createForm(NinTypedocumentsType::class, $ninTypedocument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ninTypedocumentsRepository->add($ninTypedocument, true);

            return $this->redirectToRoute('app_nin_typedocuments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('nin_typedocuments/edit.html.twig', [
            'nin_typedocument' => $ninTypedocument,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_nin_typedocuments_delete", methods={"POST"})
     */
    public function delete(Request $request, NinTypedocuments $ninTypedocument, NinTypedocumentsRepository $ninTypedocumentsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ninTypedocument->getId(), $request->request->get('_token'))) {
            $ninTypedocumentsRepository->remove($ninTypedocument, true);
        }

        return $this->redirectToRoute('app_nin_typedocuments_index', [], Response::HTTP_SEE_OTHER);
    }
}
