<?php

namespace App\Controller;

use App\Entity\SYSCOA;
use App\Entity\CategorySyscoa;
use App\Form\SYSCOAType;
use App\Repository\SYSCOARepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/syscoa")
 */
class SYSCOAController extends AbstractController
{
    /**
     * @Route("/", name="s_y_s_c_o_a_index", methods={"GET"})
     */
    public function index(SYSCOARepository $sYSCOARepository): Response
    {
        return $this->render('syscoa/index.html.twig', [
            's_y_s_c_o_as' => $sYSCOARepository->findAll(),
        ]);
    }

        /**
     * @Route("/syscoa/{id}", name="syscoa", methods={"GET"})
     */
    public function syscoa( $id="")
    {
         $tab=[];
         $categorysyscoa=$this->getDoctrine()->getRepository(CategorySyscoa::class)->find($id);
         foreach ($categorysyscoa->getSyscoa() as $key ) {

             array_push($tab,[$key->getId(),$key->getLibelle(),$key->getCODEACTIVITE()]);
         }        
        return new JsonResponse( $tab);
    }

    /**
     * @Route("/new", name="s_y_s_c_o_a_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sYSCOA = new SYSCOA();
        $form = $this->createForm(SYSCOAType::class, $sYSCOA);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sYSCOA);
            $entityManager->flush();

            return $this->redirectToRoute('s_y_s_c_o_a_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('syscoa/new.html.twig', [
            's_y_s_c_o_a' => $sYSCOA,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="s_y_s_c_o_a_show", methods={"GET"})
     */
    public function show(SYSCOA $sYSCOA): Response
    {
        return $this->render('syscoa/show.html.twig', [
            's_y_s_c_o_a' => $sYSCOA,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="s_y_s_c_o_a_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, SYSCOA $sYSCOA, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SYSCOAType::class, $sYSCOA);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('s_y_s_c_o_a_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('syscoa/edit.html.twig', [
            's_y_s_c_o_a' => $sYSCOA,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="s_y_s_c_o_a_delete", methods={"POST"})
     */
    public function delete(Request $request, SYSCOA $sYSCOA, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sYSCOA->getId(), $request->request->get('_token'))) {
            $entityManager->remove($sYSCOA);
            $entityManager->flush();
        }

        return $this->redirectToRoute('s_y_s_c_o_a_index', [], Response::HTTP_SEE_OTHER);
    }
}
