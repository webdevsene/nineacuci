<?php

namespace App\Controller;

use App\Entity\CuciImmoPlus;
use App\Entity\Repertoire;
use App\Form\CuciImmoPlusType;
use App\Repository\CuciImmoPlusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\RefAgg;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/cuci/immo/plus")
 * @IsGranted("ROLE_USER")
 */
class CuciImmoPlusController extends AbstractController
{
    /**
     * @Route("/", name="cuci_immo_plus_index", methods={"GET"})
     */
    public function index(CuciImmoPlusRepository $cuciImmoPlusRepository): Response
    {
        return $this->render('cuci_immo_plus/index.html.twig', [
            'cuci_immo_pluses' => $cuciImmoPlusRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="cuci_immo_plus_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cuciImmoPlu = new CuciImmoPlus();
        $refAgg=$this->getDoctrine()->getRepository(RefAgg::class)->findBy(["category"=>5]);
        if($request->get('annee')){
           $codeCuci=$request->get('codecuci');
           $annee=$request->get('annee');
           if($request->get('submited')){
             $submit=true;
             $request->getSession()->getFlashBag()->add('notice', 'Immobilisation plus-value et moins-value a été sauvegardé et validé avec succès !');
            }else{
             $request->getSession()->getFlashBag()->add('notice', 'Immobilisation plus-value et moins-value a été sauvegardé  avec succès !');
                
             $submit=false; 
            }
           $immos=$this->getDoctrine()->getRepository(CuciImmoPlus::class)->findByCodeCuci($codeCuci,$annee);
           $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]);
           if(count($immos)>1){
               foreach ($refAgg as $key ) {
                  $immo =$this->getDoctrine()->getRepository(CuciImmoPlus::class)->findOneBy(["repertoire"=>$repertoire,"anneeFinanciere"=>$annee,"refCode"=>$key->getCode()]);
                  if($immo){
                      $immo->setAnneeFinanciere($annee);
                      $immo->setRefCode($key->getCode());
                      $immo->setSubmit($submit);
                      $immo->setRepertoire($repertoire);
                      $immo->setBrut(str_replace(",","",$request->get($key->getCode()."brut")));
                      $immo->setNet(str_replace(",","",$request->get($key->getCode()."net")));
                      $immo->setAmortPr(str_replace(",","",$request->get($key->getCode()."ammoPR")));
                      $immo->setValeur(str_replace(",","",$request->get($key->getCode()."valeur")));
                      $immo->setPrixCession(str_replace(",","",$request->get($key->getCode()."prix")));
                      $immo->setModifiedBy($this->getUser());
                      $immo->setUpdatedAt(new \DateTime());
                      
                      $entityManager->flush();
                  }
                else{
                      $immo = new CuciImmoPlus();
                      $immo->setSubmit($submit);
                      $immo->setAnneeFinanciere($annee);
                      $immo->setRefCode($key->getCode());
                      $immo->setRepertoire($repertoire);
                      $immo->setBrut(str_replace(",","",$request->get($key->getCode()."brut")));
                      $immo->setNet(str_replace(",","",$request->get($key->getCode()."net")));
                      $immo->setAmortPr(str_replace(",","",$request->get($key->getCode()."ammoPR")));
                      $immo->setValeur(str_replace(",","",$request->get($key->getCode()."valeur")));
                      $immo->setPrixCession(str_replace(",","",$request->get($key->getCode()."prix")));
                      $immo->setCreatedBy($this->getUser());
                      $immo->setModifiedby($this->getUser());
                      $immo->setUpdatedAt(new \DateTime());
                      $entityManager->persist($immo);
                      $entityManager->flush();
                }
                }
           }else{

                 foreach ($refAgg as $key ) {
                 
                  $immo = new CuciImmoPlus();
                  $immo->setAnneeFinanciere($annee);
                  $immo->setRefCode($key->getCode());
                  $immo->setSubmit($submit);
                  $immo->setRepertoire($repertoire);
                  $immo->setBrut(str_replace(",","",$request->get($key->getCode()."brut")));
                  $immo->setNet(str_replace(",","",$request->get($key->getCode()."net")));
                  $immo->setAmortPr(str_replace(",","",$request->get($key->getCode()."ammoPR")));
                  $immo->setValeur(str_replace(",","",$request->get($key->getCode()."valeur")));
                  $immo->setPrixCession(str_replace(",","",$request->get($key->getCode()."prix")));
                  $immo->setCreatedBy($this->getUser());
                  $immo->setModifiedby($this->getUser());
                  $immo->setUpdatedAt(new \DateTime());
                  $entityManager->persist($immo);
                  $entityManager->flush();
                }

           }

           return $this->redirectToRoute('app_effectifs_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cuci_immo_plus/new.html.twig', [
            'cuci_immo_plu' => $cuciImmoPlu,
          
        ]);
    }

    
      /**
     * @Route("/cuciimmoplus/{annee}", name="cuciimmoplus", methods={"GET","POST"})
     */
    public function cuciimmoplusjson( $annee="")
    {
        $tab=[];
        $tab1=[];
        $tab2=[];
        $tab3=[];


        $session=new Session();
        $codeCuci= $session->get('codeCuci');
        $session->set('annee',$annee);

        
        
        $cuciImmoPlus=$this->getDoctrine()->getRepository(CuciImmoPlus::class)->findByCodeCuci($codeCuci,$annee);
        
        $brut="";
        $amortPr="";
        $valeur="";
        $prixCession="";
        $net="";
        $netTotal=0;
        $brutTotal=0;
        $amortPrTotal=0;
        $valeurTotal=0;
        $prixCessionTotal=0;

        $tb=[];
        $refAgg=$this->getDoctrine()->getRepository(RefAgg::class)->findBy(["category"=>5],  array('ordre' => 'ASC'));

        foreach ($refAgg as $key ) {
            $tb[$key->getCode()]=$key->getSurlignee();
        } 
        foreach ($cuciImmoPlus as $key ) {
            $brut="";
            $amortPr="";
            $valeur="";
            $prixCession="";
            $net="";
            if($key->getBrut()!=""){  
                if(is_numeric(str_replace(" ","",str_replace(",","",$key->getBrut()))))   
                 $brut=number_format(str_replace(" ","",str_replace(",","",$key->getBrut())));
                 else
                 $brut=str_replace(" ","",str_replace(",","",$key->getBrut()));
              
               if( $tb[$key->getRefCode()])
                 $brutTotal=$brutTotal + str_replace(" ","",str_replace(",","",$key->getBrut()));
            }
            if($key->getAmortPr()){
                if( $tb[$key->getRefCode()])
                $amortPrTotal=$amortPrTotal+ str_replace(" ","",str_replace(",","",$key->getAmortPr()));  
                if(is_numeric(str_replace(" ","",str_replace(",","",$key->getAmortPr()))))   
                $amortPr=number_format(str_replace(" ","",str_replace(",","",$key->getAmortPr())));
                else
                $amortPr=str_replace(" ","",str_replace(",","",$key->getAmortPr()));
                 
            }
            if($key->getValeur()){
                if( $tb[$key->getRefCode()])
                $valeurTotal=$valeurTotal+ str_replace(" ","",str_replace(",","",$key->getValeur()));  
                if(is_numeric(str_replace(" ","",str_replace(",","",$key->getValeur()))))   
                $valeur=number_format(str_replace(" ","",str_replace(",","",$key->getValeur())));
                else
                $valeur=str_replace(" ","",str_replace(",","",$key->getValeur()));
            }
            if($key->getPrixCession()){
                if( $tb[$key->getRefCode()])
                $prixCessionTotal=$prixCessionTotal+ str_replace(" ","",str_replace(",","",$key->getPrixCession()));
                if(is_numeric(str_replace(",","",str_replace(" ","",$key->getPrixCession()))))     
                $prixCession=number_format(str_replace(",","",str_replace(" ","",$key->getPrixCession())));
                else
                $prixCession=str_replace(",","",str_replace(" ","",$key->getPrixCession()));
            }
            if($key->getNet()){
                if( $tb[$key->getRefCode()])
                $netTotal=$netTotal+ str_replace(" ","",str_replace(",","",$key->getNet()));
                if(is_numeric(str_replace(" ","",str_replace(",","",$key->getNet()))))     
                $net=number_format(str_replace(" ","",str_replace(",","",$key->getNet())));
                else
                $net=str_replace(" ","",str_replace(",","",$key->getNet()));
            }
            $tab1[$key->getRefCode()]=[$key->getRefCode(),$brut,$amortPr,$valeur,$prixCession,$net];
             
        } 
        $tab4=[];
        if($brutTotal!=0){
         if(is_numeric($brutTotal))
          array_push($tab4,number_format($brutTotal));
          else
          array_push($tab4,$brutTotal);}
        else
          array_push($tab4,"");

        if($amortPrTotal!=0){
         if(is_numeric($amortPrTotal))
          array_push($tab4,number_format($amortPrTotal));
          else
          array_push($tab4,$amortPrTotal);}
        else
          array_push($tab4,"");
        
        if($valeurTotal!=0){
         if(is_numeric($valeurTotal))
           array_push($tab4,number_format($valeurTotal));
         else
         array_push($tab4,$valeurTotal);
        }
        else
          array_push($tab4,"");
        
        if($prixCessionTotal!=0){
         if(is_numeric($prixCessionTotal))
         array_push($tab4,number_format($prixCessionTotal));
         else
         array_push($tab4,$prixCessionTotal);
        }
        else
         array_push($tab4,"");
        
        if($netTotal!=0){
            if(is_numeric($netTotal))
          array_push($tab4,number_format($netTotal));
          else
          array_push($tab4,$netTotal);
        }
        else
         array_push($tab4,"");

        
       
        
        
       
       


        $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]);



       

      

        foreach ($refAgg as $key ) {

             array_push($tab2,[$key->getCode(),$key->getLibelle(),$key->getParent(),$key->getOrdre(),$key->getSurlignee()]);
        } 


  
        array_push($tab,$tab2);
        array_push($tab,$tab1);
        array_push($tab,$tab4);
              
        return new JsonResponse( $tab);
    }

    /**
     * @Route("/{id}", name="cuci_immo_plus_show", methods={"GET"})
     */
    public function show(CuciImmoPlus $cuciImmoPlu): Response
    {
        return $this->render('cuci_immo_plus/show.html.twig', [
            'cuci_immo_plu' => $cuciImmoPlu,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cuci_immo_plus_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CuciImmoPlus $cuciImmoPlu, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CuciImmoPlusType::class, $cuciImmoPlu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('cuci_immo_plus_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cuci_immo_plus/edit.html.twig', [
            'cuci_immo_plu' => $cuciImmoPlu,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="cuci_immo_plus_delete", methods={"POST"})
     */
    public function delete(Request $request, CuciImmoPlus $cuciImmoPlu, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cuciImmoPlu->getId(), $request->request->get('_token'))) {
            $entityManager->remove($cuciImmoPlu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cuci_immo_plus_index', [], Response::HTTP_SEE_OTHER);
    }
}
