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

/**
 * @Route("/immo/brut")
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


           $immoBruts=$this->getDoctrine()->getRepository(ImmoBrut::class)->findByCodeCuci($codeCuci,$annee);

           $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]);
           if(count($immoBruts)>1){
               foreach ($refAgg as $key ) {
                  
                  $immobrut =$this->getDoctrine()->getRepository(ImmoBrut::class)->findOneBy(["repertoire"=>$repertoire,"anneeFinanciere"=>$annee,"refCode"=>$key->getCode()]);

                 
                  if($immobrut){



                      $immobrut->setAnneeFinanciere($annee);

                      $immobrut->setRefCode($key->getCode());

                      $immobrut->setRepertoire($repertoire);
                      $immobrut->setBrutA($request->get($key->getCode()."brutA"));
                      $immobrut->setAugmentationB3($request->get($key->getCode()."augmentationB3"));
                      $immobrut->setAugmentationB2($request->get($key->getCode()."augmentationB2"));
                      $immobrut->setAugmentationB1($request->get($key->getCode()."augmentationB1"));
                      $immobrut->setBrutD($request->get($key->getCode()."brutD"));
                      $immobrut->setDiminutionC1($request->get($key->getCode()."diminutionC1"));
                      $immobrut->setDiminutionC2($request->get($key->getCode()."diminutionC2"));
                     
                      $immobrut->setModifiedby($this->getUser());

                      
                     
                      $entityManager->flush();
                  }
                else{

                      $immobrut = new ImmoBrut();

                      $immobrut->setAnneeFinanciere($annee);

                      $immobrut->setRefCode($key->getCode());


                      $immobrut->setRepertoire($this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]));
                      $immobrut->setBrutA($request->get($key->getCode()."brutA"));
                      $immobrut->setAugmentationB3($request->get($key->getCode()."augmentationB3"));
                      $immobrut->setAugmentationB2($request->get($key->getCode()."augmentationB2"));
                      $immobrut->setAugmentationB1($request->get($key->getCode()."augmentationB1"));
                      $immobrut->setBrutD($request->get($key->getCode()."brutD"));
                      $immobrut->setDiminutionC1($request->get($key->getCode()."diminutionC1"));
                      $immobrut->setDiminutionC2($request->get($key->getCode()."diminutionC2"));
                      $immobrut->setCreatedby($this->getUser());
                      $immobrut->setModifiedby($this->getUser());
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
                   
                  $immobrut->setBrutA($request->get($key->getCode()."brutA"));
                  $immobrut->setAugmentationB3($request->get($key->getCode()."augmentationB3"));
                      $immobrut->setAugmentationB2($request->get($key->getCode()."augmentationB2"));
                      $immobrut->setAugmentationB1($request->get($key->getCode()."augmentationB1"));
                      $immobrut->setBrutD($request->get($key->getCode()."brutD"));
                      $immobrut->setDiminutionC1($request->get($key->getCode()."diminutionC1"));
                      $immobrut->setDiminutionC2($request->get($key->getCode()."diminutionC2"));
                  $immobrut->setCreatedby($this->getUser());
                  $immobrut->setModifiedby($this->getUser());
                  $entityManager->persist($immobrut);
                  $entityManager->flush();
                }

           }

           return $this->redirectToRoute('immo_brut_new', [], Response::HTTP_SEE_OTHER);
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
     * @Route("/nineaNumImmoBrut/{id}", name="nineaNumImmoBrut", methods={"GET"})
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


        $session=new Session();
        $codeCuci= $session->get('codeCuci');
        
        $immoBrut=$this->getDoctrine()->getRepository(ImmoBrut::class)->findByCodeCuci($codeCuci,$annee);
        


        foreach ($immoBrut as $key ) {

              
              $tab1[$key->getRefCode()]=[$key->getRefCode(),$key->getBrutA(),$key->getAugmentationB1(),$key->getAugmentationB2(),$key->getAugmentationB3(),$key->getDiminutionC1(),$key->getDiminutionC2(),$key->getBrutD()];
             
        } 
       


        $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]);


        $refAgg=$this->getDoctrine()->getRepository(RefAgg::class)->findBy(["category"=>4],  array('ordre' => 'ASC'));

       

      

        foreach ($refAgg as $key ) {

             array_push($tab2,[$key->getCode(),$key->getLibelle(),$key->getParent(),$key->getOrdre(),$key->getSurlignee()]);
        } 


  
        array_push($tab,$tab2);
        array_push($tab,$tab1);
              
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
