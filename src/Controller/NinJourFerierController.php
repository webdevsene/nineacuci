<?php

namespace App\Controller;

use App\Entity\NinJourFerier;
use App\Form\NinJourFerierType;
use App\Repository\NinJourFerierRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/nin/jour/ferier")
 */
class NinJourFerierController extends AbstractController
{
    /**
     * @Route("/", name="app_nin_jour_ferier_index", methods={"GET"})
     */
    public function index(NinJourFerierRepository $ninJourFerierRepository): Response
    {
        return $this->render('nin_jour_ferier/index.html.twig', [
            'nin_jour_feriers' => $ninJourFerierRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_nin_jour_ferier_new", methods={"GET", "POST"})
     */
    public function new(Request $request, NinJourFerierRepository $ninJourFerierRepository): Response
    {
        $ninJourFerier = new NinJourFerier();
        $form = $this->createForm(NinJourFerierType::class, $ninJourFerier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->getUser();

            $ninJourFerier->setCreatedBy($user);
            $ninJourFerier->setUpdatedBy($user);
            $ninJourFerierRepository->add($ninJourFerier, true);

            return $this->redirectToRoute('app_nin_jour_ferier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('nin_jour_ferier/new.html.twig', [
            'nin_jour_ferier' => $ninJourFerier,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_nin_jour_ferier_show", methods={"GET"})
     */
    public function show(NinJourFerier $ninJourFerier): Response
    {
        return $this->render('nin_jour_ferier/show.html.twig', [
            'nin_jour_ferier' => $ninJourFerier,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_nin_jour_ferier_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, NinJourFerier $ninJourFerier, NinJourFerierRepository $ninJourFerierRepository): Response
    {
        $form = $this->createForm(NinJourFerierType::class, $ninJourFerier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ninJourFerierRepository->add($ninJourFerier, true);

            return $this->redirectToRoute('app_nin_jour_ferier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('nin_jour_ferier/edit.html.twig', [
            'nin_jour_ferier' => $ninJourFerier,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_nin_jour_ferier_delete", methods={"POST"})
     */
    public function delete(Request $request, NinJourFerier $ninJourFerier, NinJourFerierRepository $ninJourFerierRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ninJourFerier->getId(), $request->request->get('_token'))) {
            $ninJourFerierRepository->remove($ninJourFerier, true);
        }

        return $this->redirectToRoute('app_nin_jour_ferier_index', [], Response::HTTP_SEE_OTHER);
    }
}
