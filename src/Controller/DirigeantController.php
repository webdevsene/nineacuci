<?php

namespace App\Controller;

use App\Entity\Dirigeant;
use App\Form\DirigeantType;
use App\Repository\DirigeantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dirigeant")
 */
class DirigeantController extends AbstractController
{
    /**
     * @Route("/", name="dirigeant_index", methods={"GET"})
     */
    public function index(DirigeantRepository $dirigeantRepository): Response
    {
        return $this->render('dirigeant/index.html.twig', [
            'dirigeants' => $dirigeantRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="dirigeant_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $dirigeant = new Dirigeant();
        $form = $this->createForm(DirigeantType::class, $dirigeant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($dirigeant);
            $entityManager->flush();

            return $this->redirectToRoute('dirigeant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dirigeant/new.html.twig', [
            'dirigeant' => $dirigeant,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="dirigeant_show", methods={"GET"})
     */
    public function show(Dirigeant $dirigeant): Response
    {
        return $this->render('dirigeant/show.html.twig', [
            'dirigeant' => $dirigeant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="dirigeant_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Dirigeant $dirigeant, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DirigeantType::class, $dirigeant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('dirigeant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dirigeant/edit.html.twig', [
            'dirigeant' => $dirigeant,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="dirigeant_delete", methods={"POST"})
     */
    public function delete(Request $request, Dirigeant $dirigeant, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dirigeant->getId(), $request->request->get('_token'))) {
            $entityManager->remove($dirigeant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dirigeant_index', [], Response::HTTP_SEE_OTHER);
    }
}
