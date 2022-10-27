<?php

namespace App\Controller;

use App\Entity\EtatDesStocksSmt;
use App\Entity\EtatDesStocksSmtUtil;
use App\Entity\Repertoire;
use App\Form\EtatDesStocksSmtType;
use App\Form\EtatDesStocksSmtUtilType;
use App\Repository\EtatDesStocksSmtRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/etat_des_stocks")
 */
class EtatDesStocksSmtController extends AbstractController
{

    private $requestStack;

    public function __construct(RequestStack $requestStack )
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @Route("/", name="app_etat_des_stocks_smt_index", methods={"GET"})
     */
    public function index(EtatDesStocksSmtRepository $etatDesStocksSmtRepository): Response
    {
        return $this->render('etat_des_stocks_smt/index.html.twig', [
            'etat_des_stocks_smts' => $etatDesStocksSmtRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_etat_des_stocks_smt_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $em): Response
    {

        $session = $this->requestStack->getSession();

        $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$session->get('codeCuci')]); 

        $obj_etat_des_stocks = $this->getDoctrine()
                                    ->getRepository(EtatDesStocksSmt::class)
                                    ->findOneBy(["repertoire"=>$repertoire, "anneeFinanciere"=>$session->get('annee')]);

        
        $form= null; $isSubmited_obj = null ;


        if($request->get('submited')){
            $isSubmited_obj=1;
           
        }
        if(!$request->get('notsubmited')){
            $isSubmited_obj=0; 
        }

        if ($obj_etat_des_stocks) {
            $obj_etat_stock_util = $obj_etat_des_stocks->getEtatDesStocksSmtUtil();

            $form = $this->createForm(EtatDesStocksSmtUtilType::class, $obj_etat_stock_util); 
            $form->handleRequest($request);
        
            if ($form->isSubmitted() && $form->isValid()) {

                $obj_etat_des_stocks->setUpdatedAt(new DateTime('now'))
                                    ->setValStockFin($request->get('val-stock-fin'))
                                    ->setValStockInit($request->get('val-stock-init'))
                                    # ->setUpdatedBy($this->getUser())
                ;              

                                  
                $em->flush();
                return $this->redirectToRoute('app_dettes_creances_smt_new', [], Response::HTTP_SEE_OTHER);
            }

        } else {
            $obj_etat_stock_util = new EtatDesStocksSmtUtil();
            $form = $this->createForm(EtatDesStocksSmtUtilType::class, $obj_etat_stock_util); 
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$session->get('codeCuci')]);

                foreach ($obj_etat_stock_util->getEtatDesStocksSmts() as $key => $obj) {
                    $obj->setRepertoire($repertoire)
                        ->setCreatedBy($this->getUser())
                        ->setUpdatedBy($this->getUser())
                        ->setSubmit($isSubmited_obj)
                        ->setStatus('valide')
                        ->setAnneeFinanciere($session->get('annee'))
                        ->setValStockFin($request->get('val-stock-fin'))
                        ->setValStockInit($request->get('val-stock-init'))
                    ;
                }

                $em->persist($obj_etat_stock_util);
                $em->flush();
    
                return $this->redirectToRoute('app_dettes_creances_smt_new', [], Response::HTTP_SEE_OTHER);
    

            }
            
        }
        



        return $this->renderForm('etat_des_stocks_smt/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_etat_des_stocks_smt_show", methods={"GET"})
     */
    public function show(EtatDesStocksSmt $etatDesStocksSmt): Response
    {
        return $this->render('etat_des_stocks_smt/show.html.twig', [
            'etat_des_stocks_smt' => $etatDesStocksSmt,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_etat_des_stocks_smt_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, EtatDesStocksSmt $etatDesStocksSmt, EtatDesStocksSmtRepository $etatDesStocksSmtRepository): Response
    {
        $form = $this->createForm(EtatDesStocksSmtType::class, $etatDesStocksSmt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $etatDesStocksSmtRepository->add($etatDesStocksSmt);
            return $this->redirectToRoute('app_etat_des_stocks_smt_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('etat_des_stocks_smt/edit.html.twig', [
            'etat_des_stocks_smt' => $etatDesStocksSmt,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_etat_des_stocks_smt_delete", methods={"POST"})
     */
    public function delete(Request $request, EtatDesStocksSmt $etatDesStocksSmt, EtatDesStocksSmtRepository $etatDesStocksSmtRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etatDesStocksSmt->getId(), $request->request->get('_token'))) {
            $etatDesStocksSmtRepository->remove($etatDesStocksSmt);
        }

        return $this->redirectToRoute('app_etat_des_stocks_smt_index', [], Response::HTTP_SEE_OTHER);
    }
}
