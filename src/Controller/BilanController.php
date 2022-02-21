<?php

namespace App\Controller;

use App\Entity\Bilan;
use App\Entity\RefAgg;
use App\Entity\Repertoire;
use App\Form\BilanType;
use App\Repository\BilanRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * @Route("/bilan")
 */
class BilanController extends AbstractController
{
    /**
     * @Route("/", name="bilan_index", methods={"GET"})
     */
    public function index(BilanRepository $bilanRepository): Response
    {
        return $this->render('bilan/index.html.twig', [
            'bilans' => $bilanRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="bilan_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        
       $refAgg=$this->getDoctrine()->getRepository(RefAgg::class)->findBy(["category"=>1,"typeBilan"=>1]);
       $refAggPassif=$this->getDoctrine()->getRepository(RefAgg::class)->findBy(["category"=>1,"typeBilan"=>2]);



        if($request->get('annee')){
           
           $codeCuci=$request->get('codecuci');
           $type=$request->get('type');
           $annee=$request->get('annee');




          
            

            $bn=$this->getDoctrine()->getRepository(Bilan::class)->findByCodeCuci($codeCuci,$annee,"Actif");

             $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]);
           if(count($bn)>1){
               foreach ($refAgg as $key ) {
                 
                  $bilan =$this->getDoctrine()->getRepository(Bilan::class)->findOneBy(["repertoire"=>$repertoire,"anneeFinanciere"=>$annee,"type"=>"Actif","refCode"=>$key->getCode()]);

                 
                  if($bilan){

                      $bilan->setAnneeFinanciere($annee);

                      $bilan->setRepertoire($repertoire);
                      $bilan->setBrut($request->get($key->getCode()."brut"));
                      $bilan->setAmortPR($request->get($key->getCode()."ammo"));
                      $bilan->setNet1($request->get($key->getCode()."net1"));
                      $bilan->setNet2($request->get($key->getCode()."net2"));
                      $bilan->setRefCode($key->getCode());
                      $bilan->setType("Actif");
                     
                      $bilan->setModifiedBy($this->getUser());
                     
                      $entityManager->flush();
                  }
                else{

                      $bilan = new Bilan();

                      $bilan->setAnneeFinanciere($annee);

                      $bilan->setRepertoire($this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]));
                      $bilan->setBrut($request->get($key->getCode()."brut"));
                      $bilan->setAmortPR($request->get($key->getCode()."ammo"));
                      $bilan->setNet1($request->get($key->getCode()."net1"));
                      $bilan->setNet2($request->get($key->getCode()."net2"));
                      $bilan->setRefCode($key->getCode());
                      $bilan->setType("Actif");
                      $bilan->setCreatedBy($this->getUser());
                      $bilan->setModifiedBy($this->getUser());
                      $entityManager->persist($bilan);
                      $entityManager->flush();


                }
                }
           }else{

                 foreach ($refAgg as $key ) {
                 
                  $bilan = new Bilan();

                  $bilan->setAnneeFinanciere($annee);

                  $bilan->setRepertoire($this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]));
                  $bilan->setBrut($request->get($key->getCode()."brut"));
                  $bilan->setAmortPR($request->get($key->getCode()."ammo"));
                  $bilan->setNet1($request->get($key->getCode()."net1"));
                  $bilan->setNet2($request->get($key->getCode()."net2"));
                  $bilan->setRefCode($key->getCode());
                  $bilan->setType("Actif");
                  $bilan->setCreatedBy($this->getUser());
                  $bilan->setModifiedBy($this->getUser());
                  $entityManager->persist($bilan);
                  $entityManager->flush();
                }

           }

           return $this->redirectToRoute('bilan_new', [], Response::HTTP_SEE_OTHER);
        }


        if($request->get('anneePassif')){

           
          
           $codeCuci=$request->get('codecuciPassif');
           $type=$request->get('typePassif');
           $annee=$request->get('anneePassif');


          
            

            $bn=$this->getDoctrine()->getRepository(Bilan::class)->findByCodeCuci($codeCuci,$annee,"Passif");
            $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]);

           if(count($bn)>1){
               foreach ($refAggPassif as $key ) {
                 
                  $bilan =$this->getDoctrine()->getRepository(Bilan::class)->findOneBy(["repertoire"=>$repertoire,"anneeFinanciere"=>$annee,"type"=>"Passif","refCode"=>$key->getCode()]);

                 
                  if($bilan){

                      $bilan->setAnneeFinanciere($annee);

                      $bilan->setRepertoire($repertoire);
                     
                      $bilan->setNet1($request->get($key->getCode()."PassifNet1"));
                      $bilan->setNet2($request->get($key->getCode()."PassifNet2"));
                      $bilan->setRefCode($key->getCode());
                      $bilan->setType("Passif");
                     
                      $bilan->setModifiedBy($this->getUser());
                     
                      $entityManager->flush();
                  }
                else{

                      $bilan = new Bilan();

                      $bilan->setAnneeFinanciere($annee);

                      $bilan->setRepertoire($this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]));
                      $bilan->setNet1($request->get($key->getCode()."PassifNet1"));
                      $bilan->setNet2($request->get($key->getCode()."PassifNet2"));
                      $bilan->setRefCode($key->getCode());
                      $bilan->setType("Passif");
                      $bilan->setCreatedBy($this->getUser());
                      $bilan->setModifiedBy($this->getUser());
                      $entityManager->persist($bilan);
                      $entityManager->flush();


                }
                }
           }else{

                 foreach ($refAggPassif as $key ) {
                 
                  $bilan = new Bilan();

                  $bilan->setAnneeFinanciere($annee);

                  $bilan->setRepertoire($this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]));
                 
                  $bilan->setNet1($request->get($key->getCode()."PassifNet1"));
                  $bilan->setNet2($request->get($key->getCode()."PassifNet2"));
                  $bilan->setRefCode($key->getCode());
                  $bilan->setType("Passif");
                  $bilan->setCreatedBy($this->getUser());
                  $bilan->setModifiedBy($this->getUser());
                  $entityManager->persist($bilan);
                  $entityManager->flush();
                }

           }

            return $this->redirectToRoute('bilan_new', [], Response::HTTP_SEE_OTHER);
        }
       


        return $this->renderForm('bilan/new.html.twig', [
            "refAgg"=>$refAgg,
            "refAggPassif"=>$refAggPassif
        ]);
    }


     /**
     * @Route("/nineaNum/{id}", name="nineaNum", methods={"GET"})
     */
    public function nineaNum( $id="")
    {
        $tab=[];
        $rep=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$id]);
        $session=new Session();
       // $session->start();
        $session->set('codeCuci',$id);

    
              
        return new JsonResponse( $rep->getDenominationSocial());
    }


      /**
     * @Route("/bilanjson/{annee}", name="bilansjson", methods={"GET","POST"})
     */
    public function bilanjson( $annee="")
    {
        $tab=[];
        $tab1=[];
        $tab2=[];
        $tab3=[];


        $tabPassif=[];
        $tabPassif1=[];
        $tabPassif2=[];



        $session=new Session();
        $codeCuci= $session->get('codeCuci');


        $session->set('annee',$annee);
        
        $bilan=$this->getDoctrine()->getRepository(Bilan::class)->findByCodeCuci($codeCuci,$annee,"Actif");
        $bilanPassif=$this->getDoctrine()->getRepository(Bilan::class)->findByCodeCuci($codeCuci,$annee,"Passif");


        $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]);


        foreach ($bilanPassif as $key ) {
              

               $bln =$this->getDoctrine()->getRepository(Bilan::class)->findOneBy(["repertoire"=>$repertoire,"anneeFinanciere"=>$annee-1,"type"=>"Passif","refCode"=>$key->getRefCode()]);
              if($bln)
              $tabPassif1[$key->getRefCode()]=[$key->getRefCode(),$key->getNet1(),$bln->getNet1()];
              else
                $tabPassif1[$key->getRefCode()]=[$key->getRefCode(),$key->getNet1(),$key->getNet2()];
         } 


        
        foreach ($bilan as $key ) {

              $bln =$this->getDoctrine()->getRepository(Bilan::class)->findOneBy(["repertoire"=>$repertoire,"anneeFinanciere"=>$annee-1,"type"=>"Actif","refCode"=>$key->getRefCode()]);
              if($bln)
              $tab1[$key->getRefCode()]=[$key->getRefCode(),$key->getBrut(),$key->getAmortPR(),$key->getNet1(),$bln->getNet1()];
              else
                 $tab1[$key->getRefCode()]=[$key->getRefCode(),$key->getBrut(),$key->getAmortPR(),$key->getNet1(),$key->getNet2()];
        } 


        $refAggPassif=$this->getDoctrine()->getRepository(RefAgg::class)->findBy(["category"=>1,"typeBilan"=>2],  array('code' => 'ASC'));

        $refAgg=$this->getDoctrine()->getRepository(RefAgg::class)->findBy(["category"=>1,"typeBilan"=>1,"surlignee"=>0],  array('id' => 'ASC'));

        $refAggParent=$this->getDoctrine()->getRepository(RefAgg::class)->findBy(["category"=>1,"typeBilan"=>1,"surlignee"=>1],array('code' => 'ASC'));

        foreach ($refAggPassif as $key ) {

             array_push($tabPassif2,[$key->getCode(),$key->getLibelle(),$key->getParent(),$key->getOrdre(),$key->getSurlignee()]);
        }



        foreach ($refAgg as $key ) {

             array_push($tab2,[$key->getCode(),$key->getLibelle(),$key->getParent(),$key->getOrdre(),$key->getSurlignee()]);
        } 


        foreach ($refAggParent as $key ) {

             array_push($tab3,[$key->getCode(),$key->getLibelle(),$key->getParent(),$key->getOrdre(),$key->getSurlignee()]);
        } 


         array_push($tab,$tab1);
         array_push($tab,$tab2);
         array_push($tab,$tab3);

         array_push($tabPassif,$tabPassif1);
         array_push($tabPassif,$tabPassif2);


         $arr=[];


         array_push($arr,$tab);
         array_push($arr,$tabPassif);
       
    
              
        return new JsonResponse( $arr);
    }

    /**
     * @Route("/{id}", name="bilan_show", methods={"GET"})
     */
    public function show(Bilan $bilan): Response
    {
        return $this->render('bilan/show.html.twig', [
            'bilan' => $bilan,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="bilan_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Bilan $bilan, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BilanType::class, $bilan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('bilan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bilan/edit.html.twig', [
            'bilan' => $bilan,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="bilan_delete", methods={"POST"})
     */
    public function delete(Request $request, Bilan $bilan, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bilan->getId(), $request->request->get('_token'))) {
            $entityManager->remove($bilan);
            $entityManager->flush();
        }

        return $this->redirectToRoute('bilan_index', [], Response::HTTP_SEE_OTHER);
    }
}
