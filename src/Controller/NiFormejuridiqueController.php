<?php

namespace App\Controller;

use App\Entity\NiFormejuridique;
use App\Form\NiFormejuridiqueType;
use App\Repository\NiFormejuridiqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/ni/formejuridique")
 * @IsGranted("ROLE_USER")
 */
class NiFormejuridiqueController extends AbstractController
{
    /**
     * @Route("/", name="app_ni_formejuridique_index", methods={"GET"})
     */
    public function index(NiFormejuridiqueRepository $niFormejuridiqueRepository): Response
    {
        return $this->render('ni_formejuridique/index.html.twig', [
            'ni_formejuridiques' => $niFormejuridiqueRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_ni_formejuridique_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $niFormejuridique = new NiFormejuridique();
        $form = $this->createForm(NiFormejuridiqueType::class, $niFormejuridique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($niFormejuridique);
            $entityManager->flush();

            return $this->redirectToRoute('app_ni_formejuridique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ni_formejuridique/new.html.twig', [
            'ni_formejuridique' => $niFormejuridique,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ni_formejuridique_show", methods={"GET"})
     */
    public function show(NiFormejuridique $niFormejuridique): Response
    {
        return $this->render('ni_formejuridique/show.html.twig', [
            'ni_formejuridique' => $niFormejuridique,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_ni_formejuridique_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, NiFormejuridique $niFormejuridique, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NiFormejuridiqueType::class, $niFormejuridique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ni_formejuridique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ni_formejuridique/edit.html.twig', [
            'ni_formejuridique' => $niFormejuridique,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ni_formejuridique_delete", methods={"POST"})
     */
    public function delete(Request $request, NiFormejuridique $niFormejuridique, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$niFormejuridique->getId(), $request->request->get('_token'))) {
            $entityManager->remove($niFormejuridique);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ni_formejuridique_index', [], Response::HTTP_SEE_OTHER);
    }
}
