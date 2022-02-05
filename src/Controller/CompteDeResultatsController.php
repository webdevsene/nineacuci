<?php

namespace App\Controller;

use App\Entity\CompteDeResultats;
use App\Entity\RefAgg;
use App\Entity\Repertoire;
use App\Form\CompteDeResultatsType;
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
use Symfony\Component\HttpFoundation\Session\Session;


/**
 * @Route("/compte/resultats")
 * @IsGranted("ROLE_USER")
 */
class CompteDeResultatsController extends AbstractController
{
    // declarer ici les variable Repository qui entre en jeux 
    private RepertoireRepository $reperRepo;
    private CompteDeResultatsRepository $cdrRepo;
    private RefAggRepository $refAggRepo;
    private $requestStack;
    
    public function __construct(RequestStack $requestStack, 
                                RepertoireRepository $reperRepo, 
                                CompteDeResultatsRepository $cdrRepo,
                                RefAggRepository $refAggRepo)
    {
        $this->requestStack = $requestStack;
        $this->reperRepo = $reperRepo;
        $this->cdrRepo = $cdrRepo;
        $this->refAggRepo = $refAggRepo;
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
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_BSE_AGENT_SAISIE')")
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {

        $refAgg=$this->getDoctrine()->getRepository(RefAgg::class)->findBy(["category"=>2]); 
        if($request->get('annee')){
          
           $codeCuci=$request->get('idcuci');
        //    $type=$request->get('type');
            $type= 1;
           $annee=$request->get('annee');


            

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
                            ->setNet1($request->get($key->getCode()."net1"))
                            ->setNet2($request->get($key->getCode()."net2")) ;
                      $entityManager->flush();
                  }else{ // si l'annee n'existe pas, c'est une nouvelle creation

                      $bilan = new CompteDeResultats();
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
                    
                    $bilan = new CompteDeResultats();

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
       


        return $this->renderForm('compte_de_resultats/new.html.twig', [
            
          "refAgg" => $refAgg,
        ]);
    }

    /**
     * @Route("/new", name="compte_de_resultats_new", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_BSE_AGENT_SAISIE')")
     */
   /*  public function new(Request $request, EntityManagerInterface $entityManager): Response
    {

        if ($request->get('annee')) {
            // recuperer le code cuci
            $codeCuci = $request->get('idcuci'); 
             // recuperer l'annee meme
            $annee = $request->get('annee'); 

            // on recharge tous les champs du formulaires 
            // si l'annee donnee existe dans le compte_de_resultat
            $exists = $this->cdrRepo->findBy(array("annee_financiere" => $annee, "cuci_rep_code"=>$this->reperRepo->findOneBy(array("codeCuci" => $codeCuci))));
             

            if ($exists) {
                // traitement restituer le formulaire avec les donnees des champs
                return $this->renderForm("compte_de_resultats/show.html.twig", [
                    "restituer" => $exists,
                ]);
            }

            $refAgg = $this->refAggRepo
                           ->findBy(array("category" => 2)); 
            
            $countSaving = 0;

            foreach ($refAgg as $key) {
                $compteResultat = new CompteDeResultats;

                $compteResultat->setAnneeFinanciere($annee)
                               ->setCuciRepCode($this->reperRepo->findOneBy(array("codeCuci" => $codeCuci)))
                               ->setRefCode($key->getCode())
                               ->setNet1($request->get($key->getCode()."net1"))
                               ->setNet2($request->get($key->getCode()."net2"))
                ;

              $entityManager->persist($compteResultat);
              $entityManager->flush();

              $countSaving = $countSaving+1;


            }

            if ($countSaving > 0) {
                $this->addFlash('notice', "Sauvegarde effectuée avec succès !");
            }
        }

        return $this->renderForm('compte_de_resultats/new.html.twig', [
        ]);
    } */

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
     * @Route("/nineaNum/{id}", name="nineaNum", methods={"GET","POST"})
     */
    public function nineaNum(Request $request, $id="")
    {
        $tab=[];
        if ($request->isXmlHttpRequest()) {
            
            $rep=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$id]);

            $session = $this->requestStack->getSession();
            // stores an attribute in the session for later reuse
            $session->set('codeCuci', $id);
        }
    
              
        return new JsonResponse( $rep->getDenominationSocial());
    }


    
      /**
     * @Route("/bilanjson/{annee}", name="bilanjson", methods={"GET","POST"})
     */
    public function bilanjson( $annee="")
    {
        $tab=[];
        $tab1=[];
        $tab2=[];
        $tab3=[];

        $session = $this->requestStack->getSession();

        $codeCuci= $session->get('codeCuci');   

        
        // $bilan=$this->getDoctrine()->getRepository(CompteDeResultats::class)->findByCodeCuci($codeCuci,$annee);

        $bilan = $this->cdrRepo->findByCodeCuci($codeCuci, $annee);
            
            foreach ($bilan as $key ) {
    
                 // array_push($tab1,[$key->getRefCode(),$key->getBrut(),$key->getNet1(),$key->getNet2()]);
                 // pour le compte de resultats il prend deux champs net1 net2

                 $tab1[$key->getRefCode()] = [$key->getRefCode(),$key->getNet1(), $key->getNet2()];
                 /* array_push($tab1,[
                    $key->getRefCode(),
                     $key->getNet1(),
                     $key->getNet2()]);  */
    
             } 
            // $refAgg=$this->getDoctrine()->getRepository(RefAgg::class)->findBy(["category"=>1,"typeBilan"=>1,"surlignee"=>0],  array('code' => 'DESC'));
    
            $refAgg = $this->refAggRepo
                           //->findBy(["category"=>2,"typeBilan"=>1,"surlignee"=>0],  array('code' => 'DESC'));
                           ->findBy(["category"=>2,"surlignee"=>0],  array('code' => 'DESC'));
    
            // $refAggParent=$this->getDoctrine()->getRepository(RefAgg::class)->findBy(["category"=>1,"typeBilan"=>1,"surlignee"=>1],array('code' => 'DESC'));
            
            $refAggParent=$this->refAggRepo
                               ->findBy(["category"=>2,"surlignee"=>1],array('code' => 'DESC'));
    
            foreach ($refAgg as $key ) {
    
                 array_push($tab2,[$key->getCode(),$key->getLibelle(),$key->getParent(),$key->getOrdre(),$key->getSurlignee()]);
            } 
    
    
            foreach ($refAggParent as $key ) {
    
                 array_push($tab3,[$key->getCode(),$key->getLibelle(),$key->getParent(),$key->getOrdre(),$key->getSurlignee()]);
            } 
    
    
             array_push($tab,$tab1);
             array_push($tab,$tab2);
             array_push($tab,$tab3);
        
       
    
              
        return new JsonResponse( $tab);
    }
}
