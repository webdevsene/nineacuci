<?php

namespace App\Controller;

use App\Entity\ImmoBrut;
use App\Entity\Repertoire;
use App\Entity\RefAgg;
use App\Form\ImmoBrutType;
use App\Repository\ImmoBrutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/immo/brut")
 * @IsGranted("ROLE_USER")
 */
class ImmoBrutController extends AbstractController
{
    /**
     * @Route("/", name="immo_brut_index", methods={"GET"})
     */
    public function index(ImmoBrutRepository $immoBrutRepository): Response
    {
        return $this->render('immo_brut/index.html.twig', [
            'immo_bruts' => $immoBrutRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="immo_brut_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        

         $refAgg=$this->getDoctrine()->getRepository(RefAgg::class)->findBy(["category"=>4]);
       

        if($request->get('annee')){
           
           $codeCuci=$request->get('codecuci');
           $type=$request->get('type');
           $annee=$request->get('annee');

           if($request->get('submited')){
             $submit=true;
             $request->getSession()->getFlashBag()->add('notice', 'Immobilisation brute a été sauvegardé et validé avec succès !');
            
           }else{
             $submit=false; 
             $request->getSession()->getFlashBag()->add('notice', 'Immobilisation brute a été sauvegardé  avec succès !');

           }


           $immoBruts=$this->getDoctrine()->getRepository(ImmoBrut::class)->findByCodeCuci($codeCuci,$annee);

           $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]);
           if(count($immoBruts)>1){
               foreach ($refAgg as $key ) {
                  
                  $immobrut =$this->getDoctrine()->getRepository(ImmoBrut::class)->findOneBy(["repertoire"=>$repertoire,"anneeFinanciere"=>$annee,"refCode"=>$key->getCode()]);

                 
                  if($immobrut){

                      $immobrut->setAnneeFinanciere($annee);
                      $immobrut->setRefCode($key->getCode());
                      $immobrut->setSubmit($submit);
                      $immobrut->setRepertoire($repertoire);
                      $immobrut->setBrutA(str_replace(",","",$request->get($key->getCode()."brutA")));
                      $immobrut->setAugmentationB3(str_replace(",","",$request->get($key->getCode()."augmentationB3")));
                      $immobrut->setAugmentationB2(str_replace(",","",$request->get($key->getCode()."augmentationB2")));
                      $immobrut->setAugmentationB1(str_replace(",","",$request->get($key->getCode()."augmentationB1")));
                      $immobrut->setBrutD(str_replace(",","",$request->get($key->getCode()."brutD")));
                      $immobrut->setDiminutionC1(str_replace(",","",$request->get($key->getCode()."diminutionC1")));
                      $immobrut->setDiminutionC2(str_replace(",","",$request->get($key->getCode()."diminutionC2")));
                      $immobrut->setModifiedby($this->getUser());
                      $immobrut->setUpdateAt(new \DateTime());
                      
                      $entityManager->flush();
                  }
                  else{

                      $immobrut = new ImmoBrut();

                      $immobrut->setAnneeFinanciere($annee);
                      $immobrut->setRefCode($key->getCode());
                      $immobrut->setSubmit($submit);
                      $immobrut->setRepertoire($this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]));
                      $immobrut->setBrutA(str_replace(",","",$request->get($key->getCode()."brutA")));
                      $immobrut->setAugmentationB3(str_replace(",","",$request->get($key->getCode()."augmentationB3")));
                      $immobrut->setAugmentationB2(str_replace(",","",$request->get($key->getCode()."augmentationB2")));
                      $immobrut->setAugmentationB1(str_replace(",","",$request->get($key->getCode()."augmentationB1")));
                      $immobrut->setBrutD(str_replace(",","",$request->get($key->getCode()."brutD")));
                      $immobrut->setDiminutionC1(str_replace(",","",$request->get($key->getCode()."diminutionC1")));
                      $immobrut->setDiminutionC2(str_replace(",","",$request->get($key->getCode()."diminutionC2")));
                      $immobrut->setCreatedby($this->getUser());
                      $immobrut->setModifiedby($this->getUser());
                      $immobrut->setUpdateAt(new \DateTime());
                      $entityManager->persist($immobrut);
                      $entityManager->flush();

                }
                }
           }else{

                foreach ($refAgg as $key ) {
                 
                  $immobrut = new ImmoBrut();

                  $immobrut->setAnneeFinanciere($annee);
                  $immobrut->setRefCode($key->getCode());
                  $immobrut->setRepertoire($this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]));
                  $immobrut->setSubmit($submit);
                  $immobrut->setBrutA(str_replace(",","",$request->get($key->getCode()."brutA")));
                  $immobrut->setAugmentationB3(str_replace(",","",$request->get($key->getCode()."augmentationB3")));
                  $immobrut->setAugmentationB2(str_replace(",","",$request->get($key->getCode()."augmentationB2")));
                  $immobrut->setAugmentationB1(str_replace(",","",$request->get($key->getCode()."augmentationB1")));
                  $immobrut->setBrutD(str_replace(",","",$request->get($key->getCode()."brutD")));
                  $immobrut->setDiminutionC1(str_replace(",","",$request->get($key->getCode()."diminutionC1")));
                  $immobrut->setDiminutionC2(str_replace(",","",$request->get($key->getCode()."diminutionC2")));
                  $immobrut->setCreatedby($this->getUser());
                  $immobrut->setModifiedby($this->getUser());
                  $immobrut->setUpdateAt(new \DateTime());
                  $entityManager->persist($immobrut);
                  $entityManager->flush();
                }

           }

           return $this->redirectToRoute('cuci_immo_plus_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('immo_brut/new.html.twig', [
            'refAgg' => $refAgg,
           
        ]);
    }

    /**
     * @Route("/{id}", name="immo_brut_show", methods={"GET"})
     */
    public function show(ImmoBrut $immoBrut): Response
    {
        return $this->render('immo_brut/show.html.twig', [
            'immo_brut' => $immoBrut,
        ]);
    }

    /**
     * @Route("/nineaNumImmoBrut/{id}", name="nineaNumImmoBrut", methods={"GET","POST"})
     */
    public function nineaNumImmoBrut( $id="")
    {
        $tab=[];
        $rep=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$id]);
        $session=new Session();
       // $session->start();
        $session->set('codeCuci',$id);
        return new JsonResponse( $rep->getDenominationSocial());
    }


      /**
     * @Route("/immoBrutjson/{annee}", name="immoBrutjson", methods={"GET","POST"})
     */
    public function immoBrutjson( $annee="")
    {
        $tab=[];
        $tab1=[];
        $tab2=[];
        $tab3=[];
        $tab4=[];


        $session=new Session();
        $codeCuci= $session->get('codeCuci');
        $session->set('annee',$annee);
        $brutATotal=0;
        $augmentationB1Total=0;
        $augmentationB2Total=0;
        $augmentationB3Total=0;
        $diminutionC1Total=0;
        $diminutionC2Total=0;
        $brutDTotal=0;
        
        $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]);
        $refAgg=$this->getDoctrine()->getRepository(RefAgg::class)->findBy(["category"=>4],  array('ordre' => 'ASC'));

        foreach ($refAgg as $key ) {

             array_push($tab2,[$key->getCode(),$key->getLibelle(),$key->getParent(),$key->getOrdre(),$key->getSurlignee()]);
        }

        $tb=[];
        foreach ($refAgg as $key ) {
            $tb[$key->getCode()]=$key->getSurlignee();
           
        }
        
        



        
        $immoBrut=$this->getDoctrine()->getRepository(ImmoBrut::class)->findByCodeCuci($codeCuci,$annee);
        
        foreach ($immoBrut as $key ) {
            $brutA="";
            $augmentationB1="";
            $augmentationB2="";
            $augmentationB3="";
            $diminutionC1="";
            $diminutionC2="";
            $brutD="";
          
            if($key->getBrutA()) { 
                if( $tb[$key->getRefCode()]) {
                    if($key->getBrutA())
                    $brutATotal=  $brutATotal + str_replace(" ","",str_replace(",","",$key->getBrutA())); 
                }  
                if(is_numeric(str_replace(" ","",str_replace(",","",$key->getBrutA()))))
                $brutA=number_format(str_replace(" ","",str_replace(",","",$key->getBrutA())));
                else
                $brutA=str_replace(" ","",str_replace(",","",$key->getBrutA()));
            }
            else $brutA="";

            if($key->getAugmentationB1()){ 
                if( $tb[$key->getRefCode()])
                $augmentationB1Total=$augmentationB1Total+ str_replace(" ","",str_replace(",","",$key->getAugmentationB1()));
                if(is_numeric(str_replace(" ","",str_replace(",","",$key->getAugmentationB1()))))
                $augmentationB1=number_format(str_replace(" ","",str_replace(",","",$key->getAugmentationB1())));
                else
                $augmentationB1=str_replace(" ","",str_replace(",","",$key->getAugmentationB1()));
            }
            else $augmentationB1="";

            if($key->getAugmentationB2() ){    
                if( $tb[$key->getRefCode()])
                $augmentationB2Total=$augmentationB2Total+str_replace(" ","",str_replace(",","",$key->getAugmentationB2())); 
                if(is_numeric(str_replace(" ","",str_replace(",","",$key->getAugmentationB2()))))    
                $augmentationB2=number_format(str_replace(" ","",str_replace(",","",$key->getAugmentationB2())));
                else
                $augmentationB2=str_replace(" ","",str_replace(",","",$key->getAugmentationB2()));
            }
            else $augmentationB2="";

            if($key->getAugmentationB3()) {  
                if( $tb[$key->getRefCode()])
                $augmentationB3Total=$augmentationB3Total+str_replace(" ","",str_replace(",","",$key->getAugmentationB3())); 
                if(is_numeric(str_replace(" ","",str_replace(",","",$key->getAugmentationB3()))))    
                $augmentationB3=number_format(str_replace(" ","",str_replace(",","",$key->getAugmentationB3())));
                else
                $augmentationB3=str_replace(" ","",str_replace(",","",$key->getAugmentationB3()));
            }
            else $augmentationB3="";

            if($key->getDiminutionC1() ) { 
                if( $tb[$key->getRefCode()])     
                $diminutionC1Total=$diminutionC1Total+str_replace(" ","",str_replace(",","",$key->getDiminutionC1()));
                if(is_numeric(str_replace(" ","",str_replace(",","",$key->getDiminutionC1()))))
                $diminutionC1=number_format(str_replace(" ","",str_replace(",","",$key->getDiminutionC1())));
                else
                $diminutionC1=str_replace(" ","",str_replace(",","",$key->getDiminutionC1()));
            }
            else $diminutionC1="";

            if($key->getDiminutionC2() ){ 
                if( $tb[$key->getRefCode()])
                $diminutionC2Total=$diminutionC2Total+str_replace(" ","",str_replace(",","",$key->getDiminutionC2()));
                if(is_numeric(str_replace(" ","",str_replace(",","",$key->getDiminutionC2()))))
                $diminutionC2=number_format(str_replace(" ","",str_replace(",","",$key->getDiminutionC2())));
                else
                $diminutionC2=str_replace(" ","",str_replace(",","",$key->getDiminutionC2()));
            }
            else $diminutionC2="";

            if($key->getBrutD()) {  
                if( $tb[$key->getRefCode()])
            $brutDTotal=  $brutDTotal+  str_replace(" ","",str_replace(",","",$key->getBrutD()));  
               if(is_numeric(str_replace(" ","",str_replace(",","",$key->getBrutD()))))
                $brutD=number_format(str_replace(" ","",str_replace(",","",$key->getBrutD())));
               else
               $brutD=str_replace(" ","",str_replace(",","",$key->getBrutD()));
            }
            else $brutD="";

          
            $tab1[$key->getRefCode()]=[$key->getRefCode(),$brutA, $augmentationB1, $augmentationB2,$augmentationB3,$diminutionC1,$diminutionC2,$brutD];
             
        } 
       
        if($brutATotal!=""){
        if(is_numeric($brutATotal))
          array_push($tab4,number_format($brutATotal));
        else
        array_push($tab4,$brutATotal);
        }
        else
        array_push($tab4,"");

        if($augmentationB1Total!=""){
         if(is_numeric($augmentationB1Total))
        array_push($tab4,number_format($augmentationB1Total));
        else
        array_push($tab4,$augmentationB1Total);
        }
        else
        array_push($tab4,"");

        if($augmentationB2Total!=""){
        if(is_numeric($augmentationB2Total))
        array_push($tab4,number_format($augmentationB2Total));
        else
        array_push($tab4,$augmentationB2Total);
        }
        else
        array_push($tab4,"");

        if($augmentationB3Total!=""){
         if(is_numeric($augmentationB3Total))
        array_push($tab4,number_format($augmentationB3Total));
        else
        array_push($tab4,$augmentationB3Total);
        }
        else
        array_push($tab4,"");


        if($diminutionC1Total!=""){
        if(is_numeric($diminutionC1Total))
        array_push($tab4,number_format($diminutionC1Total));
        else
        array_push($tab4,$diminutionC1Total);
        }
        else
        array_push($tab4,"");

        if($diminutionC2Total!=""){
        if(is_numeric($diminutionC2Total))
        array_push($tab4,number_format($diminutionC2Total));
        else
        array_push($tab4,$diminutionC2Total);
        }
        else
        array_push($tab4,"");

        if($brutDTotal!=""){
        if(is_numeric($brutDTotal))
        array_push($tab4,number_format($brutDTotal));
        else
        array_push($tab4,$brutDTotal);
        }
        else
        array_push($tab4,"");
          
      
       
  
        array_push($tab,$tab2);
        array_push($tab,$tab1);
        array_push($tab,$tab4);
              
        return new JsonResponse( $tab);
    }

    /**
     * @Route("/{id}/edit", name="immo_brut_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ImmoBrut $immoBrut, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ImmoBrutType::class, $immoBrut);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('immo_brut_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('immo_brut/edit.html.twig', [
            'immo_brut' => $immoBrut,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="immo_brut_delete", methods={"POST"})
     */
    public function delete(Request $request, ImmoBrut $immoBrut, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$immoBrut->getId(), $request->request->get('_token'))) {
            $entityManager->remove($immoBrut);
            $entityManager->flush();
        }

        return $this->redirectToRoute('immo_brut_index', [], Response::HTTP_SEE_OTHER);
    }
}
