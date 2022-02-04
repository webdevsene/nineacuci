<?php

namespace App\Controller;

use App\Entity\Repertoire;
use App\Entity\TypeNINEA;
use App\Form\RepertoireType;
use App\Form\RepertoireShowType;
use App\Repository\RepertoireRepository;
use App\Repository\TypeNINEARepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\SYSCOA;
use App\Entity\NAEMA;
use App\Entity\NAEMAS;
use App\Entity\Citi;
use App\Entity\Activities;
use App\Entity\QVH;
use App\Entity\Control;
use App\Entity\Region;
use App\Entity\CategorySyscoa;
use App\Entity\CategoryNaema;
use App\Entity\CategoryNaemas;
use App\Entity\CategoryCiti;
use App\Entity\SequenceNumeroCUCI;
use App\Repository\SYSCOARepository;
use Symfony\Component\Uid\Uuid;

/**
 * @Route("/repertoire")
 */
class RepertoireController extends AbstractController
{



    public function genererNumeroCUCI($sequence){

        $code=[9=>"I",19=>"S",6=>"F",16=>"P",3=>"C",13=>"M",0=>"W",10=>"J",20=>"T",7=>"G",17=>"Q",4=>"D",14=>"N",1=>"A",11=>"K",21=>"U",8=>"H"
            ,18=>"R",5=>"E",15=>"O",2=>"B",12=>"L",22=>"V"];

        $numero="";

        if($sequence<10){

            $numero="0000".($sequence*10).$code[($sequence*10) % 23];
        }else
          if ($sequence>=10  && $sequence<100) {
              $numero="000".($sequence*10).$code[($sequence*10) % 23];
          }
           else
              if ($sequence>=100  && $sequence<1000) {
                  $numero="00".($sequence*10).$code[($sequence*10) % 23];
              }
              else
                  if ($sequence>=1000  && $sequence<10000) {
                      $numero="0".($sequence*10).$code[($sequence*10) % 23];
                  }
                  else
                      if ($sequence>=10000 ) {
                          $numero=($sequence*10).$code[($sequence*10) % 23];
                      }

        return $numero;
    }




    /**
     * @Route("/", name="repertoire_index", methods={"GET"})
     */
    public function index(RepertoireRepository $repertoireRepository): Response
    {
        return $this->render('repertoire/index.html.twig', [
            'repertoires' => $repertoireRepository->findBy(array('deleted'=>true)),
        ]);
    }


     /**
     * @Route("/corbeille/", name="repertoire_corbeille", methods={"GET"})
     */
    public function corbeille(RepertoireRepository $repertoireRepository): Response
    {
        return $this->render('repertoire/corbeille.html.twig', [
            'repertoires' => $repertoireRepository->findBy(array('deleted'=>false)),
        ]);
    }

    /**
     * @Route("/new", name="repertoire_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        
        $repertoire = new Repertoire();
        $sequenceNumeroCUCI=new SequenceNumeroCUCI();

        $repertoire->setTypeNINEA($entityManager->getRepository(TypeNINEA::class)->find(1));
        $syscoa=$entityManager->getRepository(SYSCOA::class)->findAll();
        $naema=$entityManager->getRepository(NAEMA::class)->findAll();
        $naemas=$entityManager->getRepository(NAEMAS::class)->findAll();
        $citi=$entityManager->getRepository(Citi::class)->findAll();
        $regions=$entityManager->getRepository(Region::class)->findAll();
        $categorySyscoa=$entityManager->getRepository(CategorySyscoa::class)->findAll();
        $categoryNaema=$entityManager->getRepository(CategoryNaema::class)->findAll();
        $categoryNaemas=$entityManager->getRepository(CategoryNaemas::class)->findAll();
        $categoryCiti=$entityManager->getRepository(CategoryCiti::class)->findAll();
        $form = $this->createForm(RepertoireType::class, $repertoire,[ "syscoa"=>$syscoa,"naema"=>$naema,"naemas"=>$naemas,"citi"=>$citi]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $i=1;
            while($i<=$request->get('taille')){
             if ($request->get('libelle'.$i)) {
            
               $activities= new Activities(); 

                $activities->setChiffreAffaire($request->get('chiffreAffaire'.$i)) ;
                $activities->setPourcentage($request->get('pourcentage'.$i)) ;
                $activities->setActivitePrincipale($request->get('activitePrincipale'.$i)) ;
                $activities->setValeurAjoutee($request->get('valeurAjouter'.$i)); 
                $activities->setLibelleActivitePrincipale($request->get('libelle'.$i)) ;
                $activities->setRepertoire($repertoire) ;

                if($request->get('syscoa'.$i)){
                $syscoa=$entityManager->getRepository(SYSCOA::class)->find($request->get('syscoa'.$i));
                $activities->setSYSCOA($syscoa); 
                }

                
                if($request->get('naema'.$i)){
                 $naema=$entityManager->getRepository(NAEMA::class)->find($request->get('naema'.$i)); 
                 $activities->setNAEMA($naema);  
                }

                if($request->get('naemas'.$i)){
                 $naemas=$entityManager->getRepository(NAEMAS::class)->find($request->get('naemas'.$i)); 
                 $activities->setNAEMAS($naemas);  
                }


                if($request->get('citi'.$i)){
                 $citi=$entityManager->getRepository(CITI::class)->find($request->get('citi'.$i)); 
                 $activities->setCITI($citi);  
                }

                 $entityManager->persist($activities);
             }
                
               
                
                $i++;

            }
            $last_insert=$entityManager->getRepository(SequenceNumeroCUCI::class)->findBy(array(),array('id'=>'desc'),1,0);

            if(count($last_insert)>0){
             $codeCUCI= $this->genererNumeroCUCI($last_insert[0]->getId()+1);
            }else
             $codeCUCI= $this->genererNumeroCUCI(1);
            
            if($request->get('qvh'))
                $qvh=$entityManager->getRepository(QVH::class)->find($request->get('qvh'));
            else{
                $request->getSession()->getFlashBag()->add('messageRepertoire'," le Quartier/Village/Hameau est obligatoire");
                return $this->redirectToRoute('repertoire_new');
            }


            if($request->get('naema')){
                $naema=$entityManager->getRepository(NAEMA::class)->find($request->get('naema'));  
            }
            else{
                $request->getSession()->getFlashBag()->add('messageRepertoire'," le naema est obligatoire");
                return $this->redirectToRoute('repertoire_new');
            }


            if($request->get('naemas'))
                $naemas=$entityManager->getRepository(NAEMAS::class)->find($request->get('naemas'));
            else{
                $request->getSession()->getFlashBag()->add('messageRepertoire'," le naemas est obligatoire");
                return $this->redirectToRoute('repertoire_new');
            }

            
            if($request->get('citi'))
                $citi=$entityManager->getRepository(Citi::class)->find($request->get('citi'));
            else{
                $request->getSession()->getFlashBag()->add('messageRepertoire'," le citi est obligatoire");
                return $this->redirectToRoute('repertoire_new');
            }



            if($request->get('syscoa'))
                $syscoa=$entityManager->getRepository(SYSCOA::class)->find($request->get('syscoa'));
            else{
                $request->getSession()->getFlashBag()->add('messageRepertoire'," le syscoa est obligatoire");
                return $this->redirectToRoute('repertoire_new');
            }

            $repertoire->setCodeCuci($codeCUCI);

            $repertoire->setQvh($qvh);
            $repertoire->setNAEMA($naema);
            $repertoire->setNAEMAS($naemas);
            $repertoire->setCITI($citi);
            $repertoire->setSYSCOA($syscoa);
            $repertoire->setCreatedBy($this->getUser());
            $repertoire->setUpdatedBy($this->getUser());

            
            $entityManager->persist($sequenceNumeroCUCI);
            $entityManager->persist($repertoire);
            $entityManager->flush();

            foreach ($repertoire->getCommissairesComptes() as $key) {
               
                if( $key->getNom()==null && $key->getPrenom()==null){
                    $entityManager->remove($key);
                   
                }
               
            }


            foreach ($repertoire->getDirigeants() as $key) {
               
                if( $key->getNom()=="" && $key->getPrenom()==""){
                    $entityManager->remove($key);
                }
               
            }


            foreach ($repertoire->getMembreConseils() as $key) {
               
                if( $key->getNom()=="" && $key->getPrenom()==""){
                    $entityManager->remove($key);
                }
               
            }

             foreach ($repertoire->getFiliales() as $key) {
               
                if( $key->getDesignation()=="" ){
                    $entityManager->remove($key);
                }
               
            }
            


           
            $entityManager->flush();

            return $this->redirectToRoute('repertoire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('repertoire/new.html.twig', [
            'repertoire' => $repertoire,
            'form' => $form,
            'categorySyscoa'=>$categorySyscoa,
            'categoryNaema'=>$categoryNaema,
            'categoryCiti'=>$categoryCiti,
            'categoryNaemas'=>$categoryNaemas,
            'regions' => $regions,
        ]);
    }

    /**
     * @Route("/{id}", name="repertoire_show", methods={"GET", "POST"})
     */
    public function show(Request $request,Repertoire $repertoire, EntityManagerInterface $entityManager): Response
    {

       $syscoa=$entityManager->getRepository(SYSCOA::class)->findAll();
        $naema=$entityManager->getRepository(NAEMA::class)->findAll();
        $naemas=$entityManager->getRepository(NAEMAS::class)->findAll();
        $citi=$entityManager->getRepository(Citi::class)->findAll();
        $regions=$entityManager->getRepository(Region::class)->findAll();
        $form = $this->createForm(RepertoireShowType::class, $repertoire,[ "syscoa"=>$syscoa,"naema"=>$naema,"naemas"=>$naemas,"citi"=>$citi]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if($request->get('qvh'))
                $qvh=$entityManager->getRepository(QVH::class)->find($request->get('qvh'));
            else{
                $request->getSession()->getFlashBag()->add('messageRepertoire'," le Quartier/Village/Hameau est obligatoire");
               
                return $this->redirectToRoute('repertoire_edit', ['id'=>$repertoire->getId()], Response::HTTP_SEE_OTHER);
            }

         

            $repertoire->setQvh($qvh);
            $entityManager->flush();

            return $this->redirectToRoute('repertoire_index', [], Response::HTTP_SEE_OTHER);
        }

         $regions=$entityManager->getRepository(Region::class)->findAll();
          $categorySyscoa=$entityManager->getRepository(CategorySyscoa::class)->findAll();
        $categoryNaema=$entityManager->getRepository(CategoryNaema::class)->findAll();
        $categoryNaemas=$entityManager->getRepository(CategoryNaemas::class)->findAll();
        $categoryCiti=$entityManager->getRepository(CategoryCiti::class)->findAll();

        return $this->renderForm('repertoire/show.html.twig', [
            'repertoire' => $repertoire,
            'form' => $form,
            'regions' => $regions,
             'categorySyscoa'=>$categorySyscoa,
            'categoryNaema'=>$categoryNaema,
            'categoryCiti'=>$categoryCiti,
            'categoryNaemas'=>$categoryNaemas,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="repertoire_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Repertoire $repertoire, EntityManagerInterface $entityManager): Response
    {
        

        $syscoa=$entityManager->getRepository(SYSCOA::class)->findAll();
        $naema=$entityManager->getRepository(NAEMA::class)->findAll();
        $naemas=$entityManager->getRepository(NAEMAS::class)->findAll();
        $citi=$entityManager->getRepository(Citi::class)->findAll();
        $regions=$entityManager->getRepository(Region::class)->findAll();
        $form = $this->createForm(RepertoireType::class, $repertoire,[ "syscoa"=>$syscoa,"naema"=>$naema,"naemas"=>$naemas,"citi"=>$citi]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if($request->get('qvh'))
                $qvh=$entityManager->getRepository(QVH::class)->find($request->get('qvh'));
            else{
                $request->getSession()->getFlashBag()->add('messageRepertoire'," le Quartier/Village/Hameau est obligatoire");
               
                return $this->redirectToRoute('repertoire_edit', ['id'=>$repertoire->getId()], Response::HTTP_SEE_OTHER);
            }

         

            $repertoire->setQvh($qvh);
            $entityManager->flush();

            return $this->redirectToRoute('repertoire_index', [], Response::HTTP_SEE_OTHER);
        }

         $regions=$entityManager->getRepository(Region::class)->findAll();

        $categorySyscoa=$entityManager->getRepository(CategorySyscoa::class)->findAll();
        $categoryNaema=$entityManager->getRepository(CategoryNaema::class)->findAll();
        $categoryNaemas=$entityManager->getRepository(CategoryNaemas::class)->findAll();
        $categoryCiti=$entityManager->getRepository(CategoryCiti::class)->findAll();

        return $this->renderForm('repertoire/edit.html.twig', [
            'repertoire' => $repertoire,
            'form' => $form,
            'regions' => $regions,
            'categorySyscoa'=>$categorySyscoa,
            'categoryNaema'=>$categoryNaema,
            'categoryCiti'=>$categoryCiti,
            'categoryNaemas'=>$categoryNaemas,
        ]);
    }
    


    /**
     * @Route("/restaurer/{id}", name="repertoire_restaurer", methods={"GET","POST"})
     */
    public function restaurer(Request $request, Repertoire $repertoire, EntityManagerInterface $entityManager): Response
    {
       
        $request->getSession()->getFlashBag()->add('message',"la restauration a été activé avec succés");
        $repertoire->setDeleted(true);
        $entityManager->flush();
      

        return $this->redirectToRoute('repertoire_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/delete/{id}", name="repertoire_delete", methods={"GET","POST"})
     */
    public function delete(Request $request, Repertoire $repertoire, EntityManagerInterface $entityManager): Response
    {
       
        $request->getSession()->getFlashBag()->add('message',"l'oppération a été activé avec succés");
        $repertoire->setDeleted(false);
        $entityManager->flush();
      

        return $this->redirectToRoute('repertoire_index', [], Response::HTTP_SEE_OTHER);
    }
}
