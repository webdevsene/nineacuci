<?php

namespace App\Controller;

use App\Entity\Actionnaire;
use App\Form\ActionnaireType;
use App\Repository\ActionnaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/actionnaire")
 */
class ActionnaireController extends AbstractController
{
    /**
     * @Route("/", name="actionnaire_index", methods={"GET"})
     */
    public function index(ActionnaireRepository $actionnaireRepository): Response
    {
        return $this->render('actionnaire/index.html.twig', [
            'actionnaires' => $actionnaireRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="actionnaire_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $actionnaire = new Actionnaire();
        $form = $this->createForm(ActionnaireType::class, $actionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($actionnaire);
            $entityManager->flush();

            return $this->redirectToRoute('actionnaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('actionnaire/new.html.twig', [
            'actionnaire' => $actionnaire,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="actionnaire_show", methods={"GET"})
     */
    public function show(Actionnaire $actionnaire): Response
    {
        return $this->render('actionnaire/show.html.twig', [
            'actionnaire' => $actionnaire,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="actionnaire_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Actionnaire $actionnaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ActionnaireType::class, $actionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('actionnaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('actionnaire/edit.html.twig', [
            'actionnaire' => $actionnaire,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="actionnaire_delete", methods={"POST"})
     */
    public function delete(Request $request, Actionnaire $actionnaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actionnaire->getId(), $request->request->get('_token'))) {
            $entityManager->remove($actionnaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('actionnaire_index', [], Response::HTTP_SEE_OTHER);
    }
}
