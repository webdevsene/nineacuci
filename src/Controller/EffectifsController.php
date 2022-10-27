<?php

namespace App\Controller;

use App\Entity\CompteDeResultats;
use App\Entity\Effectifs;
use App\Entity\RefAgg;
use App\Entity\Repertoire;
use App\Form\EffectifsType;
use App\Repository\EffectifsRepository;
use App\Repository\RepertoireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/annexeff")
 * @IsGranted("ROLE_USER")
 */
class EffectifsController extends AbstractController
{
    private  $requestStack;
    
    public function __construct(RepertoireRepository $rep, RequestStack $requestStack)
    {
        // parent::__construct();
        $this->rep = $rep;
        $this->requestStack = $requestStack;
        
    }
    
    /**
     * @Route("/", name="app_effectifs_index", methods={"GET"})
     */
    public function index(EffectifsRepository $effectifsRepository): Response
    {
        return $this->render('effectifs/index.html.twig', [
            'effectifs' => $effectifsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_effectifs_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $refAgg=$this->getDoctrine()->getRepository(RefAgg::class)->findBy(["category"=>7,"typeBilan"=>3]);
        
        $refAggPersonext=$this->getDoctrine()->getRepository(RefAgg::class)->findBy(["category"=>7,"typeBilan"=>4]);
        $submit=false;
        $routpersonext=1;


        $units = "";
        
        
        if($request->get('annee')){

            
            $codeCuci=$request->get('codecuci');
            $type=$request->get('type');
            $annee=$request->get('annee');

            $routpersonext=2;

            
            // Retrieve the value from the extra field non-mapped !
            //$units = ($request->get("formrow-inputState")!=null) ? $request->get("formrow-inputStates") : $request->get('formrow-inputState'); 
            //dd($units);

            
            if($request->get('submited')){
                # $submit=true;
                # $submit=$request->get('submited');
                $submit=1;
                $request->getSession()->getFlashBag()->add('notice', 'Cet enregistrement a été sauvegardé et validé avec succès !'); 
                                
            }

            if(!$request->get('notsubmited')){
                # $submit=$request->get('notsubmited'); 
                $submit=0; 
                $request->getSession()->getFlashBag()->add('notice', 'Cet enregistrement a été sauvegardé mais invalide. Vous pouvez toujours valider
                                                            ultérieurement !');

            }
            
            
            $effect=$this->getDoctrine()->getRepository(Effectifs::class)->findByCodeCuci($codeCuci,$annee,"Effectif");
            
            $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]);
            
            
            if (count($effect)>1) {

               
               foreach ($refAgg as $key ) {
                   
                   $tabEffect =$this->getDoctrine()->getRepository(Effectifs::class)->findOneBy(["repertoire"=>$repertoire,"anneeFinanciere"=>$annee,"type"=>"Effectif","refCode"=>$key->getCode()]);
                   
                    
                    if($tabEffect){
                        
                        $tabEffect->setAnneeFinanciere($annee);
                        
                        $tabEffect->setRepertoire($repertoire);
                        
                        $tabEffect->setNmef($request->get($key->getCode()."Eff3"));
                        $tabEffect->setNfef($request->get($key->getCode()."Eff4"));
                        $tabEffect->setUmmef($request->get($key->getCode()."Eff5"));
                        $tabEffect->setUmfef($request->get($key->getCode()."Eff6"));
                        $tabEffect->setHmmef($request->get($key->getCode()."Eff7"));
                        $tabEffect->setHmfef($request->get($key->getCode()."Eff8"));
                        $tabEffect->setTotalEf($request->get($key->getCode()."TotalEff9"));
                        $tabEffect->setMnmef($request->get($key->getCode()."Eff10"));
                        $tabEffect->setMnfef($request->get($key->getCode()."Eff11"));
                        $tabEffect->setMummef($request->get($key->getCode()."Eff12"));
                        $tabEffect->setMumfef($request->get($key->getCode()."Eff13"));
                        $tabEffect->setMhmmef($request->get($key->getCode()."Eff14"));
                        $tabEffect->setMhmfef($request->get($key->getCode()."Eff15"));
                        $tabEffect->setTotalMs($request->get($key->getCode()."TotalEff16"));
                    
                        $tabEffect->setUpdatedAt(new \DateTime());
                        $tabEffect->setRefCode($key->getCode());
                        $tabEffect->setType("Effectif")
                                  ->setSubmit($request->get('submited'))
                                  ->setUnits($request->get('formrow-inputState'))
                                  ->setUpdatedBy($this->getUser())
                        ;

                        
                        
                        $entityManager->flush();
                    }
                    else{

                    $effectif = new Effectifs();

                    $effectif->setAnneeFinanciere($annee);

                    $effectif->setRepertoire($this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]));


                    $effectif->setNmef($request->get($key->getCode()."Eff3"));
                    $effectif->setNfef($request->get($key->getCode()."Eff4"));
                    $effectif->setUmmef($request->get($key->getCode()."Eff5"));
                    $effectif->setUmfef($request->get($key->getCode()."Eff6"));
                    $effectif->setHmmef($request->get($key->getCode()."Eff7"));
                    $effectif->setHmfef($request->get($key->getCode()."Eff8"));
                    $effectif->setTotalEf($request->get($key->getCode()."TotalEff9"));
                    $effectif->setMnmef($request->get($key->getCode()."Eff10"));
                    $effectif->setMnfef($request->get($key->getCode()."Eff11"));
                    $effectif->setMummef($request->get($key->getCode()."Eff12"));
                    $effectif->setMumfef($request->get($key->getCode()."Eff13"));
                    $effectif->setMhmmef($request->get($key->getCode()."Eff14"));
                    $effectif->setMhmfef($request->get($key->getCode()."Eff15"));
                    $effectif->setTotalMs($request->get($key->getCode()."TotalEff16"));
                    
                    
                    $effectif->setRefCode($key->getCode());
                    $effectif->setType("Effectif")
                             ->setSubmit($submit)
                             ->setUnits($request->get('formrow-inputState'))
                             ;
                   
                    $effectif->setUpdatedBy($this->getUser());
                    $effectif->setCreatedBy($this->getUser());
                    $effectif->setUpdatedAt(new \DateTime());
                    
                    $entityManager->persist($effectif);
                    $entityManager->flush();


                }
            }
            } else {
                

                foreach ($refAgg as $key ) {
                 
                    $effectif = new Effectifs();
  
                    $effectif->setAnneeFinanciere($annee);
  
                    $effectif->setRepertoire($this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]));

                    
                    $effectif->setNmef($request->get($key->getCode()."Eff3"));
                    $effectif->setNfef($request->get($key->getCode()."Eff4"));
                    $effectif->setUmmef($request->get($key->getCode()."Eff5"));
                    $effectif->setUmfef($request->get($key->getCode()."Eff6"));
                    $effectif->setHmmef($request->get($key->getCode()."Eff7"));
                    $effectif->setHmfef($request->get($key->getCode()."Eff8"));
                    $effectif->setTotalEf($request->get($key->getCode()."TotalEff9"));
                    $effectif->setMnmef($request->get($key->getCode()."Eff10"));
                    $effectif->setMnfef($request->get($key->getCode()."Eff11"));
                    $effectif->setMummef($request->get($key->getCode()."Eff12"));
                    $effectif->setMumfef($request->get($key->getCode()."Eff13"));
                    $effectif->setMhmmef($request->get($key->getCode()."Eff14"));
                    $effectif->setMhmfef($request->get($key->getCode()."Eff15"));
                    $effectif->setTotalMs($request->get($key->getCode()."TotalEff16"));

                    
                    $effectif->setRefCode($key->getCode());
                    $effectif->setType("Effectif")
                             ->setSubmit($submit)
                             ->setUnits($request->get('formrow-inputState'))
                             ;
                   
                    $effectif->setUpdatedBy($this->getUser());
                    $effectif->setCreatedBy($this->getUser());  
                    $effectif->setUpdatedAt(new \DateTime());

                    $entityManager->persist($effectif);
                    $entityManager->flush();
                  }


            }
            
 
            return $this->redirectToRoute('app_effectifs_new', ["routpersonext"=>$routpersonext], Response::HTTP_SEE_OTHER);
            # return $this->redirectToRoute('app_production_de_exercice_new', [], Response::HTTP_SEE_OTHER);
        }
         
         
         ////// traitement saisie du personnel effectif

        if($request->get('anneePersonext')){


            $codeCuci=$request->get('codecuciPersonext');
            $type=$request->get('typePassif');
            $annee=$request->get('anneePersonext');

            if($request->get('submitedPassif')){
                $submit=$request->get('submitedPassif');
                $request->getSession()->getFlashBag()->add('notice', 'Cet enregistrement a été sauvegardé et validé avec succès !'); 
                
               
            }else
            
            //if(!$request->get('notsubmitedPassif'))
            {
                 $submit=$request->get('submitedPassif'); 
                 $request->getSession()->getFlashBag()->add('notice', 'Cet enregistrement a été sauvegardé mais invalide.');


            }




            $bn=$this->getDoctrine()->getRepository(Effectifs::class)->findByCodeCuci($codeCuci,$annee,"Personnel");
            
            
            $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]);
             
             if(count($bn)>1){
                 foreach ($refAggPersonext as $key ) {
                     
                     $effectifPer =$this->getDoctrine()->getRepository(Effectifs::class)->findOneBy(["repertoire"=>$repertoire,"anneeFinanciere"=>$annee,"type"=>"Personnel","refCode"=>$key->getCode()]);
                  
                   if($effectifPer){
 
                       $effectifPer->setAnneeFinanciere($annee);
 
                       $effectifPer->setRepertoire($repertoire);

                       
                       $effectifPer->setNmef($request->get($key->getCode()."person3"));
                       $effectifPer->setNfef($request->get($key->getCode()."person4"));
                       $effectifPer->setUmmef($request->get($key->getCode()."person5"));
                       $effectifPer->setUmfef($request->get($key->getCode()."person6"));
                       $effectifPer->setHmmef($request->get($key->getCode()."person7"));
                       $effectifPer->setHmfef($request->get($key->getCode()."person8"));
                       $effectifPer->setTotalEf($request->get($key->getCode()."Totalperson9"));
                       $effectifPer->setFacm($request->get($key->getCode()."person10"));
                       $effectifPer->setFacf($request->get($key->getCode()."person11"));

                       //$effectifPer->setTotalMs($request->get($key->getCode()."Totalperson16"));

                       $effectifPer->setRefCode($key->getCode());
                       $effectifPer->setType("Personnel")
                                   ->setSubmit($submit);
                      
                       $effectifPer->setUpdatedBy($this->getUser());
                      
                       $entityManager->flush();
                   }
                 else{
 
                       $new_effectif = new Effectifs();
 
                       $new_effectif->setAnneeFinanciere($annee);
 
                       $new_effectif->setRepertoire($this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]));

                       
                       $new_effectif->setNmef($request->get($key->getCode()."person3"));
                       $new_effectif->setNfef($request->get($key->getCode()."person4"));
                       $new_effectif->setUmmef($request->get($key->getCode()."person5"));
                       $new_effectif->setUmfef($request->get($key->getCode()."person6"));
                       $new_effectif->setHmmef($request->get($key->getCode()."person7"));
                       $new_effectif->setHmfef($request->get($key->getCode()."person8"));
                       $new_effectif->setTotalEf($request->get($key->getCode()."Totalperson9"));
                       $new_effectif->setFacm($request->get($key->getCode()."person10"));
                       $new_effectif->setFacf($request->get($key->getCode()."person11"));

                       //$new_effectif->setTotalMs($request->get($key->getCode()."Totalperson16"));                       


                       $new_effectif->setRefCode($key->getCode());
                       $new_effectif->setType("Personnel")
                                    ->setSubmit($submit);

                       $new_effectif->setCreatedBy($this->getUser());
                       $new_effectif->setUpdatedBy($this->getUser());


                       $entityManager->persist($new_effectif);
                       $entityManager->flush();
 
 
                 }
                 }
            }else{
 
                  foreach ($refAggPersonext as $key ) {
                      
                      $new_effectif = new Effectifs();
                      
                      $new_effectif->setAnneeFinanciere($annee);
                      
                      $new_effectif->setRepertoire($this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]));
                      
                      $new_effectif->setNmef($request->get($key->getCode()."person3"));
                      $new_effectif->setNfef($request->get($key->getCode()."person4"));
                      $new_effectif->setUmmef($request->get($key->getCode()."person5"));
                      $new_effectif->setUmfef($request->get($key->getCode()."person6"));
                      $new_effectif->setHmmef($request->get($key->getCode()."person7"));
                      $new_effectif->setHmfef($request->get($key->getCode()."person8"));
                      $new_effectif->setTotalEf($request->get($key->getCode()."Totalperson9"));
                      $new_effectif->setFacm($request->get($key->getCode()."person10"));
                      $new_effectif->setFacf($request->get($key->getCode()."person11"));
                      
                      //$new_effectif->setTotalMs($request->get($key->getCode()."Totalperson16"));                       
                      
                      
                      
                      $new_effectif->setRefCode($key->getCode());
                      $new_effectif->setType("Personnel")
                                   ->setSubmit($submit);
                      
                      
                      $new_effectif->setCreatedBy($this->getUser());
                      $new_effectif->setUpdatedBy($this->getUser());

                      $entityManager->persist($new_effectif);
                      $entityManager->flush();
                    }
                    
                }
 
                return $this->redirectToRoute('app_production_de_exercice_new', [], Response::HTTP_SEE_OTHER);
            }


        return $this->renderForm('effectifs/new.html.twig', [
            'refAgg' => $refAgg,
            'refAggPerson' => $refAggPersonext,
        ]);
    }

    /**
     * @Route("/{id}", name="app_effectifs_show", methods={"GET"})
     */
    public function show(Effectifs $effectif): Response
    {
        return $this->render('effectifs/show.html.twig', [
            'effectif' => $effectif,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_effectifs_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Effectifs $effectif, EffectifsRepository $effectifsRepository): Response
    {
        $form = $this->createForm(EffectifsType::class, $effectif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $effectifsRepository->add($effectif);
            return $this->redirectToRoute('app_effectifs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('effectifs/edit.html.twig', [
            'effectif' => $effectif,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_effectifs_delete", methods={"POST"})
     */
    public function delete(Request $request, Effectifs $effectif, EffectifsRepository $effectifsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$effectif->getId(), $request->request->get('_token'))) {
            $effectifsRepository->remove($effectif);
        }

        return $this->redirectToRoute('app_effectifs_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/nineaNumEffectif/{id}", name="nineaNumEffectif", methods={"GET"})
     */
    public function nineaNumEffectif($id="")
    {
        $repertoire = $this->rep->findOneBy(['codeCuci' => $id]);
        $session=new Session();
        $session->set('codeCuci',$id); 

        return new JsonResponse($repertoire->getDenominationSocial());
        
    }


    /**
   * @Route("/effectifpluspersonnel/{annee}", name="effectifpluspersonnel", methods={"GET","POST"})
   */
  public function effectifPlusPersonnel( $annee="")
  {
      $tab=[]; # tab global a retourner 
      $tab1=[]; # pour le chargement des données des effectifs
      $tab2=[]; # contient les agregats fils et libelle code ...
      $tab3=[]; # contient les agregats et libelle parent  

      $tabPersonnel=[]; # pour le chargement des données du personnel
      $tabPersonnel1=[]; # contient les agregats fils cas du personnel
      $tabPersonnel2=[]; # contient les agregats parent cas du personnel 

      $unites = ""; // pour le chargement de l'unite 


      $session=new Session();
      $codeCuci= $session->get('codeCuci');
      $session->set('annee',$annee);

      ### recupere effectif , masse salariale et personnel ext par type
      $effectifMasse = $this->getDoctrine()->getRepository(Effectifs::class)->findByCodeCuci($codeCuci, $annee, "Effectif");

      $personnelExt = $this->getDoctrine()->getRepository(Effectifs::class)->findByCodeCuci($codeCuci, $annee, "Personnel");
      
      ### retrouver le repertoire correspondant au codeCuci 
      $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]);

      //if (null == $personnelExt) {
      //    dd('ok');
      //}

      foreach ($personnelExt as $key) {
        $pext =$this->getDoctrine()->getRepository(Effectifs::class)->findOneBy(["repertoire"=>$repertoire,"anneeFinanciere"=>$annee,"type"=>"Personnel","refCode"=>$key->getRefCode()]); #//pas de pertinance pour n-1 annee
        
        ## on teste si $pext != null
        if($pext)
            $tabPersonnel1[$key->getRefCode()] = [
                $key->getNmef(),
                $key->getNfef(),
                $key->getUmmef(),
                $key->getUmfef(),
                $key->getHmmef(),
                $key->getHmfef(),
                $key->getTotalEf(),
                $key->getFacm(),
                $key->getFacm() ];               

            } 

        foreach ($effectifMasse as $key ) {
            
            $effMass =$this->getDoctrine()->getRepository(Effectifs::class)->findOneBy(["repertoire"=>$repertoire,"anneeFinanciere"=>$annee,"type"=>"Effectif","refCode"=>$key->getRefCode()]); #//pas de pertinance pour n-1 annee

            if($effMass)
                $tab1[$key->getRefCode()]=[
                    $key->getNmef(),
                    $key->getNfef(),
                    $key->getUmmef(),
                    $key->getUmfef(),
                    $key->getHmmef(),
                    $key->getHmfef(),
                    $key->getTotalEf(),
                    $key->getMnmef(),
                    $key->getMnfef(),
                    $key->getMummef(),
                    $key->getMumfef(),
                    $key->getMhmmef(),
                    $key->getMhmfef(),
                    $key->getTotalMs()

                ];

                $unites = ($key->getUnits()!="") ? $key->getUnits() : "CFA";

                
        }
            
      #/// on equete sur les refAggParent, RefAggPersonnel et refAggEffectif

      $RefAggPersonnel=$this->getDoctrine()->getRepository(RefAgg::class)->findBy(["category"=>7,"typeBilan"=>4],  array('ordre' => 'ASC'));

      $refAggEffectif=$this->getDoctrine()->getRepository(RefAgg::class)->findBy(["category"=>7,"typeBilan"=>3],  array('ordre' => 'ASC'));

      $refAggParent=$this->getDoctrine()->getRepository(RefAgg::class)->findBy(["category"=>7,"typeBilan"=>3],array('ordre' => 'ASC'));

     
      foreach ($RefAggPersonnel as $key ) {

        array_push($tabPersonnel2,[$key->getCode(),$key->getLibelle(),$key->getParent(),$key->getOrdre(),$key->getSurlignee()]);
        }



        foreach ($refAggEffectif as $key ) {

                array_push($tab2,[$key->getCode(),$key->getLibelle(),$key->getParent(),$key->getOrdre(),$key->getSurlignee()]);
        } 


        foreach ($refAggParent as $key ) {

                array_push($tab3,[$key->getCode(),$key->getLibelle(),$key->getParent(),$key->getOrdre(),$key->getSurlignee()]);
        }

        #//////
        array_push($tabPersonnel, $tabPersonnel1);      
        array_push($tabPersonnel, $tabPersonnel2);      

        array_push($tab, $tab1);
        array_push($tab, $tab2);
        array_push($tab, $tab3);


      $arr=[];


      array_push($arr,$tab);
      array_push($arr,$tabPersonnel);
      array_push($arr,$unites);
    
      return new JsonResponse( $arr);
  }

    
    /**
     * check controle : la masse salariale ne doit pas etre superieur 
     * aux charges du personnel au niveau du compte resultat
     * @Route("/checkMasseSalarialeChargePersonnel/{id}", name="checkMasseSalarialeChargePersonnel", methods={"GET","POST"})
     */
    public function checkMasseSalarialeChargePersonnel($id="")
    {
        /*check controle : la masse salariale (Total) ne doit pas etre superieur 
            aux charges du personnel (RK) au niveau du compte resultat
        */


        $session = $this->requestStack->getSession();
        $codeCuci = $session->get("codeCuci");
        $annee = $session->get("annee");
        
        $repertoire = $this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(array("codeCuci"=>$id));
        $refCode = "RK";
                
        
        //// recuperer la valeur nette saisie n-1 DT biln passif
        $chargePer = $this->getDoctrine()->getRepository(CompteDeResultats::class)->findOneBy(array(
            "ref_code"=>$refCode,
            "annee_financiere"=>$annee,
            "cuci_rep_code"=>$repertoire,
        ));
        

        
        $tab = ($chargePer!=null) ? str_replace(",","",$chargePer->getNet1()) : "" ; 
       
        return new JsonResponse($tab);
    }
  
}
