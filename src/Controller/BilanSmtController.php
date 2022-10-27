<?php

namespace App\Controller;

use App\Entity\BilanSmt;
use App\Entity\Repertoire;
use App\Entity\RefAggSmt;
use App\Form\BilanSmtType;
use App\Repository\BilanSmtRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/etatsmt/bilan")
 * @IsGranted("ROLE_USER")
 */
class BilanSmtController extends AbstractController
{
    /**
     * @Route("/", name="app_bilan_smt_index", methods={"GET"})
     */
    public function index(BilanSmtRepository $bilanSmtRepository): Response
    {
        

        return $this->render('bilan_smt/index.html.twig', [
            'bilan_smts' => $bilanSmtRepository->findAll(),
        ]);
    }

    /**
     * @Route("saisieEtat/", name="saisieEtatSmt", methods={"GET"})
     */
    public function saisieEtat(): Response
    {
       
        $session=new Session();
        $session->set('codeCuci',"");
        $session->set('annee',"");
        return $this->redirectToRoute('app_bilan_smt_new', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/new", name="app_bilan_smt_new", methods={"GET", "POST"})
     */
    public function new(Request $request, BilanSmtRepository $bilanSmtRepository, EntityManagerInterface $entityManager): Response
    {
        
        $refAggPassif=$this->getDoctrine()->getRepository(RefAggSmt::class)->findBy(["category"=>9,"TypeBilan"=>2],  array('ordre' => 'ASC'));
        $refAgg=$this->getDoctrine()->getRepository(RefAggSmt::class)->findBy(["category"=>9,"TypeBilan"=>1],  array('ordre' => 'ASC'));
        $submit=false;
        $routpassif=1;
        if($request->get('annee')){
           if($request->get('submited')){
                $submit=true;
           }else{
                $submit=false; 
           }
           $routpassif=2;
           
           $codeCuci=$request->get('codecuci');
           $type=$request->get('type');
           $annee=$request->get('annee');
           $bn=$this->getDoctrine()->getRepository(BilanSmt::class)->findByCodeCuci($codeCuci,$annee,"Actif");
           $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]);
           if(count($bn)>1){
               foreach ($refAgg as $key ) {
                    $bilan =$this->getDoctrine()->getRepository(BilanSmt::class)->findOneBy(["repertoire"=>$repertoire,"anneeFinanciere"=>$annee,"type"=>"Actif","refCode"=>$key->getId()]);
                    if($bilan){
                        $bilan->setAnneeFinanciere($annee);
                        $bilan->setRepertoire($repertoire);
                        $bilan->setBrut(str_replace(",","",$request->get($key->getId()."brut")));
                        $bilan->setAmortPR(str_replace(",","",$request->get($key->getId()."ammo")));
                        $bilan->setNet1(str_replace(",","",$request->get($key->getId()."net1")));
                        $bilan->setNet2(str_replace(",","",$request->get($key->getId()."net2")));
                        $bilan->setRefCode($key->getId());
                        $bilan->setType("Actif");
                        $bilan->setUpdatedAt(new DateTime('now'))
                              # ->setUpdatedBy($this->getUser())
                        ;
                        $bilan->setSubmit($submit);
                        $entityManager->flush();
                    }
                    else{

                        $bilan = new BilanSmt();
                        $bilan->setAnneeFinanciere($annee);
                        $bilan->setRepertoire($this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]));
                        $bilan->setBrut(str_replace(",","",$request->get($key->getId()."brut")));
                        $bilan->setAmortPR(str_replace(",","",$request->get($key->getId()."ammo")));
                        $bilan->setNet1(str_replace(",","",$request->get($key->getId()."net1")));
                        $bilan->setNet2(str_replace(",","",$request->get($key->getId()."net2")));
                        $bilan->setRefCode($key->getId());
                        $bilan->setType("Actif");
                        $bilan->setSubmit($submit);
                        $bilan->setCreatedBy($this->getUser());
                        $bilan->setUpdatedBy($this->getUser());
                        $entityManager->persist($bilan);
                        $entityManager->flush();


                    }
                }
           }else{
                foreach ($refAgg as $key ) {
                    $bilan = new BilanSmt();
                    $bilan->setAnneeFinanciere($annee);
                    $bilan->setRepertoire($this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]));
                    $bilan->setBrut(str_replace(",","",$request->get($key->getId()."brut")));
                    $bilan->setAmortPR(str_replace(",","",$request->get($key->getId()."ammo")));
                    $bilan->setNet1(str_replace(",","",$request->get($key->getId()."net1")));
                    $bilan->setNet2(str_replace(",","",$request->get($key->getId()."net2")));
                    $bilan->setRefCode($key->getId());
                    $bilan->setType("Actif");
                    $bilan->setCreatedBy($this->getUser());
                    $bilan->setUpdatedBy($this->getUser());
                    $bilan->setSubmit($submit);

                    $entityManager->persist($bilan);
                    $entityManager->flush();
                }

           }

           return $this->redirectToRoute('app_bilan_smt_new', ["routpassif"=>$routpassif], Response::HTTP_SEE_OTHER);
        }


        if($request->get('anneePassif')){
           $codeCuci=$request->get('codecuciPassif');
           $type=$request->get('typePassif');
           $annee=$request->get('anneePassif');

           if($request->get('submitedPassif')){
             $submit=true;
            
            }else{
              $submit=false; 
            }

               

            $bn=$this->getDoctrine()->getRepository(BilanSmt::class)->findByCodeCuci($codeCuci,$annee,"Passif");
            
            $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]);

           if(count($bn)>1){
               foreach ($refAggPassif as $key ) {
                 
                  $bilan =$this->getDoctrine()->getRepository(BilanSmt::class)->findOneBy(["repertoire"=>$repertoire,"anneeFinanciere"=>$annee,"type"=>"Passif","refCode"=>$key->getId()]);

                 
                  if($bilan){

                      $bilan->setAnneeFinanciere($annee);
                      $bilan->setRepertoire($repertoire);
                      $bilan->setNet1(str_replace(",","",$request->get($key->getId()."PassifNet1")));
                      $bilan->setNet2(str_replace(",","",$request->get($key->getId()."PassifNet2")));
                      $bilan->setRefCode($key->getId());
                      $bilan->setType("Passif");
                      $bilan->setSubmit($submit);
                      $bilan->setUpdatedBy($this->getUser());
                      $entityManager->flush();
                  }
                else{

                      $bilan = new BilanSmt();

                      $bilan->setAnneeFinanciere($annee);

                      $bilan->setRepertoire($this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]));
                      $bilan->setNet1($request->get($key->getId()."PassifNet1"));
                      $bilan->setNet2($request->get($key->getId()."PassifNet2"));
                      $bilan->setRefCode($key->getId());
                      $bilan->setType("Passif");
                      $bilan->setCreatedBy($this->getUser());
                      $bilan->setUpdatedBy($this->getUser());
                      $bilan->setSubmit($submit);

                      $entityManager->persist($bilan);
                      $entityManager->flush();


                }
                }
           }else{

                 foreach ($refAggPassif as $key ) {
                 
                  $bilan = new BilanSmt();

                  $bilan->setAnneeFinanciere($annee);

                  $bilan->setRepertoire($this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]));
                 
                  $bilan->setNet1($request->get($key->getId()."PassifNet1"));
                  $bilan->setNet2($request->get($key->getId()."PassifNet2"));
                  $bilan->setRefCode($key->getId());
                  $bilan->setType("Passif");
                  $bilan->setCreatedBy($this->getUser());
                  $bilan->setUpdatedBy($this->getUser());
                  $bilan->setSubmit($submit);

                  $entityManager->persist($bilan);
                  $entityManager->flush();
                }

           }

            return $this->redirectToRoute('app_comptederesultat_smt_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bilan_smt/new.html.twig', [
            "refAgg"=>$refAgg,
            "refAggPassif"=>$refAggPassif
        ]);
    }

    /**
     * @Route("/{id}", name="app_bilan_smt_show", methods={"GET"})
     */
    public function show(BilanSmt $bilanSmt): Response
    {
        return $this->render('bilan_smt/show.html.twig', [
            'bilan_smt' => $bilanSmt,
        ]);
    }

     /**
     * @Route("/smtbilanjson/{annee}", name="smtbilansjson", methods={"GET","POST"})
     */
    public function bilanjson( $annee="")
    {
        $tab=[];
        $tab1=[];
        $tab2=[];
        $tab3=[];
        $tab4=[];


        $tabPassif=[];
        $tabPassif1=[];
        $tabPassif2=[];
       
        
        



        $session=new Session();
        $codeCuci= $session->get('codeCuci');


        $session->set('annee',$annee);
        
        $bilan=$this->getDoctrine()->getRepository(BilanSmt::class)->findByCodeCuci($codeCuci,$annee,"Actif");
        $bilanPassif=$this->getDoctrine()->getRepository(BilanSmt::class)->findByCodeCuci($codeCuci,$annee,"Passif");


        $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]);

        $refAggPassif=$this->getDoctrine()->getRepository(RefAggSmt::class)->findBy(["category"=>9,"TypeBilan"=>2],  array('ordre' => 'ASC'));

        $refAgg=$this->getDoctrine()->getRepository(RefAggSmt::class)->findBy(["category"=>9,"TypeBilan"=>1],  array('ordre' => 'ASC'));

        
        $brutTotal=0;
        $amortTotal=0;
        $net1Total=0;
        $net2Total=0;
        $passifnet1=0;
        $passifnet2=0;
        if($bilanPassif){

            foreach ($bilanPassif as $key ) {
              

                $bln =$this->getDoctrine()->getRepository(BilanSmt::class)->findOneBy(["repertoire"=>$repertoire,"anneeFinanciere"=>$annee-1,"type"=>"Passif","refCode"=>$key->getRefCode()]);
                if($bln){
                    if($key->getNet1()!="")
                    
                    { $net1=number_format(str_replace(",","",$key->getNet1()));
                        $passifnet1=$passifnet1+ str_replace(",","",$bln->getNet1());
                    }
                    else $net1="";
                    if($key->getNet2()==""){
                        if($bln->getNet1())
                            {$net2=number_format(str_replace(",","",$bln->getNet1()));
                                $passifnet2=$passifnet2+str_replace(",","",$bln->getNet1());
                            }
                        else $net2="";
                    }else{
                      $net2=number_format(str_replace(",","",$key->getNet2()));
                      $passifnet2=$passifnet2+str_replace(",","",$key->getNet2());
                    }

                    $tabPassif1[$key->getRefCode()]=[$key->getRefCode(),$net1,$net2];
                    }
                else{
                    if($key->getNet1()){
                       
                       $net1=number_format(str_replace(",","",$key->getNet1()));
                       $passifnet1=$passifnet1 + str_replace(",","",$key->getNet1());
                    }
                    else $net1="";
                    if($key->getNet2()!=""){
                       $net2=number_format(str_replace(",","",$key->getNet2()));
                       $passifnet2=$passifnet2+ str_replace(",","",$key->getNet2());
                    }
                    else $net2="";
                    $tabPassif1[$key->getRefCode()]=[$key->getRefCode(),$net1,$net2];
                    } 
            }
        }
        else{
            foreach ($refAggPassif as $key ) {
                $bln =$this->getDoctrine()->getRepository(BilanSmt::class)->findOneBy(["repertoire"=>$repertoire,"anneeFinanciere"=>$annee-1,"type"=>"Passif","refCode"=>$key->getId()]);
                if($bln){
                    if($bln->getNet1()!=""){
                        $net1=number_format(str_replace(",","",$bln->getNet1()));
                        $passifnet1=$passifnet1+ str_replace(",","",$bln->getNet1());
                    }
                    else $net1="";
                    $tabPassif1[$key->getId()]=[$key->getId(),"",$net1];
                }
                else
                    $tabPassif1[$key->getId()]=[$key->getId(),"",""];
            }  
        }
       
        $charger=0;

        if($bilan){
            $charger=1;
            foreach ($bilan as $key ) {

                $bln =$this->getDoctrine()->getRepository(BilanSmt::class)->findOneBy(["repertoire"=>$repertoire,"anneeFinanciere"=>$annee-1,"type"=>"Actif","refCode"=>$key->getRefCode()]);
                
                
                    if($key->getBrut()!=""){
                        $brut=number_format(str_replace(",","",$key->getBrut()));
                        $brutTotal=$brutTotal+ str_replace(",","",$key->getBrut());
                    }
                    else $brut="";
                    if($key->getAmortPR()!=""){
                     $amortpr=number_format(str_replace(",","",$key->getAmortPR()));
                     $amortTotal= $amortTotal+str_replace(",","",$key->getAmortPR());
                    }
                    else $amortpr="";
                    if($key->getNet1()!=""){
                        $net1=number_format(str_replace(",","",$key->getNet1()));
                        $net1Total= $net1Total+str_replace(",","",$key->getNet1());
                    }
                    else $net1="";
                    if($key->getNet2()!=""){
                        $net2=number_format(str_replace(",","",$key->getNet2()));
                        $net2Total= $net2Total+str_replace(",","",$key->getNet2());
                    }
                    else $net2="";
                        $tab1[$key->getRefCode()]=[$key->getRefCode(),$brut,$amortpr,$net1,$net2];
                
            }
        }else{
            foreach ($refAgg as $key ) {

                $bln =$this->getDoctrine()->getRepository(BilanSmt::class)->findOneBy(["repertoire"=>$repertoire,"anneeFinanciere"=>$annee-1,"type"=>"Actif","refCode"=>$key->getId()]);
                
                if($bln){
                    if($bln->getNet1()!=""){
                     $net2=number_format(str_replace(",","",$bln->getNet1()));
                     $net2Total= $net2Total+str_replace(",","",$bln->getNet1());
                    }
                    else $net2="";
                $tab1[$key->getId()]=[$key->getId(),"","","",$net2];
                }
                else
                    $tab1[$key->getId()]=[$key->getId(),"","","",""];
            }
           
        } 

        if($brutTotal==0)
          array_push($tab4,"");
        else
          array_push($tab4,number_format($brutTotal));


        if($amortTotal==0)
          array_push($tab4,"");
        else
          array_push($tab4,number_format($amortTotal));
        
        if($net1Total==0)
          array_push($tab4,"");
        else
        array_push($tab4,number_format($net1Total));

        if($net2Total==0)
         array_push($tab4,"");
        else
         array_push($tab4,number_format($net2Total));
        
        if($passifnet1==0)
         array_push($tab4,"");
        else
        array_push($tab4,number_format($passifnet1));

       if($passifnet2==0)
        array_push($tab4,"");
       else
        array_push($tab4,number_format($passifnet2));


       
        foreach ($refAggPassif as $key ) {

             array_push($tabPassif2,[$key->getId(),$key->getLibelle()]);
        }



        foreach ($refAgg as $key ) {

             array_push($tab2,[$key->getId(),$key->getLibelle()]);
        } 


        


         array_push($tab,$tab1);
         array_push($tab,$tab2);
       

         array_push($tabPassif,$tabPassif1);
         array_push($tabPassif,$tabPassif2);


         $arr=[];


         array_push($arr,$tab);
         array_push($arr,$tabPassif);
         array_push($arr,$codeCuci);
         array_push($arr,$charger);
         array_push($arr,$tab4);
       
    
              
        return new JsonResponse( $arr);
    }

    /**
     * @Route("/{id}/edit", name="app_bilan_smt_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, BilanSmt $bilanSmt, BilanSmtRepository $bilanSmtRepository): Response
    {
        $form = $this->createForm(BilanSmtType::class, $bilanSmt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bilanSmtRepository->add($bilanSmt);
            return $this->redirectToRoute('app_bilan_smt_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bilan_smt/edit.html.twig', [
            'bilan_smt' => $bilanSmt,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_bilan_smt_delete", methods={"POST"})
     */
    public function delete(Request $request, BilanSmt $bilanSmt, BilanSmtRepository $bilanSmtRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bilanSmt->getId(), $request->request->get('_token'))) {
            $bilanSmtRepository->remove($bilanSmt);
        }

        return $this->redirectToRoute('app_bilan_smt_index', [], Response::HTTP_SEE_OTHER);
    }
}
