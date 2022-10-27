<?php

namespace App\Controller;

use App\Entity\JournalCreancesImpayeesSmt;
use App\Entity\JournalCreancesImpayeesSmtUtil;
use App\Entity\Repertoire;
use App\Form\JournalCreancesImpayeesSmtType;
use App\Form\JournalCreancesImpayeesSmtUtilType;
use App\Repository\JournalCreancesImpayeesSmtRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/creances/impayees")
 */
class JournalCreancesImpayeesSmtController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack )
    {
        $this->requestStack = $requestStack;
    }



    /**
     * @Route("/", name="app_journal_creances_impayees_smt_index", methods={"GET"})
     */
    public function index(JournalCreancesImpayeesSmtRepository $journalCreancesImpayeesSmtRepository): Response
    {
        return $this->render('journal_creances_impayees_smt/index.html.twig', [
            'journal_creances_impayees_smts' => $journalCreancesImpayeesSmtRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_journal_creances_impayees_smt_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $em): Response
    {

        $session = $this->requestStack->getSession();

        $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$session->get('codeCuci')]); 

        $obj_journalcr = $this->getDoctrine()
                                    ->getRepository(JournalCreancesImpayeesSmt::class)
                                    ->findOneBy(["repertoire"=>$repertoire, "anneeFinanciere"=>$session->get('annee')]);
        
        
        $form= null; $isSubmited_obj = null ;


        if($request->get('submited')){
            $isSubmited_obj=1;
           
        }
        if(!$request->get('notsubmited')){
            $isSubmited_obj=0; 
        }

        
        if ($obj_journalcr) {
            $obj_journalcr_util = $obj_journalcr->getJournalCreancesImpayeesSmtUtil();

            $form = $this->createForm(JournalCreancesImpayeesSmtUtilType::class, $obj_journalcr_util); 
            $form->handleRequest($request);
        
            if ($form->isSubmitted() && $form->isValid()) {

                $obj_journalcr->setUpdatedAt(new DateTime('now'))
                            # ->setUpdatedBy($this->getUser())
                ;

                $em->flush();
                return $this->redirectToRoute('app_journal_dettes_payer_smt_new', [], Response::HTTP_SEE_OTHER);

                
            }

        } else {
            $obj_journalcr_util = new JournalCreancesImpayeesSmtUtil();
            $form = $this->createForm(JournalCreancesImpayeesSmtUtilType::class, $obj_journalcr_util); 
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$session->get('codeCuci')]);

                foreach ($obj_journalcr_util->getJournalCreancesImpayeesSmts() as $key => $obj) {
                    $obj->setRepertoire($repertoire)
                        ->setCreatedBy($this->getUser())
                        ->setUpdatedBy($this->getUser())
                        ->setSubmit($isSubmited_obj)
                        ->setStatus('valide')
                        ->setAnneeFinanciere($session->get('annee'));
                }

                $em->persist($obj_journalcr_util);
                $em->flush();
    
                return $this->redirectToRoute('app_journal_dettes_payer_smt_new', [], Response::HTTP_SEE_OTHER);
    

            }
            
        }


        return $this->renderForm('journal_creances_impayees_smt/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_journal_creances_impayees_smt_show", methods={"GET"})
     */
    public function show(JournalCreancesImpayeesSmt $journalCreancesImpayeesSmt): Response
    {
        return $this->render('journal_creances_impayees_smt/show.html.twig', [
            'journal_creances_impayees_smt' => $journalCreancesImpayeesSmt,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_journal_creances_impayees_smt_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, JournalCreancesImpayeesSmt $journalCreancesImpayeesSmt, JournalCreancesImpayeesSmtRepository $journalCreancesImpayeesSmtRepository): Response
    {
        $form = $this->createForm(JournalCreancesImpayeesSmtType::class, $journalCreancesImpayeesSmt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $journalCreancesImpayeesSmtRepository->add($journalCreancesImpayeesSmt, true);

            return $this->redirectToRoute('app_journal_creances_impayees_smt_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('journal_creances_impayees_smt/edit.html.twig', [
            'journal_creances_impayees_smt' => $journalCreancesImpayeesSmt,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_journal_creances_impayees_smt_delete", methods={"POST"})
     */
    public function delete(Request $request, JournalCreancesImpayeesSmt $journalCreancesImpayeesSmt, JournalCreancesImpayeesSmtRepository $journalCreancesImpayeesSmtRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$journalCreancesImpayeesSmt->getId(), $request->request->get('_token'))) {
            $journalCreancesImpayeesSmtRepository->remove($journalCreancesImpayeesSmt, true);
        }

        return $this->redirectToRoute('app_journal_creances_impayees_smt_index', [], Response::HTTP_SEE_OTHER);
    }
}
