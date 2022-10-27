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
use Symfony\Component\Validator\Constraints\Length;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/flux/tresoreries")
 * @IsGranted("ROLE_USER")
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

        $submit_flux = null; 
        $user = $this->getUser();
        if($request->get('annee')){
          
           $codeCuci=$request->get('codecuci');
           // $type=$request->get('type');
            $type= 1;
           $annee=$request->get('annee');

            # $bn = $this->cdrRepo->findByCodeCuci($codeCuci, $annee); 
            $bn = $this->fdtRepo->findByCodeCuciAnneeAndCategory($codeCuci, $annee); 

            $countSaving = 0; // pour le control message flash

            

           if($request->get('submited')){
            $submit_flux=1;

            // show flashback msg here
            $request->getSession()->getFlashBag()->add('notice', 'Cet enregistrement a été sauvegardé et validé avec succès !');            
           
          }
          elseif(!$request->get('notsubmited')){
            $submit_flux=$request->get('notsubmited'); 
            $request->getSession()->getFlashBag()->add('notice', 'Cet enregistrement a été sauvegardé mais invalidé avec succès.');

          }

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
                            ->setNet2($request->get($key->getCode()."net2"))
                            ->setSubmit($submit_flux)
                            ->setModifiedBy($user)
                            ->setUpdatedAt(new \DateTime())
                    ;
                            $entityManager->flush();
                  }else{ // si l'annee n'existe pas, c'est une nouvelle creation

                      $bilan = new FluxDesTresoreries();
                      $bilan->setAnneeFinanciere($annee)
                            ->setCuciRepCode($this->reperRepo->findOneBy(array("codeCuci" => $codeCuci)))
                            ->setRefCode($key->getCode())
                            ->setNet1($request->get($key->getCode()."net1"))
                            ->setNet2($request->get($key->getCode()."net2"))
                            ->setSubmit($submit_flux)
                            ->setEditedBy($user)
                            ->setModifiedBy($user)
                            ->setUpdatedAt(new \DateTime())
                            ;                            
                            
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
                          ->setNet2($request->get($key->getCode()."net2"))
                          ->setSubmit($submit_flux) 
                          ->setEditedBy($user)
                          ->setModifiedBy($user)
                          ->setUpdatedAt(new \DateTime())
                          ;                            
                    $entityManager->persist($bilan);
                    $entityManager->flush();
                    $countSaving= $countSaving+1;
                }

           } // end first if loop

           return $this->redirectToRoute("immo_brut_new", [], Response::HTTP_SEE_OTHER);
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
        
        $refAgg = $this->refAggRepo
                       ->findBy(["category"=>3,"surlignee"=>0],  array('code' => 'DESC'));
            
        $refAggParent=$this->refAggRepo
                           ->findBy(["category"=>3,"surlignee"=>1],array('code' => 'DESC'));

        $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]);

        if ($flux) {
            
            
            foreach ($flux as $key ) {

               
                    $var_net11 = ""; $net12 = "";
                   
                    if (is_numeric(str_replace(" ","",str_replace(",","",$key->getNet1())))) 
                    {
                        $var_net11=number_format(str_replace(" ","",str_replace(",","",$key->getNet1())));
                    }else 
                      $var_net11=str_replace(" ","",str_replace(",","",$key->getNet1()));

                      if (is_numeric(str_replace(" ","",str_replace(",","",$key->getNet2()))))  {
                        
                        $net12=number_format(str_replace(" ","",str_replace(",","",$key->getNet2())));
                    }else $net12=str_replace(" ","",str_replace(",","",$key->getNet2()));

                    
                    $tab1[$key->getRefCode()] = [$key->getRefCode(),$var_net11, $net12];
                
                 
                 
            }
    
        }else {
            foreach ($refAgg as $key ) {
                $_ft =$this->getDoctrine()->getRepository(FluxDesTresoreries::class)->findOneBy(["cuci_rep_code"=>$repertoire,"annee_financiere"=>$annee-1,"ref_code"=>$key->getCode()]);

                if ($_ft) {

                    $net1 = "";
                    if (is_numeric(str_replace(" ","",str_replace(",","",$_ft->getNet1())))) 
                    {
                        $net1 = number_format(str_replace(" ","",str_replace(",","",$_ft->getNet1())));
                    }
                    else $net1 = str_replace(" ","",str_replace(",","",$_ft->getNet1()));
                    $tab1[$key->getCode()] = [$key->getCode(),"", $net1];
                    
                }else {
                    $tab1[$key->getCode()] = [$key->getCode(),"", ""];
                    
                }
            } 
            
            foreach ($refAggParent as $key ) {
                $_ft =$this->getDoctrine()->getRepository(FluxDesTresoreries::class)->findOneBy(["cuci_rep_code"=>$repertoire,"annee_financiere"=>$annee-1,"ref_code"=>$key->getCode()]);

                if ($_ft) {

                    $net1 = "";
                    if (is_numeric(str_replace(" ","",str_replace(",","",$_ft->getNet1())))) {
                        $net1 = number_format(str_replace(" ","",str_replace(",","",$_ft->getNet1())));
                    }else 
                    $net1 = str_replace(" ","",str_replace(",","",$_ft->getNet1()));
                    $tab1[$key->getCode()] = [$key->getCode(),"", $net1];
                    
                }else {
                    $tab1[$key->getCode()] = [$key->getCode(),"", ""];
                    
                }
            }  
        } 
    
    
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
        /// calcul de la valeur sumZA = tresorie actif n-1 moins 
        //  tresorerie passif n-1
        $session = $this->requestStack->getSession();
        $codeCuci = $session->get("codeCuci");
        $annee = $session->get("annee");
        
        $repertoire = $this->reperRepo->findOneBy(array("codeCuci"=>$id));
        $type = "Actif";
        $typePassif = "Passif";
        $refCode = "BT";
        $refCodePassif = "DT";
        $tableau = [
            "refCode"=>$refCode,
            "type"=>$type,
            "anneeFinanciere"=>$annee,
            "repertoire"=>$repertoire,
        ];
        
        
        
        $net2BT = 0; $net2DT = 0;
        
        
        //// recuperer la valeur nette saisie n-1 DT biln passif
        $bilanPassif = $this->bilanRep->findOneBy(array(
            "refCode"=>$refCodePassif,
            "type"=>$typePassif,
            "anneeFinanciere"=>$annee,
            "repertoire"=>$repertoire,
        ));
        
        if ($bilanPassif) {
            if ($bilanPassif->getNet2()!= "") {
                $net2DT = $bilanPassif->getNet2();
            }
        }
        
        $bilanActif = $this->actifBTNet2($tableau); /// recuperer la valeur nette n-1 saisie BT actif
        
        if ($bilanActif) {
            
            if ($bilanActif->getNet2() != "") {
                $net2BT = $bilanActif->getNet2();
            
            }        
        }

        
        $tab = str_replace(",","",$net2BT) - str_replace(",","",$net2DT); 
       
        // return new JsonResponse([25858906 ,31025601]);
        return new JsonResponse($tab);
    }


    public function actifBTNet2($tab)
    {
        
        $bilanActif = $this->bilanRep->findOneBy($tab);

        return $bilanActif;
    }
}
