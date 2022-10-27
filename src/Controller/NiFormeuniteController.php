<?php

namespace App\Controller;

use App\Entity\NiFormeunite;
use App\Form\NiFormeuniteType;
use App\Repository\NiFormeuniteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/ni/formeunite")
 * @IsGranted("ROLE_USER")
 */
class NiFormeuniteController extends AbstractController
{
    /**
     * @Route("/", name="app_ni_formeunite_index", methods={"GET"})
     */
    public function index(NiFormeuniteRepository $niFormeuniteRepository): Response
    {
        return $this->render('ni_formeunite/index.html.twig', [
            'ni_formeunites' => $niFormeuniteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_ni_formeunite_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $niFormeunite = new NiFormeunite();
        $form = $this->createForm(NiFormeuniteType::class, $niFormeunite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($niFormeunite);
            $entityManager->flush();

            return $this->redirectToRoute('app_ni_formeunite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ni_formeunite/new.html.twig', [
            'ni_formeunite' => $niFormeunite,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ni_formeunite_show", methods={"GET"})
     */
    public function show(NiFormeunite $niFormeunite): Response
    {
        return $this->render('ni_formeunite/show.html.twig', [
            'ni_formeunite' => $niFormeunite,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_ni_formeunite_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, NiFormeunite $niFormeunite, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NiFormeuniteType::class, $niFormeunite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ni_formeunite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ni_formeunite/edit.html.twig', [
            'ni_formeunite' => $niFormeunite,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ni_formeunite_delete", methods={"POST"})
     */
    public function delete(Request $request, NiFormeunite $niFormeunite, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$niFormeunite->getId(), $request->request->get('_token'))) {
            $entityManager->remove($niFormeunite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ni_formeunite_index', [], Response::HTTP_SEE_OTHER);
    }
}
