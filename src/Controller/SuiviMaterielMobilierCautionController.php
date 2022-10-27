<?php

namespace App\Controller;

use App\Entity\SuiviMaterielMobilierCaution;
use App\Form\SuiviMaterielMobilierCautionType;
use App\Repository\SuiviMaterielMobilierCautionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/suivi")
 * @IsGranted("ROLE_USER")
 */
class SuiviMaterielMobilierCautionController extends AbstractController
{
    /**
     * @Route("/", name="app_suivi_materiel_mobilier_caution_index", methods={"GET"})
     */
    public function index(SuiviMaterielMobilierCautionRepository $suiviMaterielMobilierCautionRepository): Response
    {
        return $this->render('suivi_materiel_mobilier_caution/index.html.twig', [
            'suivi_materiel_mobilier_cautions' => $suiviMaterielMobilierCautionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_suivi_materiel_mobilier_caution_new", methods={"GET", "POST"})
     */
    public function new(Request $request, SuiviMaterielMobilierCautionRepository $suiviMaterielMobilierCautionRepository): Response
    {
        $suiviMaterielMobilierCaution = new SuiviMaterielMobilierCaution();
        $form = $this->createForm(SuiviMaterielMobilierCautionType::class, $suiviMaterielMobilierCaution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $suiviMaterielMobilierCautionRepository->add($suiviMaterielMobilierCaution);
            return $this->redirectToRoute('app_suivi_materiel_mobilier_caution_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('suivi_materiel_mobilier_caution/new.html.twig', [
            'suivi_materiel_mobilier_caution' => $suiviMaterielMobilierCaution,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_suivi_materiel_mobilier_caution_show", methods={"GET"})
     */
    public function show(SuiviMaterielMobilierCaution $suiviMaterielMobilierCaution): Response
    {
        return $this->render('suivi_materiel_mobilier_caution/show.html.twig', [
            'suivi_materiel_mobilier_caution' => $suiviMaterielMobilierCaution,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_suivi_materiel_mobilier_caution_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, SuiviMaterielMobilierCaution $suiviMaterielMobilierCaution, SuiviMaterielMobilierCautionRepository $suiviMaterielMobilierCautionRepository): Response
    {
        $form = $this->createForm(SuiviMaterielMobilierCautionType::class, $suiviMaterielMobilierCaution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $suiviMaterielMobilierCautionRepository->add($suiviMaterielMobilierCaution);
            return $this->redirectToRoute('app_suivi_materiel_mobilier_caution_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('suivi_materiel_mobilier_caution/edit.html.twig', [
            'suivi_materiel_mobilier_caution' => $suiviMaterielMobilierCaution,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_suivi_materiel_mobilier_caution_delete", methods={"POST"})
     */
    public function delete(Request $request, SuiviMaterielMobilierCaution $suiviMaterielMobilierCaution, SuiviMaterielMobilierCautionRepository $suiviMaterielMobilierCautionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$suiviMaterielMobilierCaution->getId(), $request->request->get('_token'))) {
            $suiviMaterielMobilierCautionRepository->remove($suiviMaterielMobilierCaution);
        }

        return $this->redirectToRoute('app_suivi_materiel_mobilier_caution_index', [], Response::HTTP_SEE_OTHER);
    }
}
