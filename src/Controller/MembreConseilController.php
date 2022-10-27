<?php

namespace App\Controller;

use App\Entity\MembreConseil;
use App\Form\MembreConseilType;
use App\Repository\MembreConseilRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/membre/conseil")
 * @IsGranted("ROLE_USER")
 */
class MembreConseilController extends AbstractController
{
    /**
     * @Route("/", name="membre_conseil_index", methods={"GET"})
     */
    public function index(MembreConseilRepository $membreConseilRepository): Response
    {
        return $this->render('membre_conseil/index.html.twig', [
            'membre_conseils' => $membreConseilRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="membre_conseil_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $membreConseil = new MembreConseil();
        $form = $this->createForm(MembreConseilType::class, $membreConseil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($membreConseil);
            $entityManager->flush();

            return $this->redirectToRoute('membre_conseil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('membre_conseil/new.html.twig', [
            'membre_conseil' => $membreConseil,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="membre_conseil_show", methods={"GET"})
     */
    public function show(MembreConseil $membreConseil): Response
    {
        return $this->render('membre_conseil/show.html.twig', [
            'membre_conseil' => $membreConseil,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="membre_conseil_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, MembreConseil $membreConseil, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MembreConseilType::class, $membreConseil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('membre_conseil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('membre_conseil/edit.html.twig', [
            'membre_conseil' => $membreConseil,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="membre_conseil_delete", methods={"POST"})
     */
    public function delete(Request $request, MembreConseil $membreConseil, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$membreConseil->getId(), $request->request->get('_token'))) {
            $entityManager->remove($membreConseil);
            $entityManager->flush();
        }

        return $this->redirectToRoute('membre_conseil_index', [], Response::HTTP_SEE_OTHER);
    }
}
