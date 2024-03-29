<?php

namespace App\Controller;

use App\Entity\Repertoire;
use App\Entity\TypeNINEA;
use App\Form\RepertoireType;
use App\Form\RepertoireShowType;
use App\Form\RepertoireEditType;
use App\Repository\RepertoireRepository;
use App\Repository\TypeNINEARepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\SYSCOA;
use App\Entity\NAEMA;
use App\Entity\RefNaemaNew;
use App\Entity\RefCategoryCitiNew;
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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;



/**
 * @Route("/repertoire")
 * @IsGranted("ROLE_USER")
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
     * @Route("/rechercheParNinea/{id}", name="rechercheParNinea", methods={"GET"})
     */
    public function rechercheParNinea( $id="")
    {
        
        $rep=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["ninea"=>$id]);
        if( $rep){
            return new JsonResponse("1");
        }else{
            return new JsonResponse("0");
        } 
    }


     /**
     * @Route("/rechercheRCCM", name="rechercheRCCM", methods={"GET","POST"})
     */
    public function rechercheRCCM(Request $request )
    {
        
        if(strpos($request->get("rccm"), "99")!==false){
                   return new JsonResponse("0"); 
        }else{
            if($request->get("val")){
                $rep=$this->getDoctrine()->getRepository(Repertoire::class)->findRCCM($request->get("rccm"),$request->get("cuci"));
                }else
                $rep=$this->getDoctrine()->getRepository(Repertoire::class)->findBy(["numeroRegistreCommerce"=>$request->get("rccm")]);
                if( count($rep)>0){
                    return new JsonResponse("1");
                }else{
                    return new JsonResponse("0");
                } 
        }
        
    }


     /**
     * @Route("/findnineacuci", name="findnineacuci", methods={"GET","POST"})
     */
    public function findnineacuci(Request $request )
    {
        
        $rep=$this->getDoctrine()->getRepository(Repertoire::class)->findninecuci($request->get("nineaajax"),$request->get("cuci"));
       
        if( $rep){
            return new JsonResponse("1");
        }else{
            return new JsonResponse("0");
        } 
    }




    /**
     * @Route("/", name="repertoire_index", methods={"GET"})
     */
    public function index(RepertoireRepository $repertoireRepository, Request $request): Response
    {   
        ini_set("memory_limit", -1);

        $repertoires=[];

        $ninea="";
        $cuci="";
        $denomination="";
        $rccm="";

        if($request->get("filtre")){
            $ninea=$request->get("ninea");
            $cuci=$request->get("cuci");
            $denomination=$request->get("denomination");
            $rccm=$request->get("rccm");
            if( $ninea || $cuci || $denomination || $rccm){
              $repertoires=$repertoireRepository->filtreRepertoire( $ninea,$cuci,$denomination,$rccm);
              if(count( $repertoires)==0)
                 $request->getSession()->getFlashBag()->add('filtre',"Aucun element ne correspond à  votre recherche.");
            }
        }

         
        return $this->render('repertoire/index.html.twig', [
            'repertoires' =>  $repertoires,
            'ninea' =>$ninea,
            'cuci' =>$cuci,
            'denomination' =>$denomination,
            'rccm' =>$rccm,
            
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
     * @Route("/nouveauRepertoire", name="repertoire_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {

        ini_set("memory_limit", -1);
        ini_set ( 'max_execution_time', -1);

        $repertoire = new Repertoire();
        $sequenceNumeroCUCI=new SequenceNumeroCUCI();

       


        $repertoire->setTypeNINEA($entityManager->getRepository(TypeNINEA::class)->find(1));
        $syscoas=$entityManager->getRepository(SYSCOA::class)->findAll();
       // $naemas=$entityManager->getRepository(RefNaemaNew::class)->findAll();
        $naemass=$entityManager->getRepository(NAEMAS::class)->findAll();
        $citis=$entityManager->getRepository(Citi::class)->findAll();
        $regions=$entityManager->getRepository(Region::class)->findAll();
        $categorySyscoa=$entityManager->getRepository(CategorySyscoa::class)->findAll();
        $categoryNaema=$entityManager->getRepository(RefNaemaNew::class)->findByAll();
        $categoryNaemas=$entityManager->getRepository(CategoryNaemas::class)->findAll();
        $categoryCiti=$entityManager->getRepository(RefCategoryCitiNew::class)->findAll();


        $form = $this->createForm(RepertoireType::class, $repertoire,[]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $activities= new Activities();
            $repertoire->setDateMiseAjour(new \DateTime());

            $last_insert=$entityManager->getRepository(SequenceNumeroCUCI::class)->findBy(array(),array('id'=>'desc'),1,0);

            if(count($last_insert)>0){
             $codeCUCI= $this->genererNumeroCUCI($last_insert[0]->getId()+1);
            }else
             $codeCUCI= $this->genererNumeroCUCI(1);

            if($request->get('qvh')){

                $qvh=$entityManager->getRepository(QVH::class)->find($request->get('qvh'));
                $repertoire->setQvh($qvh);
            }
            else{
                $request->getSession()->getFlashBag()->add('messageRepertoire'," le Quartier/Village/Hameau est obligatoire");

            }


            if($request->get('naema')){
                $naema=$entityManager->getRepository(NAEMA::class)->find($request->get('naema'));

                $repertoire->setNAEMA($naema);

                $activities->setNAEMA($naema) ;
            }
            else{
                $request->getSession()->getFlashBag()->add('messageRepertoire'," le naema est obligatoire");


            }


            if($request->get('naemas')){
                $naemas=$entityManager->getRepository(NAEMAS::class)->find($request->get('naemas'));
                $activities->setNAEMAS($naemas);
                 $repertoire->setNAEMAS($naemas);
            }
            else{
                $request->getSession()->getFlashBag()->add('messageRepertoire'," le naemas est obligatoire");

            }


            if($request->get('citi')){
                $citi=$entityManager->getRepository(Citi::class)->find($request->get('citi'));
                 $activities->setCITI($citi);
                  $repertoire->setCITI($citi);
            }
            else{
                $request->getSession()->getFlashBag()->add('messageRepertoire'," le citi est obligatoire");

            }



            if($request->get('syscoa')){
                $syscoa=$entityManager->getRepository(SYSCOA::class)->find($request->get('syscoa'));
                 $repertoire->setSYSCOA($syscoa);
                 $activities->setSYSCOA($syscoa);
            }
            else{
                $request->getSession()->getFlashBag()->add('messageRepertoire'," le syscoa est obligatoire");

            }


            if(!$form['activitePrincipaleRepeat']->getData())
            {
                $request->getSession()->getFlashBag()->add('messageRepertoire'," l'activité principale   est obligatoire");
            }else{
              $activities->setLibelleActivitePrincipale($form['activitePrincipaleRepeat']->getData());
              $activities->setChiffreAffaire($form['chiffreAffaire']->getData());
              $activities->setValeurAjoutee($form['valeurAjoutee']->getData());
              $activities->setPourcentage($form['pourcentage']->getData());
            }

            $repertoire->setCodeCuci($codeCUCI);
            if(str_replace("_","",$form['dureeDeExercice']->getData())!="")
                $repertoire->setDureeDeExercice(number_format(str_replace("_","",$form['dureeDeExercice']->getData())) );

            $activities->setActivitePrincipale(true);


            $repertoire->setCreatedBy($this->getUser());
            $repertoire->setUpdatedBy($this->getUser());
            $activities->setRepertoire($repertoire);

            if (!$request->get('qvh')||!$request->get('naema') || !$request->get('naemas') || !$request->get('syscoa') || !$request->get('citi') ||!$form['activitePrincipaleRepeat']->getData()) {


            }else
            {
                $entityManager->persist($sequenceNumeroCUCI);
                $entityManager->persist($repertoire);
                $entityManager->persist($activities);
                $entityManager->flush();
                $request->getSession()->getFlashBag()->add('message',"l'oppération de saisi d'une nouvelle unité a été éffectué avec succès");
                return $this->redirectToRoute('repertoire_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('repertoire/new.html.twig', [
            'repertoire' => $repertoire,
            'form' => $form,
            'categorySyscoa'=>$categorySyscoa,
            'categoryNaema'=>$categoryNaema,
            'categoryCiti'=>$categoryCiti,
            'categoryNaemas'=>$categoryNaemas,
            'regions' => $regions,
            'syscoa'=>$syscoas,
            
            'citi'=>$citis,
            'naemas'=>$naemass,
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
        $form = $this->createForm(RepertoireShowType::class, $repertoire,[ ]);
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
            $categoryNaema=$entityManager->getRepository(RefNaemaNew::class)->findAll();
            $categoryNaemas=$entityManager->getRepository(CategoryNaemas::class)->findAll();
            $categoryCiti=$entityManager->getRepository(RefCategoryCitiNew::class)->findAll();

        return $this->renderForm('repertoire/show.html.twig', [
            'repertoire' => $repertoire,
            'form' => $form,
            'regions' => $regions,
             'categorySyscoa'=>$categorySyscoa,
            'categoryNaema'=>$categoryNaema,
            'categoryCiti'=>$categoryCiti,
            'categoryNaemas'=>$categoryNaemas,
            'syscoa'=>$syscoa,
            'naema'=>$naema,
            'citi'=>$citi,
            'naemas'=>$naemas,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="repertoire_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Repertoire $repertoire, EntityManagerInterface $entityManager): Response
    {
      

        $syscoas=$entityManager->getRepository(SYSCOA::class)->findAll();
        $naemas=$entityManager->getRepository(NAEMA::class)->findAll();
        $naemass=$entityManager->getRepository(NAEMAS::class)->findAll();
        $citis=$entityManager->getRepository(Citi::class)->findAll();
        $regions=$entityManager->getRepository(Region::class)->findAll();



        $repertoire->setActivitePrincipaleRepeat( $repertoire->getActivitePrincipale());

        $activitiePrincipale=$repertoire->getActivitePrincipale();
        $chiffreAffaire="";
        $valeurAjoutee="";
        $pourcentage="";
        foreach ($repertoire->getActivities() as $key) {
            if ($key->getActivitePrincipale()) {

                $chiffreAffaire=$key->getChiffreAffaire();
                $valeurAjoutee=$key->getValeurAjoutee();
                $pourcentage=$key->getPourcentage();

            }
        }

        $repertoire->setDateMiseAjour( $repertoire->getUpdatedAt());


        $form = $this->createForm(RepertoireEditType::class, $repertoire,[ ]);
        $form->handleRequest($request);




        if ($form->isSubmitted() && $form->isValid()) {
            

            $repertoire->setDateMiseAjour(new \DateTime());
            $repertoire->setUpdatedAt(new \DateTime());
            $repertoire->setUpdatedBy($this->getUser()); 
            if($request->get('naema')){

                $naema=$entityManager->getRepository(NAEMA::class)->find($request->get('naema'));

                $repertoire->setNAEMA($naema);
              

            }

            else{

                $request->getSession()->getFlashBag()->add('messageRepertoire'," le naema est obligatoire");

            }

            if($request->get('naemas')){

                $naemas=$entityManager->getRepository(NAEMAS::class)->find($request->get('naemas'));

               

                 $repertoire->setNAEMAS($naemas);

            }

            else{

                $request->getSession()->getFlashBag()->add('messageRepertoire'," le naemas est obligatoire");



            }
            if($request->get('citi')){

                $citi=$entityManager->getRepository(Citi::class)->find($request->get('citi'));

                 

                  $repertoire->setCITI($citi);

            }

            else{

                $request->getSession()->getFlashBag()->add('messageRepertoire'," le citi est obligatoire");


            }
            if($request->get('syscoa')){

                $syscoa=$entityManager->getRepository(SYSCOA::class)->find($request->get('syscoa'));

                 $repertoire->setSYSCOA($syscoa);              

            }

            else{

                $request->getSession()->getFlashBag()->add('messageRepertoire'," le syscoa est obligatoire");
            }




            if(str_replace("_","",$form['dureeDeExercice']->getData())!="")
              $repertoire->setDureeDeExercice(number_format(str_replace("_","",$form['dureeDeExercice']->getData())) );
            
            if($request->get('qvh'))
                $qvh=$entityManager->getRepository(QVH::class)->find($request->get('qvh'));
            else{
                $request->getSession()->getFlashBag()->add('messageRepertoire'," le Quartier/Village/Hameau est obligatoire");

                return $this->redirectToRoute('repertoire_edit', ['id'=>$repertoire->getId()], Response::HTTP_SEE_OTHER);
            }



            $repertoire->setQvh($qvh);
            $entityManager->flush();
            $request->getSession()->getFlashBag()->add('message',"l'oppération de modification d'une  unité a été éffectué avec succès");
            return $this->redirectToRoute('repertoire_index', [], Response::HTTP_SEE_OTHER);
        }

         $regions=$entityManager->getRepository(Region::class)->findAll();

        $categorySyscoa=$entityManager->getRepository(CategorySyscoa::class)->findAll();
        $categoryNaema=$entityManager->getRepository(RefNaemaNew::class)->findAll();
        $categoryNaemas=$entityManager->getRepository(CategoryNaemas::class)->findAll();
        $categoryCiti=$entityManager->getRepository(RefCategoryCitiNew::class)->findAll();

        return $this->renderForm('repertoire/edit.html.twig', [
            'repertoire' => $repertoire,
            'form' => $form,
            'regions' => $regions,
            'categorySyscoa'=>$categorySyscoa,
            'categoryNaema'=>$categoryNaema,
            'categoryCiti'=>$categoryCiti,
            'categoryNaemas'=>$categoryNaemas,
            'syscoa'=>$syscoas,
            'naema'=>$naemas,
            'citi'=>$citis,
            'naemas'=>$naemass,
            'activitiePrincipale'=>$activitiePrincipale,
            'chiffreAffaire'=>$chiffreAffaire,
            'valeurAjoutee'=>$valeurAjoutee,
            'pourcentage'=>$pourcentage,
        ]);
    }



    /**
     * @Route("/restaurer/{id}", name="repertoire_restaurer", methods={"GET","POST"})
     */
    public function restaurer(Request $request, Repertoire $repertoire, EntityManagerInterface $entityManager): Response
    {

        $request->getSession()->getFlashBag()->add('message',"la restauration a été éffectué avec succès");
        $repertoire->setDeleted(true);
        $entityManager->flush();


        return $this->redirectToRoute('repertoire_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/delete/{id}", name="repertoire_delete", methods={"GET","POST"})
     */
    public function delete(Request $request, Repertoire $repertoire, EntityManagerInterface $entityManager): Response
    {

        $request->getSession()->getFlashBag()->add('message',"l'oppération a été réalisé avec succès");
        $entityManager->remove($repertoire);;
        $entityManager->flush();


        return $this->redirectToRoute('repertoire_index', [], Response::HTTP_SEE_OTHER);
    }
}
