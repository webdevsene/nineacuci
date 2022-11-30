<?php

namespace App\Controller;

use App\Entity\NiSourcefinancement;
use App\Form\NiSourcefinancementType;
use App\Repository\NiSourcefinancementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/ni/sourcefinancement")
 * @Security(" is_granted('ROLE_USER')")

 */
class NiSourcefinancementController extends AbstractController
{
    /**
     * @Route("/", name="app_ni_sourcefinancement_index", methods={"GET"})
     */
    public function index(NiSourcefinancementRepository $niSourcefinancementRepository): Response
    {
        return $this->render('ni_sourcefinancement/index.html.twig', [
            'ni_sourcefinancements' => $niSourcefinancementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_ni_sourcefinancement_new", methods={"GET", "POST"})
     */
    public function new(Request $request, NiSourcefinancementRepository $niSourcefinancementRepository): Response
    {
        $niSourcefinancement = new NiSourcefinancement();
        $form = $this->createForm(NiSourcefinancementType::class, $niSourcefinancement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $niSourcefinancementRepository->add($niSourcefinancement, true);

            return $this->redirectToRoute('app_ni_sourcefinancement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ni_sourcefinancement/new.html.twig', [
            'ni_sourcefinancement' => $niSourcefinancement,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ni_sourcefinancement_show", methods={"GET"})
     */
    public function show(NiSourcefinancement $niSourcefinancement): Response
    {
        return $this->render('ni_sourcefinancement/show.html.twig', [
            'ni_sourcefinancement' => $niSourcefinancement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_ni_sourcefinancement_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, NiSourcefinancement $niSourcefinancement, NiSourcefinancementRepository $niSourcefinancementRepository): Response
    {
        $form = $this->createForm(NiSourcefinancementType::class, $niSourcefinancement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $niSourcefinancementRepository->add($niSourcefinancement, true);

            return $this->redirectToRoute('app_ni_sourcefinancement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ni_sourcefinancement/edit.html.twig', [
            'ni_sourcefinancement' => $niSourcefinancement,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ni_sourcefinancement_delete", methods={"POST"})
     */
    public function delete(Request $request, NiSourcefinancement $niSourcefinancement, NiSourcefinancementRepository $niSourcefinancementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$niSourcefinancement->getId(), $request->request->get('_token'))) {
            $niSourcefinancementRepository->remove($niSourcefinancement, true);
        }

        return $this->redirectToRoute('app_ni_sourcefinancement_index', [], Response::HTTP_SEE_OTHER);
    }
}
