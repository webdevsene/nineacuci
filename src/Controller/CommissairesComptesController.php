<?php

namespace App\Controller;

use App\Entity\CommissairesComptes;
use App\Form\CommissairesComptesType;
use App\Repository\CommissairesComptesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commissaires/comptes")
 */
class CommissairesComptesController extends AbstractController
{
    /**
     * @Route("/", name="commissaires_comptes_index", methods={"GET"})
     */
    public function index(CommissairesComptesRepository $commissairesComptesRepository): Response
    {
        return $this->render('commissaires_comptes/index.html.twig', [
            'commissaires_comptes' => $commissairesComptesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="commissaires_comptes_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commissairesCompte = new CommissairesComptes();
        $form = $this->createForm(CommissairesComptesType::class, $commissairesCompte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commissairesCompte);
            $entityManager->flush();

            return $this->redirectToRoute('commissaires_comptes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commissaires_comptes/new.html.twig', [
            'commissaires_compte' => $commissairesCompte,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="commissaires_comptes_show", methods={"GET"})
     */
    public function show(CommissairesComptes $commissairesCompte): Response
    {
        return $this->render('commissaires_comptes/show.html.twig', [
            'commissaires_compte' => $commissairesCompte,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="commissaires_comptes_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CommissairesComptes $commissairesCompte, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommissairesComptesType::class, $commissairesCompte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('commissaires_comptes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commissaires_comptes/edit.html.twig', [
            'commissaires_compte' => $commissairesCompte,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="commissaires_comptes_delete", methods={"POST"})
     */
    public function delete(Request $request, CommissairesComptes $commissairesCompte, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commissairesCompte->getId(), $request->request->get('_token'))) {
            $entityManager->remove($commissairesCompte);
            $entityManager->flush();
        }

        return $this->redirectToRoute('commissaires_comptes_index', [], Response::HTTP_SEE_OTHER);
    }
}
