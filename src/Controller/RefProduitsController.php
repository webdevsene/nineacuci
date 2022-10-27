<?php

namespace App\Controller;

use App\Entity\RefProduits;
use App\Form\RefProduitsType;
use App\Repository\RefProduitsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ref/produits")
 */
class RefProduitsController extends AbstractController
{
    /**
     * @Route("/", name="app_ref_produits_index", methods={"GET"})
     */
    public function index(RefProduitsRepository $refProduitsRepository): Response
    {
        return $this->render('ref_produits/index.html.twig', [
            'ref_produits' => $refProduitsRepository->findBy(array(), null , 107, null),
        ]);
    }

    /**
     * @Route("/new", name="app_ref_produits_new", methods={"GET", "POST"})
     */
    public function new(Request $request, RefProduitsRepository $refProduitsRepository, EntityManagerInterface $entityManager): Response
    {
        $refProduit = new RefProduits();
        $form = $this->createForm(RefProduitsType::class, $refProduit);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
           // $refProduitsRepository->add($refProduit, true);
           $entityManager->persist($refProduit);
           $entityManager->flush();

            return $this->redirectToRoute('app_ref_produits_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ref_produits/new.html.twig', [
            'ref_produit' => $refProduit,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ref_produits_show", methods={"GET"})
     */
    public function show(RefProduits $refProduit): Response
    {
        return $this->render('ref_produits/show.html.twig', [
            'ref_produit' => $refProduit,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_ref_produits_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, RefProduits $refProduit, RefProduitsRepository $refProduitsRepository): Response
    {
        $form = $this->createForm(RefProduitsType::class, $refProduit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $refProduitsRepository->add($refProduit, true);

            return $this->redirectToRoute('app_ref_produits_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ref_produits/edit.html.twig', [
            'ref_produit' => $refProduit,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ref_produits_delete", methods={"POST"})
     */
    public function delete(Request $request, RefProduits $refProduit, RefProduitsRepository $refProduitsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$refProduit->getId(), $request->request->get('_token'))) {
            $refProduitsRepository->remove($refProduit, true);
        }

        return $this->redirectToRoute('app_ref_produits_index', [], Response::HTTP_SEE_OTHER);
    }
}
