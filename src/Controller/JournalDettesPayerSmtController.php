<?php

namespace App\Controller;

use App\Entity\JournalDettesPayerSmt;
use App\Entity\JournalDettesPayerSmtUtil;
use App\Entity\Repertoire;
use App\Form\JournalDettesPayerSmtType;
use App\Form\JournalDettesPayerSmtUtilType;
use App\Repository\JournalDettesPayerSmtRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dettes/payer")
 */
class JournalDettesPayerSmtController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack )
    {
        $this->requestStack = $requestStack;
    }
    
    /**
     * @Route("/", name="app_journal_dettes_payer_smt_index", methods={"GET"})
     */
    public function index(JournalDettesPayerSmtRepository $journalDettesPayerSmtRepository): Response
    {
        return $this->render('journal_dettes_payer_smt/index.html.twig', [
            'journal_dettes_payer_smts' => $journalDettesPayerSmtRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_journal_dettes_payer_smt_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $em): Response
    {


        $session = $this->requestStack->getSession();

        $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$session->get('codeCuci')]); 

        $obj_journal_dettes = $this->getDoctrine()
                                    ->getRepository(JournalDettesPayerSmt::class)
                                    ->findOneBy(["repertoire"=>$repertoire, "anneeFinanciere"=>$session->get('annee')]);
        
        
        $form= null; $isSubmited_obj = null ;


        if($request->get('submited')){
            $isSubmited_obj=1;
           
        }
        if(!$request->get('notsubmited')){
            $isSubmited_obj=0; 
        }

        
        if ($obj_journal_dettes) {
            $obj_journal_dettes_util = $obj_journal_dettes->getJournalDettesPayerSmtUtil();

            $form = $this->createForm(JournalDettesPayerSmtUtilType::class, $obj_journal_dettes_util); 
            $form->handleRequest($request);
        
            if ($form->isSubmitted() && $form->isValid()) {

                # $obj_journal_dettes->setUpdatedBy($this->getUser());
                $obj_journal_dettes->setUpdatedAt(new \DateTime('now'));

                $em->flush();
                return $this->redirectToRoute('app_bilan_smt_new', [], Response::HTTP_SEE_OTHER);
                
            }

        } else {
            $obj_journal_dettes_util = new JournalDettesPayerSmtUtil();
            $form = $this->createForm(JournalDettesPayerSmtUtilType::class, $obj_journal_dettes_util); 
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$session->get('codeCuci')]);

                foreach ($obj_journal_dettes_util->getJournalDettesPayerSmts() as $key => $obj) {
                    $obj->setRepertoire($repertoire)
                        ->setCreatedBy($this->getUser())
                        ->setUpdatedBy($this->getUser())
                        ->setSubmit($isSubmited_obj)
                        ->setStatus('valide')
                        ->setAnneeFinanciere($session->get('annee'));
                }

                $em->persist($obj_journal_dettes_util);
                $em->flush();
    
                return $this->redirectToRoute('app_bilan_smt_new', [], Response::HTTP_SEE_OTHER);
    

            }
            
        }

        return $this->renderForm('journal_dettes_payer_smt/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_journal_dettes_payer_smt_show", methods={"GET"})
     */
    public function show(JournalDettesPayerSmt $journalDettesPayerSmt): Response
    {
        return $this->render('journal_dettes_payer_smt/show.html.twig', [
            'journal_dettes_payer_smt' => $journalDettesPayerSmt,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_journal_dettes_payer_smt_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, JournalDettesPayerSmt $journalDettesPayerSmt, JournalDettesPayerSmtRepository $journalDettesPayerSmtRepository): Response
    {
        $form = $this->createForm(JournalDettesPayerSmtType::class, $journalDettesPayerSmt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $journalDettesPayerSmtRepository->add($journalDettesPayerSmt, true);

            return $this->redirectToRoute('app_journal_dettes_payer_smt_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('journal_dettes_payer_smt/edit.html.twig', [
            'journal_dettes_payer_smt' => $journalDettesPayerSmt,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_journal_dettes_payer_smt_delete", methods={"POST"})
     */
    public function delete(Request $request, JournalDettesPayerSmt $journalDettesPayerSmt, JournalDettesPayerSmtRepository $journalDettesPayerSmtRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$journalDettesPayerSmt->getId(), $request->request->get('_token'))) {
            $journalDettesPayerSmtRepository->remove($journalDettesPayerSmt, true);
        }

        return $this->redirectToRoute('app_journal_dettes_payer_smt_index', [], Response::HTTP_SEE_OTHER);
    }
}
