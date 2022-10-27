<?php

namespace App\Controller;

use App\Entity\AchatProduction;
use App\Entity\AchatProductionUtil;
use App\Entity\Repertoire;
use App\Form\AchatProductionType;
use App\Form\AchatProductionUtilType;
use App\Form\RepertoireAchatType;
use App\Repository\AchatProductionRepository;
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
 * @Route("/achat/production")
 * @IsGranted("ROLE_USER")
 */
class AchatProductionController extends AbstractController
{
    private  $requestStack;

    public function __construct(RepertoireRepository $rep, RequestStack $requestStack)
    {
        // parent::__construct();
        $this->rep = $rep;
        $this->requestStack = $requestStack;
        
    }
    
    /**
     * @Route("/", name="achat_production_index", methods={"GET"})
     */
    public function index(AchatProductionRepository $achatProductionRepository): Response
    {
        return $this->render('achat_production/index.html.twig', [
            'achat_productions' => $achatProductionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="achat_production_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {

        

        $session = $this->requestStack->getSession();

        $codeCuci = $session->get('codeCuci');
        $annee = $session->get("annee"); 
        # $codeCuci = $request->get('codeCuci');
        # $annee = $request->get("annee"); 
        
        //$achat_obj = $this->getDoctrine()->getRepository(AchatProduction::class)->findByCodeCuci($codeCuci, $annee);

        $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]);


        $achat_de_prod = $this->getDoctrine()
                              ->getRepository(AchatProduction::class)
                              ->findOneBy(["repertoire"=>$repertoire, "anneeFinanciere"=>$annee]);

        $form=null;
        $submit_achat = false;
        
        if($request->get('submited')){
            $submit_achat=1;

            # $session->getFlashBag()->add('notice', 'Cet enregistrement a été sauvegardé et validé avec succès !');            
            
        }
        
        if(!$request->get('notsubmited')){
            $submit_achat=0; 
            # $session->getFlashBag()->add('notice', 'Cet enregistrement a été sauvegardé mais invalide. Vous pouvez toujours valider
            #                                             ultérieurement !');
            
        }
        
        
        if ($achat_de_prod) {
            

            $achatProdUtil=$achat_de_prod->getAchatProductionUtil();
            
            $form = $this->createForm(AchatProductionUtilType::class, $achatProdUtil);
            
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $achat_de_prod->setUpdatedAt(new \DateTime());
                $entityManager->flush();
                return $this->redirectToRoute('bilan_new', [], Response::HTTP_SEE_OTHER);

            }

        } else {

         
            $achatProdUtil = new AchatProductionUtil();
        
            $form = $this->createForm(AchatProductionUtilType::class, $achatProdUtil);
            
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) {
            
                $repertoire = $entityManager->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$request->get('codecuci')]);
           
                foreach ($achatProdUtil->getAchatProduction() as $key ) {


                    
                    $key->setAnneeFinanciere($request->get('annee'))
                        ->setSubmit($submit_achat)
                        ->setCreatedBy($this->getUser())
                        ->setUpdatedAt(new \DateTime())
                        ->setRepertoire($repertoire)
                        ->setUpdatedBy($this->getUser())
                    ;

                    $entityManager->persist($achatProdUtil);
                    $entityManager->flush();
                }
            

                # return $this->redirectToRoute('achat_production_new', [], Response::HTTP_SEE_OTHER);

                return $this->redirectToRoute('bilan_new', [], Response::HTTP_SEE_OTHER);
            }

        }
        

        return $this->renderForm('achat_production/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="achat_production_show", methods={"GET"})
     */
    public function show(AchatProduction $achatProduction): Response
    {
        return $this->render('achat_production/show.html.twig', [
            'achat_production' => $achatProduction,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="achat_production_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, AchatProduction $achatProduction, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(AchatProductionType::class, $achatProduction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('achat_production_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('achat_production/edit.html.twig', [
            'achat_production' => $achatProduction,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="achat_production_delete", methods={"POST"})
     */
    public function delete(Request $request, AchatProduction $achatProduction, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$achatProduction->getId(), $request->request->get('_token'))) {
            $entityManager->remove($achatProduction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('achat_production_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/nineaNumAchat/{id}", name="nineaNumAchat", methods={"GET"})
     */
    public function nineaNumAchat($id="")
    {
        $repertoire = $this->rep->findOneBy(['codeCuci' => $id]);
        $session=new Session();
        $session->set('codeCuci',$id);

        return new JsonResponse($repertoire->getDenominationSocial());
        
    }

    /**
     * Undocumented function
     * @Route("/achatProdjson/{annee}", name="achatProdjson", methods={"GET"})
     * @param string $annee
     */
    public function achatProdjson($annee="")
    {
        $tab_data=[]; # tab global a retourner 
        $tab1=[]; # pour le chargement des données des effectifs

        $tab_index = [];


        $session = $this->requestStack->getSession();
        $codeCuci = $session->get('codeCuci');

        $achat_obj = $this->getDoctrine()->getRepository(AchatProduction::class)->findByCodeCuci($codeCuci, $annee);

              ### retrouver le repertoire correspondant au codeCuci 
        $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["codeCuci"=>$codeCuci]);


        if ($achat_obj) {
            foreach ($achat_obj as $key ) {
                $achat_de_prod = $this->getDoctrine()
                                      ->getRepository(AchatProduction::class)
                                      ->findOneBy(["repertoire"=>$repertoire, "anneeFinanciere"=>$annee, "unites"=>$key->getUnites()]);

                array_push($tab_index, $key->getUnites());

                if ($achat_de_prod) {
                    $tab1[$key->getUnites()] = [
                        $key->getLibelle(),
                        $key->getUnites(),
                        $key->getQtyProduitDansEtat(),
                        $key->getValProduitDansEtat(),
                        $key->getQtyAcheteeDansEtat(),
                        $key->getValAcheteeDansPays(),
                        $key->getQtyAcheteeHorsPays(),
                        $key->getValAcheteeHorsPays(),
                        $key->getVariationDesStocks()
                    ];
                }else {
                    # code...
                }

            }
        }else{

        }

        array_push($tab_data, $tab_index);
        array_push($tab_data, $tab1);

        return new JsonResponse($tab_data);


    }
}
