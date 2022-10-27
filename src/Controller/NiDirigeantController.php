<?php

namespace App\Controller;

use App\Entity\NiDirigeant;
use App\Form\NiDirigeant1Type;
use App\Repository\NiDirigeantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/ni/dirigeant")
 * @IsGranted("ROLE_USER")
 */
class NiDirigeantController extends AbstractController
{
    /**
     * @Route("/", name="app_ni_dirigeant_index", methods={"GET"})
     */
    public function index(NiDirigeantRepository $niDirigeantRepository): Response
    {
        return $this->render('ni_dirigeant/index.html.twig', [
            'ni_dirigeants' => $niDirigeantRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_ni_dirigeant_new", methods={"GET", "POST"})
     */
    public function new(Request $request, NiDirigeantRepository $niDirigeantRepository): Response
    {
        $niDirigeant = new NiDirigeant();
        $form = $this->createForm(NiDirigeant1Type::class, $niDirigeant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $niDirigeantRepository->add($niDirigeant);
            return $this->redirectToRoute('app_ni_dirigeant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ni_dirigeant/new.html.twig', [
            'ni_dirigeant' => $niDirigeant,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ni_dirigeant_show", methods={"GET"})
     */
    public function show(NiDirigeant $niDirigeant): Response
    {
        return $this->render('ni_dirigeant/show.html.twig', [
            'ni_dirigeant' => $niDirigeant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_ni_dirigeant_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, NiDirigeant $niDirigeant, NiDirigeantRepository $niDirigeantRepository): Response
    {
        $form = $this->createForm(NiDirigeant1Type::class, $niDirigeant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $niDirigeantRepository->add($niDirigeant);
            return $this->redirectToRoute('app_ni_dirigeant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ni_dirigeant/edit.html.twig', [
            'ni_dirigeant' => $niDirigeant,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ni_dirigeant_delete", methods={"POST"})
     */
    public function delete(Request $request, NiDirigeant $niDirigeant, NiDirigeantRepository $niDirigeantRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$niDirigeant->getId(), $request->request->get('_token'))) {
            $niDirigeantRepository->remove($niDirigeant);
        }

        return $this->redirectToRoute('app_ni_dirigeant_index', [], Response::HTTP_SEE_OTHER);
    }
}
