<?php

namespace App\Controller;

use App\Entity\CompteDeResultats;
use App\Entity\RefAgg;
use App\Entity\Repertoire;
use App\Form\CompteDeResultatsType;
use App\Repository\BilanRepository;
use App\Repository\CompteDeResultatsRepository;
use App\Repository\RefAggRepository;
use App\Repository\RepertoireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;


/**
 * @Route("/compte/resultats")
 * @IsGranted("ROLE_USER")
 */
class CompteDeResultatsController extends AbstractController
{
   private $requestStack;
    
    public function __construct(RequestStack $requestStack, 
                                RepertoireRepository $reperRepo, 
                                CompteDeResultatsRepository $cdrRepo,
                                RefAggRepository $refAggRepo,
                                BilanRepository $bilanRep)
    {
        $this->requestStack = $requestStack;
        $this->reperRepo = $reperRepo;
        $this->cdrRepo = $cdrRepo;
        $this->refAggRepo = $refAggRepo;
        $this->bilanRep = $bilanRep;
    }


    /**
     * @Route("/", name="compte_de_resultats_index", methods={"GET"})
     */
    public function index(CompteDeResultatsRepository $compteDeResultatsRepository): Response
    {
        return $this->render('compte_de_resultats/index.html.twig', [
            'compte_de_resultats' => $compteDeResultatsRepository->findAll(),
        ]);
    }


    
    /**
     * @Route("/new", name="compte_de_resultats_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $submit = null;
        $refAgg=$this->getDoctrine()->getRepository(RefAgg::class)->findBy(["category"=>2]); 
        $user = $this->getUser();
        if($request->get('annee')){
          
           $codeCuci=$request->get('codecuci');
        //    $type=$request->get('type');
            $type= 1;
           $annee=$request->get('annee');


           if($request->get('submited')){
                $submit=1;

                // show flashback msg here
                $request->getSession()->getFlashBag()->add('notice', 'Cet enregistrement a été sauvegardé et validé avec succès !');

                # return $this->redirectToRoute("compte_de_resultats_new");
            
            
            }
            #if(!$request->get('notsubmited'))
            else{
                $submit=$request->get('notsubmited'); 
                $request->getSession()->getFlashBag()->add('notice', 'Cet enregistrement a été sauvegardé mais invalidé avec succès.');

                # return $this->redirectToRoute("compte_de_resultats_new");
            }
           

            $bn = $this->cdrRepo->findByCodeCuci($codeCuci, $annee); 

            
            $countSaving = 0; // pour le control message flash

           if(count($bn)>1){
               foreach ($refAgg as $key ) {
                  $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]);
                  $bilan =$this->getDoctrine()->getRepository(CompteDeResultats::class)->findOneBy(["cuci_rep_code"=>$repertoire,"annee_financiere"=>$annee,"ref_code"=>$key->getCode()]);

                 
                  if($bilan){ // si le compte existe, c'est une mise à jour


                      $bilan->setAnneeFinanciere($annee)
                            ->setCuciRepCode($this->reperRepo->findOneBy(array("codeCuci" => $codeCuci)))
                            ->setRefCode($key->getCode())
                            ->setNet1(str_replace(",","",$request->get($key->getCode()."net1"))?:"")
                            ->setNet2(str_replace(",","",$request->get($key->getCode()."net2"))?:"")
                            ->setSubmit($submit)
                            ->setModifiedBy($user) 
                            ->setUpdatedAt(new \DateTime())
                    ;
                      $entityManager->flush();
                  }else{ // si l'annee n'existe pas, c'est une nouvelle creation

                      $bilan = new CompteDeResultats();
                      $bilan->setAnneeFinanciere($annee)
                            ->setCuciRepCode($this->reperRepo->findOneBy(array("codeCuci" => $codeCuci)))
                            ->setRefCode($key->getCode())
                            ->setNet1(str_replace(",","",$request->get($key->getCode()."net1"))?:"")
                            ->setNet2(str_replace(",","",$request->get($key->getCode()."net2"))?:"")
                            ->setSubmit($submit)
                            ->setModifiedBy($user)
                            ->setCreatedBy($user)
                            ->setUpdatedAt(new \DateTime())
                            ;
                            
                            $entityManager->persist($bilan);
                            $entityManager->flush();

                            $countSaving = $countSaving+1;
                        }
                }  // end for 
                    
            }else{
                    
                foreach ($refAgg as $key ) {
                    
                    $bilan = new CompteDeResultats();

                    $bilan->setAnneeFinanciere($annee)
                          ->setCuciRepCode($this->reperRepo->findOneBy(array("codeCuci" => $codeCuci)))
                          ->setRefCode($key->getCode())
                          ->setNet1(str_replace(",","",$request->get($key->getCode()."net1"))?:"")
                          ->setNet2(str_replace(",","",$request->get($key->getCode()."net2"))?:"")
                          ->setSubmit($submit)
                          ->setCreatedBy($user)
                          ->setModifiedBy($user)
                          ->setUpdatedAt(new \DateTime())
                          ;
                

                    $entityManager->persist($bilan);
                    $entityManager->flush();
                    $countSaving= $countSaving+1;
                 
                }

           } // end first if loop

           return $this->redirectToRoute("flux_des_tresoreries_new");
        }
       


        return $this->renderForm('compte_de_resultats/new.html.twig', [
            
          "refAgg" => $refAgg,
        ]);
    }

    /**
     * @Route("/{id}", name="compte_de_resultats_show", methods={"GET"})
     */
    public function show(CompteDeResultats $compteDeResultat): Response
    {
        return $this->render('compte_de_resultats/show.html.twig', [
            'compte_de_resultat' => $compteDeResultat,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="compte_de_resultats_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CompteDeResultats $compteDeResultat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CompteDeResultatsType::class, $compteDeResultat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('compte_de_resultats_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('compte_de_resultats/edit.html.twig', [
            'compte_de_resultat' => $compteDeResultat,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="compte_de_resultats_delete", methods={"POST"})
     */
    public function delete(Request $request, CompteDeResultats $compteDeResultat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$compteDeResultat->getId(), $request->request->get('_token'))) {
            $entityManager->remove($compteDeResultat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('compte_de_resultats_index', [], Response::HTTP_SEE_OTHER);
    }


    
    


    
      /**
     * @Route("/compte_result_json/{annee}", name="compte_result_json", methods={"GET","POST"})
     */
    public function compte_result_json( $annee="")
    {
        $tab=[];
        $tab1=[];
        $tab2=[];
        $tab3=[];

        $session = $this->requestStack->getSession();

        $codeCuci= $session->get('codeCuci');   
        $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]);

        $session = $this->requestStack->getSession();
        // stores an attribute in the session for later reuse
        $session->set('annee', $annee);

        $bilan = $this->cdrRepo->findByCodeCuci($codeCuci, $annee);


          // $refAgg = $this->refAggRepo
            //                ->findBy(["category"=>2,"surlignee"=>0],  array('code' => 'DESC'));
        $refAgg = $this->refAggRepo
                       ->findBy(["category"=>2,"surlignee"=>0],  array('ordre' => 'ASC'));
            
        $refAggParent=$this->refAggRepo
                               ->findBy(["category"=>2,"surlignee"=>1],array('code' => 'ASC'));


        if ($bilan) {
        
            foreach ($bilan as $key ) {

                
                    $net11 = ""; $net12 = "";

                    if (is_numeric(str_replace(" ","",str_replace(",","",$key->getNet1())))) {
                        
                        $net11=number_format(str_replace(" ","",str_replace(",","",$key->getNet1())));
                    }else
                        $net11=str_replace(" ","",str_replace(",","",$key->getNet1()));

                    if (is_numeric(str_replace(" ","",str_replace(",","",$key->getNet2())))) 
                        $net12=number_format(str_replace(" ","",str_replace(",","",$key->getNet2())));
                    else 
                       $net12=str_replace(" ","",str_replace(",","",$key->getNet2()));


                    $tab1[$key->getRefCode()] = [$key->getRefCode(), $net11,$net12]; # on maintient son net2

                
                
            } 
            # code...
        }else{
            
            foreach ($refAgg as $key ) {
                
                $_cr =$this->getDoctrine()->getRepository(CompteDeResultats::class)->findOneBy(["cuci_rep_code"=>$repertoire,"annee_financiere"=>$annee-1,"ref_code"=>$key->getCode()]);
                if ($_cr) {

                    $net1 = "";
                    if (is_numeric(str_replace(" ","",str_replace(",","",$_cr->getNet1())))) 
                    {
                        $net1=number_format(str_replace(" ","",str_replace(",","",$_cr->getNet1())));
                    }else  $net1=str_replace(" ","",str_replace(",","",$_cr->getNet1()));
                    
                    $tab1[$key->getCode()] = [$key->getCode(), "", $net1]; 
                }else{
                    $tab1[$key->getCode()] = [$key->getCode(), "",""]; 

                }
                
            } 
            
            foreach ($refAggParent as $key ) {
                
                $_cr =$this->getDoctrine()->getRepository(CompteDeResultats::class)->findOneBy(["cuci_rep_code"=>$repertoire,"annee_financiere"=>$annee-1,"ref_code"=>$key->getCode()]);
                
                if ($_cr) {

                    $net1 = "";

                    if (is_numeric(str_replace(" ","",str_replace(",","",$_cr->getNet1())))) 
                        
                        $net1=number_format(str_replace(" ","",str_replace(",","",$_cr->getNet1())));
                    else
                       $net1=str_replace(" ","",str_replace(",","",$_cr->getNet1()));
                    
                    $tab1[$key->getCode()] = [$key->getCode(), "", $net1]; 
                }else{
                    $tab1[$key->getCode()] = [$key->getCode(), "",""]; 

                }                
            } 
            
        }
            
        
        
    
            foreach ($refAgg as $key ) {
    
                 array_push($tab2,[$key->getCode(),$key->getLibelle(),$key->getParent(),$key->getOrdre(),$key->getSurlignee(), $key->getSignes(), $key->getNotes()]);
            } 
    
    
            foreach ($refAggParent as $key ) {
    
                 array_push($tab3,[$key->getCode(),$key->getLibelle(),$key->getParent(),$key->getOrdre(),$key->getSurlignee(), $key->getSignes(), $key->getNotes()]);
            } 
    
    
             array_push($tab,$tab1);
             array_push($tab,$tab2);
             array_push($tab,$tab3);

            
        
       
        return new JsonResponse( $tab);
    }


    /**
     * @Route("/compareCiXi/{id}", name="compareCiXi", methods={"GET","POST"})
     */
    public function compareCiXi($id="")
    {
        $session = $this->requestStack->getSession();
        $codeCuci = $session->get("codeCuci");
        
        $repertoire = $this->reperRepo->findOneBy(array("codeCuci"=>$codeCuci));  

        
        $type = "Passif";
        $refCode = "CI";
        
        $bilanPassif = $this->bilanRep->findOneBy(array(
            "repertoire"=>$repertoire->getId(), 
            "refCode"=>$refCode,
            "type"=>$type,
            "anneeFinanciere"=>$id, 
        ));


        $bilanPassifnm1 = $this->bilanRep->findOneBy(array(
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
