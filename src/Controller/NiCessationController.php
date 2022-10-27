<?php

namespace App\Controller;

use App\Entity\NiCessation;
use App\Entity\NINinea;
use App\Form\NiCessationType;
use App\Form\NiRadiationType;
use App\Repository\NiCessationRepository;
use App\Services\QrcodeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Snappy\Pdf;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Route("/ni/cessation")
* @Security("is_granted('ROLE_DEMANDE_NINEA') or is_granted('ROLE_VALIDER_DEMANDE_NINEA') or is_granted('ROLE_NINEA_ADMIN')")
 */
class NiCessationController extends AbstractController
{
    /**
     * @Route("/", name="app_ni_cessation_index", methods={"GET"})
     */
    public function index(NiCessationRepository $niCessationRepository): Response
    {
        return $this->render('ni_cessation/index.html.twig', [
            'ni_cessations' => $niCessationRepository->findAll(),
        ]);
    }


    
    /**
     * @Route("/cessationSuspensionsList", name="cessationSuspensionsList")
     */
    public function cessationSuspensionsList(): Response
    {
        return $this->render('ni_cessation/cessationSuspensionsList.html.twig', [
            'ni_cessations' => $this->getDoctrine()->getRepository(NiCessation::class)->findBy(array("etat"=>"v"), null, 80, null),
        ]);
    }


    /**
     * @Route("/new/{ind}", name="app_ni_cessation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,$ind): Response
    {
        $niCessation = new NiCessation();
        if ($ind == 2)
            $form = $this->createForm(NiCessationType::class, $niCessation);
        else 
            $form = $this->createForm(NiRadiationType::class, $niCessation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $niCessation->setEtat("a");
            $ninea = $request->get("nineamere");
            $niCessation->setCreatedBy($this->getUser());
            $niCessation->setUpdatedBy($this->getUser());
            if ($ninea)
             $niCessation->setNinea($entityManager->getRepository(NINinea::class)->findOneBy(['ninNinea' => $ninea]));
             else{
                $request->getSession()->getFlashBag()->add('message',"NINEA ne doit pas être vide.");
                return $this->redirectToRoute('app_ni_cessation_new', ["ind"=>$ind], Response::HTTP_SEE_OTHER);
            }

            $entityManager->persist($niCessation);
            $entityManager->flush();

            return $this->redirectToRoute('app_ni_cessation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ni_cessation/new.html.twig', [
            'ni_cessation' => $niCessation,
            'form' => $form,
            'ind'=>$ind
        ]);
    }

    /**
     * @Route("/{id}", name="app_ni_cessation_show", methods={"GET"})
     */
    public function show(NiCessation $niCessation): Response
    {
        return $this->render('ni_cessation/show.html.twig', [
            'ni_cessation' => $niCessation,
            'ninea'=>$niCessation->getNinea()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_ni_cessation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, NiCessation $niCessation, EntityManagerInterface $entityManager): Response
    {
       
        $ind=1;
        if($niCessation->getNinea()->getFormeJuridique()->getNiFormeunite()->getId() == 11 or 
                $niCessation->getNinea()->getFormeJuridique()->getNiFormeunite()->getId() == 12)
        {
            $ind = 2;
            $form = $this->createForm(NiCessationType::class, $niCessation);
        }
        else
        {
            $form = $this->createForm(NiRadiationType::class, $niCessation);

        }
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $niCessation->setUpdatedBy($this->getUser());
                $niCessation->setUpdatedAt(new \DateTime());
                $niCessation->setEtat("a");
            $entityManager->flush();

            return $this->redirectToRoute('app_ni_cessation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ni_cessation/edit.html.twig', [
            'ni_cessation' => $niCessation,
            'form' => $form,
            "ind" => $ind,
        ]);
    }

    /**
     * @Route("/valider/{id}", name="app_ni_cessation_valider", methods={"GET", "POST"})
     */
    public function valider(Request $request, NiCessation $niCessation, EntityManagerInterface $entityManager): Response
    {
        $niCessation->setEtat("v");
        $ninea=$niCessation->getNinea();
        $ninea->setNinEtat("0");
        $niCessation->setUpdatedBy($this->getUser());
        $niCessation->setUpdatedAt(new \DateTime());
        $entityManager->flush();
        return $this->redirectToRoute('app_ni_cessation_index', [], Response::HTTP_SEE_OTHER);
       
    }


         /**
     * @Route("/rejet/{id}", name="ni_cessation_rejet", methods={"GET", "POST"})
     */
    public function rejeter(Request $request, EntityManagerInterface $entityManager, NiCessation $niCessation): Response

      {
       // $niNineaproposition->setNinlock(false);

        $niCessation->setRemarque($request->get("remarque"));
        $niCessation->setEtat("r")     ;

            $entityManager->flush();
                  

            //$demandes_rejetees = count($entityManager->getRepository(NiNineaproposition::class)->findByDemande($this->getUser(), 'r'));
            
            //$session->set("rejeter", $demandes_rejetees);

            
            return $this->redirectToRoute('app_ni_cessation_index', [], Response::HTTP_SEE_OTHER);
          
      }


              /**
     * @Route("/retourner/{id}", name="ni_cessation_retourner", methods={"GET", "POST"})
     */
    
     public function retourner(Request $request, EntityManagerInterface $entityManager, NiCessation $niCessation): Response

     {
 
       $niCessation->setRemarque($request->get("remarque"));
       $niCessation->setEtat("t")     ;
 
           $entityManager->flush();
           
        return $this->redirectToRoute('app_ni_cessation_index', [], Response::HTTP_SEE_OTHER);
         
     }
 

    /**
     * @Route("/{id}", name="app_ni_cessation_delete", methods={"POST"})
     */
    public function delete(Request $request, NiCessation $niCessation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$niCessation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($niCessation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ni_cessation_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * function pour telecharger dans  le navigateur le pdf generer par knpsnappy et wkhtmltopdf 
     * de l'avis de cessation (radiation ou la suspension)
     * @Route("/pdfActionDown/{id}", name="pdfActionDownCessation", methods={"GET","POST"})
     * @param Pdf $knpSnappyPdf
     * @return void
     */
    public function pdfActionDown(NiCessation $vars, Pdf $knpSnappyPdf, $id="")
    {
        //$vars = null ; //$this->getDoctrine()->getRepository(NINinea::class)->findBy([""]);
        
        //dd($qrcodeService->qrcode("ansd"));

        //$this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', $vars);
        $this->denyAccessUnlessGranted('ROLE_USER' , $vars, 'Vous ne pouvez pas accéder à ce fichier. Contacter votre supérieur hiéarchique.');

        if ($vars) {

            // recuperer l'objet NINEA  correspondant à cette Cessation
            // $admin_csi = $this->getDoctrine()->getRepository(NINinea::class)->findOneBy(["ninAdministration"=>$vars->getNinAdministration()]);

            $obj_ninea = $this->getDoctrine()->getRepository(NINinea::class)->findOneBy(["ninNinea"=>$vars->getNinea()->getNinNinea()]);

            $titre_doc = "AVIS DE SUSPENSION";

            if ($obj_ninea) {
                //TODO recuperer la forme unite 
                $forme_unit = null!=$obj_ninea->getFormeJuridique() ? $obj_ninea->getFormeJuridique()->getNiFormeunite()->getId() : "";

                if ($forme_unit!= "11" && $forme_unit!="12") {
                    $titre_doc = "AVIS DE RADIATION";
                }
            }

            $options = [
                
              'enable-javascript' => true, 
              'javascript-delay' => 1000, 
              'no-stop-slow-scripts' => true, 
              'no-background' => false, 
              'lowquality' => false,
              'encoding' => 'utf-8',
              'cookie' => array(),
              'enable-external-links' => false,
              'enable-internal-links' => true,
              'encoding'      => 'UTF-8',
              'background' => true,
              'margin-right'=>0,
            ];

            
            $html = $this->renderView('ni_cessation/_vimprimable_cessation.html.twig', array(
                'some'  => $vars,
                'title' => "REPUBLIQUE DU SENEGAL MINISTERE DE L'ECONOMIE, DU PLAN ET DE LA COOPERATION",
                'decret' => "Décret N° 2012 - 886 du 27/08/2012 abrogeant et remplaçant le décret  N° 95 - 364 du 14/04/1995",
                'obj_ninea' => $obj_ninea,
                'titre_doc' => $titre_doc,
            )); 


            $knpSnappyPdf->setOptions($options);
            $filename =  "Avis_de_cessation".$vars->getMotif();
            
            return new Response(
                $knpSnappyPdf->getOutputFromHtml($html),
                200,
                array(
                    'Content-Type'          => 'application/pdf',
                    'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
                )
            );
                        
        }
        throw new NotFoundHttpException();

    }



}
