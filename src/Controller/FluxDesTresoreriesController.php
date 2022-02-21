<?php

namespace App\Controller;

use App\Entity\Bilan;
use App\Entity\FluxDesTresoreries;
use App\Entity\RefAgg;
use App\Entity\Repertoire;
use App\Form\FluxDesTresoreriesType;
use App\Repository\BilanRepository;
use App\Repository\FluxDesTresoreriesRepository;
use App\Repository\RefAggRepository;
use App\Repository\RepertoireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/flux/tresoreries")
 */
class FluxDesTresoreriesController extends AbstractController
{
    private $requestStack;
     
     public function __construct(RequestStack $requestStack, 
                                 RepertoireRepository $reperRepo, 
                                 FluxDesTresoreriesRepository $fdtRepo,
                                 RefAggRepository $refAggRepo,
                                 BilanRepository $bilanRep)
     {
         $this->requestStack = $requestStack;
         $this->reperRepo = $reperRepo;
         $this->fdtRepo = $fdtRepo;
         $this->refAggRepo = $refAggRepo;
         $this->bilanRep = $bilanRep;
     }


    /**
     * @Route("/", name="flux_des_tresoreries_index", methods={"GET"})
     */
    public function index(FluxDesTresoreriesRepository $fluxDesTresoreriesRepository): Response
    {
        return $this->render('flux_des_tresoreries/index.html.twig', [
            'flux_des_tresoreries' => $fluxDesTresoreriesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="flux_des_tresoreries_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {

        $refAgg=$this->getDoctrine()->getRepository(RefAgg::class)->findBy(["category"=>3]); 
        if($request->get('annee')){
          
           $codeCuci=$request->get('idcuci');
           // $type=$request->get('type');
            $type= 1;
           $annee=$request->get('annee');

            # $bn = $this->cdrRepo->findByCodeCuci($codeCuci, $annee); 
            $bn = $this->fdtRepo->findByCodeCuciAnneeAndCategory($codeCuci, $annee); 

            $countSaving = 0; // pour le control message flash

           if(count($bn)>1){
               foreach ($refAgg as $key ) {
                  $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]);
                  $bilan =$this->getDoctrine()->getRepository(FluxDesTresoreries::class)->findOneBy(["cuci_rep_code"=>$repertoire,"annee_financiere"=>$annee,"ref_code"=>$key->getCode()]);

                  //dd($bilan);
                  if($bilan){ // si le compte existe, c'est une mise à jour

                      $bilan->setAnneeFinanciere($annee)
                            ->setCuciRepCode($this->reperRepo->findOneBy(array("codeCuci" => $codeCuci)))
                            ->setRefCode($key->getCode())
                            ->setNet1($request->get($key->getCode()."net1"))
                            ->setNet2($request->get($key->getCode()."net2")) ;
                      $entityManager->flush();
                  }else{ // si l'annee n'existe pas, c'est une nouvelle creation

                      $bilan = new FluxDesTresoreries();
                      $bilan->setAnneeFinanciere($annee)
                            ->setCuciRepCode($this->reperRepo->findOneBy(array("codeCuci" => $codeCuci)))
                            ->setRefCode($key->getCode())
                            ->setNet1($request->get($key->getCode()."net1"))
                            ->setNet2($request->get($key->getCode()."net2")) ;
                            
                            // $bilan->setCreatedBy($this->getUser());
                            // $bilan->setModifiedBy($this->getUser());
                            
                            $entityManager->persist($bilan);
                            $entityManager->flush();

                            $countSaving = $countSaving+1;
                        }
                }  // end for 
                    
            }else{
                    
                foreach ($refAgg as $key ) {
                    
                    $bilan = new FluxDesTresoreries();

                    $bilan->setAnneeFinanciere($annee)
                          ->setCuciRepCode($this->reperRepo->findOneBy(array("codeCuci" => $codeCuci)))
                          ->setRefCode($key->getCode())
                          ->setNet1($request->get($key->getCode()."net1"))
                          ->setNet2($request->get($key->getCode()."net2")) ;


                  $entityManager->persist($bilan);
                  $entityManager->flush();
                  $countSaving= $countSaving+1;
                }

           } // end first if loop

           if ($countSaving>0) {
               $this->addFlash("notice", "Sauvegarde effectuée avec succès !");
           }
        }
       


        return $this->renderForm('flux_des_tresoreries/new.html.twig', [
            
          "refAgg" => $refAgg,
        ]);
    }


    /**
     * @Route("/{id}", name="flux_des_tresoreries_show", methods={"GET"})
     */
    public function show(FluxDesTresoreries $fluxDesTresorery): Response
    {
        return $this->render('flux_des_tresoreries/show.html.twig', [
            'flux_des_tresorery' => $fluxDesTresorery,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="flux_des_tresoreries_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, FluxDesTresoreries $fluxDesTresorery, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FluxDesTresoreriesType::class, $fluxDesTresorery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('flux_des_tresoreries_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('flux_des_tresoreries/edit.html.twig', [
            'flux_des_tresorery' => $fluxDesTresorery,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="flux_des_tresoreries_delete", methods={"POST"})
     */
    public function delete(Request $request, FluxDesTresoreries $fluxDesTresorery, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fluxDesTresorery->getId(), $request->request->get('_token'))) {
            $entityManager->remove($fluxDesTresorery);
            $entityManager->flush();
        }

        return $this->redirectToRoute('flux_des_tresoreries_index', [], Response::HTTP_SEE_OTHER);
    }

    
     /**
     * @Route("/cucicodeNum/{id}", name="cucicodeNum", methods={"GET","POST"})
     */
    public function cucicodeNum(Request $request, $id="")
    {
        $tab=[];
        if ($request->isXmlHttpRequest()) {
            
            // $rep=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$id]);

            $rep = $this->reperRepo->findOneBy(["codeCuci"=>$id]);


            $session = $this->requestStack->getSession();
            // stores an attribute in the session for later reuse
            $session->set('codeCuci', $id);
        }
    
              
        return new JsonResponse( $rep->getDenominationSocial());
    }

    
    /**
     * @Route("/fluxtresorjson/{annee}", name="fluxtresorjson", methods={"GET","POST"})
     */
    public function fluxtresorjson( $annee="")
    {
        $tab=[];
        $tab1=[];
        $tab2=[];
        $tab3=[];
        $category = 3;

        $session = $this->requestStack->getSession();

        $codeCuci= $session->get('codeCuci');   

        //$flux = $this->fdtRepo->findByCodeCuci($codeCuci, $annee);
        $flux = $this->fdtRepo->findByCodeCuciAnneeAndCategory($codeCuci, $annee);
            
            foreach ($flux as $key ) {

                 $tab1[$key->getRefCode()] = [$key->getRefCode(),$key->getNet1(), $key->getNet2()];
                
    
            } 
    
            $refAgg = $this->refAggRepo
                           ->findBy(["category"=>3,"surlignee"=>0],  array('code' => 'DESC'));
                
            $refAggParent=$this->refAggRepo
                               ->findBy(["category"=>3,"surlignee"=>1],array('code' => 'DESC'));
    
            foreach ($refAgg as $key ) {
    
                 array_push($tab2,[$key->getCode(),$key->getLibelle(),$key->getParent(),$key->getOrdre(),$key->getSurlignee()]); // c'est ici qu'on ajoutera la note et le signe
            } 
    
    
            foreach ($refAggParent as $key ) {
    
                 array_push($tab3,[$key->getCode(),$key->getLibelle(),$key->getParent(),$key->getOrdre(),$key->getSurlignee()]);
            } 
    
    
             array_push($tab,$tab1);
             array_push($tab,$tab2);
             array_push($tab,$tab3);
        
        return new JsonResponse( $tab);
    }

    
    /**
     * @Route("/sumZA/{id}", name="sumZA", methods={"GET","POST"})
     */
    public function sumZA($id="")
    {
        $session = $this->requestStack->getSession();
        $codeCuci = $session->get("codeCuci");
        
        $repertoire = $this->reperRepo->findOneBy(array("codeCuci"=>$codeCuci));  
        $type = "Actif";
        $typePassif = "Passif";
        $refCode = "BT";
        $refCodePassif = "DT";


        $bilanActif = $this->getDoctrine()->getRepository(Bilan::class)
                           ->findOneBy([
                               "repertoire"=>$repertoire,
                               "anneeFinanciere"=>$id,
                            ]);
        
        dd($bilanActif);

        $bilanPassif = $this->bilanRep
                            ->findOneBy(array(
                               "repertoire"=>$repertoire, 
                               "anneeFinanciere"=>$id, 
                               "type"=>$typePassif,
                               "refCode"=>$refCodePassif
                            ));
                            

        
        $tab = $bilanActif->getNet2()  - $bilanPassif->getNet2();  
        
        // return new JsonResponse([25858906 ,31025601]);
        return new JsonResponse($tab);
    }
}
