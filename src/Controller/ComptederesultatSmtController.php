<?php

namespace App\Controller;

use App\Entity\BilanSmt;
use App\Entity\ComptederesultatSmt;
use App\Entity\Repertoire;
use App\Entity\RefAggSmt;
use App\Form\ComptederesultatSmtType;
use App\Repository\ComptederesultatSmtRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @Route("/smt/cpresultat")
 * @IsGranted("ROLE_USER")
 */
class ComptederesultatSmtController extends AbstractController
{


    private $requestStack;
    
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }


    /**
     * @Route("/", name="app_comptederesultat_smt_index", methods={"GET"})
     */
    public function index(ComptederesultatSmtRepository $comptederesultatSmtRepository): Response
    {
        return $this->render('comptederesultat_smt/index.html.twig', [
            'comptederesultat_smts' => $comptederesultatSmtRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_comptederesultat_smt_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ComptederesultatSmtRepository $comptederesultatSmtRepository, EntityManagerInterface $entityManager): Response
    {
        $submit = null;
        $refAgg=$this->getDoctrine()->getRepository(RefAggSmt::class)->findBy(["category"=>10],  array('ordre' => 'ASC'));

        if($request->get('annee')){
          
            $codeCuci=$request->get('codecuci');
            $type= 1;
            $annee=$request->get('annee');
            $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]);
            if($request->get('submited')){
                $submit=true;
            }
            if(!$request->get('notsubmited')){

                $submit=false; 

            }
           

            $cr=$this->getDoctrine()->getRepository(ComptederesultatSmt::class)->findByCodeCuci($codeCuci, $annee);

            
            $countSaving = 0; // pour le control message flash

           if(count($cr)>1){
               

               foreach ($refAgg as $key ) {
                  $compteR =$this->getDoctrine()->getRepository(ComptederesultatSmt::class)->findOneBy(["repertoire"=>$repertoire,"anneeFinanciere"=>$annee,"refCode"=>$key->getId()]);

                 
                  if($compteR){ // si le compte existe, c'est une mise à jour

                      $compteR->setAnneeFinanciere($annee)
                            ->setRepertoire($repertoire)
                            ->setRefCode($key->getId())
                            ->setNet1(str_replace(",","",$request->get($key->getId()."net1")))
                            ->setNet2(str_replace(",","",$request->get($key->getId()."net2")))
                            ->setSubmit($submit)
                            # ->setUpdatedBy($this->getUser())
                            ->setUpdatedAt(new DateTime('now'));
                      $entityManager->flush();
                  }else{ // si l'annee n'existe pas, c'est une nouvelle creation

                        $comptR = new ComptederesultatSmt();
                        $comptR->setAnneeFinanciere($annee)
                               ->setRepertoire($repertoire)
                               ->setRefCode($key->getId())
                               ->setNet1(str_replace(",","",$request->get($key->getId()."net1")))
                               ->setNet2(str_replace(",","",$request->get($key->getId()."net2")))
                               ->setSubmit($submit) 
                        ;
                        $comptR->setCreatedBy($this->getUser());
                        $comptR->setUpdatedBy($this->getUser());
                            
                        $entityManager->persist($comptR);
                        $entityManager->flush();

                        $countSaving = $countSaving+1;
                    }
                }  // end for 
                    
            }else{
                    
                foreach ($refAgg as $key ) {
                    
                    $comptR = new ComptederesultatSmt();

                    $comptR->setAnneeFinanciere($annee)
                          ->setRepertoire($repertoire)
                          ->setRefCode($key->getId())
                          ->setNet1(str_replace(",","",$request->get($key->getId()."net1")))
                          ->setNet2(str_replace(",","",$request->get($key->getId()."net2")))
                          ->setSubmit($submit) 
                    ;
                    $comptR->setCreatedBy($this->getUser());
                    $comptR->setUpdatedBy($this->getUser());
               
                  

                  $entityManager->persist($comptR);
                  $entityManager->flush();
                  $countSaving= $countSaving+1;
                 
                }

           } // end first if loop

           if ($countSaving>0) {
               $this->addFlash("notice", "Sauvegarde effectuée avec succès !");
           }
        }

        return $this->renderForm('comptederesultat_smt/new.html.twig', [
          "refAgg" => $refAgg,
        ]);
    }


     /**
     * @Route("/smtCPjson/{annee}", name="smtCPjson", methods={"GET","POST"})
     */
    public function compteresultjson( $annee="")
    {
        $tab=[];
        $tab1=[];
        $tab2=[];
        $tab3=[];


        $session=new Session();
        $codeCuci= $session->get('codeCuci');   
        $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]);

       
        $session->set('annee', $annee);

        $cr  =$this->getDoctrine()->getRepository(ComptederesultatSmt::class)->findByCodeCuci($codeCuci, $annee);


        $refAgg=$this->getDoctrine()->getRepository(RefAggSmt::class)->findBy(["category"=>10],  array('ordre' => 'ASC'));
        

        if ($cr) {
        
            foreach ($cr as $key ) {

                $_cr =$this->getDoctrine()->getRepository(ComptederesultatSmt::class)->findOneBy(["repertoire"=>$repertoire,"anneeFinanciere"=>$annee-1,"refCode"=>$key->getRefCode()]);
        
                    $net11 = ""; $net12 = "";

                    if ($key->getNet1()) {
                        
                        $net11=number_format(str_replace(",","",$key->getNet1()));
                    }
                    if ($key->getNet2()) {
                        
                        $net12=number_format(str_replace(" ","",str_replace(",","",$key->getNet2())));
                    }


                    $tab1[$key->getRefCode()] = [$key->getRefCode(), $net11,$net12]; 

                
                
            } 
            # code...
        }else{
            
            foreach ($refAgg as $key ) {
                
                $_cr =$this->getDoctrine()->getRepository(ComptederesultatSmt::class)->findOneBy(["repertoire"=>$repertoire,"anneeFinanciere"=>$annee-1,"refCode"=>$key->getId()]);
                if ($_cr) {

                    $net1 = "";

                    if ($_cr->getNet1()) {
                        
                        $net1=number_format(str_replace(",","",$_cr->getNet1()));
                    }
                    
                    $tab1[$key->getId()] = [$key->getId(), "", $net1]; 
                }else{
                    $tab1[$key->getId()] = [$key->getId(), "",""]; 

                }
                
            } 
            
          
            
        }
            
        
        
    
            foreach ($refAgg as $key ) {
    
                 array_push($tab2,[$key->getId(),$key->getLibelle(),$key->getOrdre(),$key->getSurlignee()]);
            } 
    
    
           
    
             array_push($tab,$tab1);
             array_push($tab,$tab2);
           

            
        
       
        return new JsonResponse( $tab);
    }

    /**
     * @Route("/{id}", name="app_comptederesultat_smt_show", methods={"GET"})
     */
    public function show(ComptederesultatSmt $comptederesultatSmt): Response
    {
        return $this->render('comptederesultat_smt/show.html.twig', [
            'comptederesultat_smt' => $comptederesultatSmt,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_comptederesultat_smt_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ComptederesultatSmt $comptederesultatSmt, ComptederesultatSmtRepository $comptederesultatSmtRepository): Response
    {
        $form = $this->createForm(ComptederesultatSmtType::class, $comptederesultatSmt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comptederesultatSmtRepository->add($comptederesultatSmt);
            return $this->redirectToRoute('app_comptederesultat_smt_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comptederesultat_smt/edit.html.twig', [
            'comptederesultat_smt' => $comptederesultatSmt,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_comptederesultat_smt_delete", methods={"POST"})
     */
    public function delete(Request $request, ComptederesultatSmt $comptederesultatSmt, ComptederesultatSmtRepository $comptederesultatSmtRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comptederesultatSmt->getId(), $request->request->get('_token'))) {
            $comptederesultatSmtRepository->remove($comptederesultatSmt);
        }

        return $this->redirectToRoute('app_comptederesultat_smt_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/compareResultatExercices/{id}", name="compareResultatExercices", methods={"GET","POST"})
     */
    public function compareResultatExercices($id="")
    {
        $session = $this->requestStack->getSession();
        $codeCuci = $session->get("codeCuci");
        
        $repertoire = $this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(array("codeCuci"=>$codeCuci));  

        
        $type = "Passif";
        $refCode = "7";
        
        $bilanPassif = $this->getDoctrine()->getRepository(BilanSmt::class)->findOneBy(array(
            "repertoire"=>$repertoire->getId(), 
            "refCode"=>$refCode,
            "type"=>$type,
            "anneeFinanciere"=>$id, 
        ));


        $bilanPassifnm1 = $this->getDoctrine()->getRepository(BilanSmt::class)->findOneBy(array(
            "repertoire"=>$repertoire->getId(), 
            "refCode"=>$refCode,
            "type"=>$type,
            "anneeFinanciere"=>$id-1, 
        ));
         
        $net1Passif = 0;
        $net2Passif = 0;
        if (!$bilanPassif) {
            $net1Passif = 0;
            $net2Passif = 0;
            
        }else {
            $net1Passif = $bilanPassif->getNet1();
            $net2Passif = $bilanPassif->getNet2();
        }
        
        
        $tab = [];
        if ($net1Passif=="" ) {
            $net1Passif =0;       
        }
        if ($net2Passif=="" ) {
            $net2Passif =0;       
        }
        
        // array_push($tab, [$net1Passif, $net2Passif]);  
        array_push($tab, [$net1Passif, $net2Passif]);  

        
        // return new JsonResponse([25858906 25858906,31025601]);
        return new JsonResponse($tab);
    }

}
