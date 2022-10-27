<?php

namespace App\Controller;

use App\Entity\JournalTresorerie;
use App\Entity\JournalTresorerieSmtUtil;
use App\Entity\Repertoire;
use App\Form\JournalTresorerieSmtUtilType;
use App\Form\JournalTresorerieType;
use App\Repository\JournalTresorerieRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/journal/tresorerie")
 */
class JournalTresorerieController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack )
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @Route("/", name="app_journal_tresorerie_index", methods={"GET"})
     */
    public function index(JournalTresorerieRepository $journalTresorerieRepository): Response
    {
        return $this->render('journal_tresorerie/index.html.twig', [
            'journal_tresoreries' => $journalTresorerieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_journal_tresorerie_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $session = $this->requestStack->getSession();

        $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$session->get('codeCuci')]); 

        $obj_journaltr = $this->getDoctrine()
                                    ->getRepository(JournalTresorerie::class)
                                    ->findOneBy(["repertoire"=>$repertoire, "anneeFinanciere"=>$session->get('annee')]);
        
        
        $form= null; $isSubmited_obj = null ;


        if($request->get('submited')){
            $isSubmited_obj=1;
           
        }
        if(!$request->get('notsubmited')){
            $isSubmited_obj=0; 
        }


        
        if ($obj_journaltr) {
            $obj_journaltr_util = $obj_journaltr->getJournalTresorerieSmtUtil();

            $form = $this->createForm(JournalTresorerieSmtUtilType::class, $obj_journaltr_util); 
            $form->handleRequest($request);
        
            if ($form->isSubmitted() && $form->isValid()) {
                $obj_journaltr->setUpdatedAt(new DateTime('now'))
                              # ->setUpdatedBy($this->getUser())
                ;

                $em->flush();
                
                return $this->redirectToRoute('app_journal_creances_impayees_smt_new', [], Response::HTTP_SEE_OTHER);
                
            }

        } else {
            $obj_journaltr_util = new JournalTresorerieSmtUtil();
            $form = $this->createForm(JournalTresorerieSmtUtilType::class, $obj_journaltr_util); 
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$session->get('codeCuci')]);

                foreach ($obj_journaltr_util->getJournalTresoreries() as $key => $obj) {
                    $obj->setRepertoire($repertoire)
                        ->setCreatedBy($this->getUser())
                        ->setUpdatedBy($this->getUser())
                        ->setSubmit($isSubmited_obj)
                        ->setStatus('valide')
                        ->setAnneeFinanciere($session->get('annee'));
                }

                $em->persist($obj_journaltr_util);
                $em->flush();
    
                return $this->redirectToRoute('app_journal_creances_impayees_smt_new', [], Response::HTTP_SEE_OTHER);
    

            }
            
        }

        return $this->renderForm('journal_tresorerie/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_journal_tresorerie_show", methods={"GET"})
     */
    public function show(JournalTresorerie $journalTresorerie): Response
    {
        return $this->render('journal_tresorerie/show.html.twig', [
            'journal_tresorerie' => $journalTresorerie,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_journal_tresorerie_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, JournalTresorerie $journalTresorerie, JournalTresorerieRepository $journalTresorerieRepository): Response
    {
        $form = $this->createForm(JournalTresorerieType::class, $journalTresorerie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $journalTresorerieRepository->add($journalTresorerie, true);

            return $this->redirectToRoute('app_journal_tresorerie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('journal_tresorerie/edit.html.twig', [
            'journal_tresorerie' => $journalTresorerie,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_journal_tresorerie_delete", methods={"POST"})
     */
    public function delete(Request $request, JournalTresorerie $journalTresorerie, JournalTresorerieRepository $journalTresorerieRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$journalTresorerie->getId(), $request->request->get('_token'))) {
            $journalTresorerieRepository->remove($journalTresorerie, true);
        }

        return $this->redirectToRoute('app_journal_tresorerie_index', [], Response::HTTP_SEE_OTHER);
    }
}
