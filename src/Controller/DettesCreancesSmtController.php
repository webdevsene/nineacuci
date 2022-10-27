<?php

namespace App\Controller;

use App\Entity\DettesCreancesSmt;
use App\Entity\DettesCreancesSmtUtil;
use App\Entity\Repertoire;
use App\Form\DettesCreancesSmtType;
use App\Form\DettesCreancesSmtUtilType;
use App\Repository\DettesCreancesSmtRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dettes_creances")
 */
class DettesCreancesSmtController extends AbstractController
{
    private $requestStack ;

    public function __construct( RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @Route("/", name="app_dettes_creances_smt_index", methods={"GET"})
     */
    public function index(DettesCreancesSmtRepository $dettesCreancesSmtRepository): Response
    {
        return $this->render('dettes_creances_smt/index.html.twig', [
            'dettes_creances_smts' => $dettesCreancesSmtRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_dettes_creances_smt_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $em): Response
    {

        $_session = $this->requestStack->getSession();


        $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$_session->get('codeCuci')]); 

        $obj_dette_creance = $this->getDoctrine()->getRepository(DettesCreancesSmt::class)->findOneBy(["repertoire"=>$repertoire, "anneeFinanciere"=>$_session->get('annee')]);

        $form= null; $isSubmited_obj = null ;


        if($request->get('submited')){
            $isSubmited_obj=1;
           
        }
        if(!$request->get('notsubmited')){
            $isSubmited_obj=0; 
        }

        if ($obj_dette_creance) {
            $obj_dette_creance_util = $obj_dette_creance->getDettesCreancesSmtUtil();

            $form = $this->createForm(DettesCreancesSmtUtilType::class, $obj_dette_creance_util);
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) {

                $obj_dette_creance->setUpdatedAt(new DateTime('now'))
                                  # ->setUpdatedBy($this->getUser())
                ;
                
                
                $em->flush();

                return $this->redirectToRoute('app_journal_tresorerie_new', [], Response::HTTP_SEE_OTHER);
            }
            
        } else {
            $obj_dette_creance_util = new DettesCreancesSmtUtil();
            
            $form = $this->createForm(DettesCreancesSmtUtilType::class, $obj_dette_creance_util);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$_session->get('codeCuci')]); 

                foreach ($obj_dette_creance_util->getDettesCreancesSmts() as $key => $obj) {
                    $obj->setRepertoire($repertoire)
                        ->setCreatedBy($this->getUser())
                        ->setUpdatedBy($this->getUser())
                        ->setSubmit($isSubmited_obj)
                        ->setStatus('valide')
                        ->setAnneeFinanciere($_session->get('annee'));
                }


                $em->persist($obj_dette_creance_util);
                $em->flush();
    
                return $this->redirectToRoute('app_journal_tresorerie_new', [], Response::HTTP_SEE_OTHER);
            }


        }

        return $this->renderForm('dettes_creances_smt/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_dettes_creances_smt_show", methods={"GET"})
     */
    public function show(DettesCreancesSmt $dettesCreancesSmt): Response
    {
        return $this->render('dettes_creances_smt/show.html.twig', [
            'dettes_creances_smt' => $dettesCreancesSmt,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_dettes_creances_smt_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, DettesCreancesSmt $dettesCreancesSmt, DettesCreancesSmtRepository $dettesCreancesSmtRepository): Response
    {
        $form = $this->createForm(DettesCreancesSmtType::class, $dettesCreancesSmt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dettesCreancesSmtRepository->add($dettesCreancesSmt);
            return $this->redirectToRoute('app_dettes_creances_smt_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dettes_creances_smt/edit.html.twig', [
            'dettes_creances_smt' => $dettesCreancesSmt,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_dettes_creances_smt_delete", methods={"POST"})
     */
    public function delete(Request $request, DettesCreancesSmt $dettesCreancesSmt, DettesCreancesSmtRepository $dettesCreancesSmtRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dettesCreancesSmt->getId(), $request->request->get('_token'))) {
            $dettesCreancesSmtRepository->remove($dettesCreancesSmt);
        }

        return $this->redirectToRoute('app_dettes_creances_smt_index', [], Response::HTTP_SEE_OTHER);
    }
}
