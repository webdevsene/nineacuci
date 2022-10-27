<?php

namespace App\Controller;

use App\Entity\NiAdministration;
use App\Form\NiAdministrationType;
use App\Repository\NiAdministrationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ni/administration")
 */
class NiAdministrationController extends AbstractController
{
    /**
     * @Route("/", name="app_ni_administration_index", methods={"GET"})
     */
    public function index(NiAdministrationRepository $niAdministrationRepository): Response
    {
        return $this->render('ni_administration/index.html.twig', [
            'ni_administrations' => $niAdministrationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_ni_administration_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $niAdministration = new NiAdministration();
        $form = $this->createForm(NiAdministrationType::class, $niAdministration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($niAdministration);
            $entityManager->flush();

            return $this->redirectToRoute('app_ni_administration_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ni_administration/new.html.twig', [
            'ni_administration' => $niAdministration,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ni_administration_show", methods={"GET"})
     */
    public function show(NiAdministration $niAdministration): Response
    {
        return $this->render('ni_administration/show.html.twig', [
            'ni_administration' => $niAdministration,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_ni_administration_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, NiAdministration $niAdministration, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NiAdministrationType::class, $niAdministration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ni_administration_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ni_administration/edit.html.twig', [
            'ni_administration' => $niAdministration,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ni_administration_delete", methods={"POST"})
     */
    public function delete(Request $request, NiAdministration $niAdministration, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$niAdministration->getId(), $request->request->get('_token'))) {
            $entityManager->remove($niAdministration);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ni_administration_index', [], Response::HTTP_SEE_OTHER);
    }
}
