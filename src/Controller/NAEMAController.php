<?php

namespace App\Controller;

use App\Entity\NAEMA;
use App\Entity\CategoryNaema;
use App\Form\NAEMAType;
use App\Entity\RefNaemaNew;
use App\Entity\RefProduits;
use App\Repository\NAEMARepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/naema")
 * @IsGranted("ROLE_USER")
 */
class NAEMAController extends AbstractController
{



         /**
     * @Route("/naemacat/{id}", name="naemacat", methods={"GET"})
     */
    public function naema( $id="")
    {
         $tab=[];
         $categorynaema=$this->getDoctrine()->getRepository(RefNaemaNew::class)->find($id);
         foreach ($categorynaema->getNaema() as $key ) {

             array_push($tab,[$key->getId(),$key->getNaema()]);
         }        
        return new JsonResponse( $tab);
    }



      /**
     * @Route("/importCategoryNaema", name="importCategoryNaema", methods={"GET", "POST"})
     *  @param Request $request
     *  @throws \Exception
     */
    public function importCategoryNaema(Request $request, EntityManagerInterface $entityManager)
    {
            $categoryNaema = new CategoryNaema;
 
            $file = $request->files->get('_file'); // get the file from the sent request
            
            //choose the folder in which the uploaded file will be stored
            // tout ce qui est en rapport avec la localisation est stocke dans le folder localization
            $fileFolder = __DIR__ . '/../../public/uploads/';  
            
            $filePathName = uniqid() . $file->getClientOriginalName() . '.' . $file->getClientOriginalExtension();
            // apply md5 function to generate an unique identifier for the file and concat it with the file extension  
            
            
            try {
                $file->move($fileFolder, $filePathName);
            } catch (FileException $e) {
                dd($e);
            }
            $spreadsheet = IOFactory::load($fileFolder . $filePathName); // Here we are able to read from the excel file 
            $row = $spreadsheet->getActiveSheet()->removeRow(1); // I added this to be able to remove the first file line 
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true); // here, the read data is turned into an array
           
            
            
            
                
                foreach ($sheetData as $Row) {
                    $code = $Row['A']; // store the first_name on each iteration 
                    $libelle = $Row['B']; // store the first_name on each iteration 
                    // $last_name = $Row['B']; // store the last_name on each iteration
                    
                    $categoryNaema_existant = $entityManager->getRepository(CategoryNaema::class)->findOneBy(array('id' => $code)); // ceci est necessaire seulement sur l'entité User
                    // make sure that the user does not already exists in your db 
                    
                    if (!$categoryNaema_existant) {

                        $categoryNaema = new CategoryNaema;
                        
                      
                        $categoryNaema->setId($code);
                        $categoryNaema->setLibelle($libelle);
                        
                        $entityManager->persist($categoryNaema);    
                        $entityManager->flush(); 
                        // here Doctrine checks all the fields of all fetched data and make a transaction to the database.
                    }
                    
                }
            
         return $this->redirectToRoute('naema_new', Response::HTTP_SEE_OTHER);
       
    }





    /**
     * @Route("/", name="n_a_e_m_a_index", methods={"GET"})
     */
    public function index(NAEMARepository $nAEMARepository): Response
    {

        $ref_produits = $this->getDoctrine()->getRepository(RefProduits::class)->findBy(array("naema" => "0111"));
        return $this->render('naema/index.html.twig', [
            'n_a_e_m_as' => $nAEMARepository->findAll(),
            'ref_produits' => $ref_produits,
        ]);
    }



    /**
     * Liste des produits par category activite
     * @Route("/produitByNaemaList/{id}", name="produitByNaemaList", methods={"GET"})
     */
    public function produitByNaemaList($id="")
    {

        $tab=[];

        $ref_produits = $this->getDoctrine()->getRepository(RefProduits::class)->findBy(array("naema" => $id));
        foreach ($ref_produits as $key) {
            array_push($tab, ["id"=>$key->getId(), "libelle"=>$key->getLibelle(), "naema"=>$key->getNaema()->getLibelle()]);
        }
        return new JsonResponse($tab);
    }



    /**
     * @Route("/new", name="naema_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $nAEMA = new NAEMA();
        $form = $this->createForm(NAEMAType::class, $nAEMA);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($nAEMA);
            $entityManager->flush();

            return $this->redirectToRoute('n_a_e_m_a_index', [], Response::HTTP_SEE_OTHER);
        }

         $categorynaemas=$this->getDoctrine()->getRepository(CategoryNaema::class)->findAll();

         $limit = 6;

         $offset = null;

        return $this->renderForm('naema/new.html.twig', [
            'n_a_e_m_a' => $this->getDoctrine()->getRepository(NAEMA::class)->findBy(array(), null, $limit, $offset),
            'form' => $form,
            'categorynaemas' => $categorynaemas,
        ]);
    }

    /**
     * @Route("/{id}", name="n_a_e_m_a_show", methods={"GET"})
     */
    public function show(NAEMA $nAEMA): Response
    {

        $tab=[];

        $ref_produits = $this->getDoctrine()->getRepository(RefProduits::class)->findBy(array("naema" => $nAEMA->getId()));
        foreach ($ref_produits as $key) {
            array_push($tab, ["id"=>$key->getId(), "libelle"=>$key->getLibelle(), "naema"=>$key->getNaema()->getLibelle()]);
        }

        return $this->render('naema/_partialProuitsByNaemaList.html.twig', [
            'n_a_e_m_a' => $nAEMA,
            'ref_produits' => $ref_produits,
            'tab' => $tab,

        ]);
    }

    /**
     * @Route("/{id}/edit", name="n_a_e_m_a_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, NAEMA $nAEMA, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NAEMAType::class, $nAEMA);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('n_a_e_m_a_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('naema/edit.html.twig', [
            'n_a_e_m_a' => $nAEMA,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="n_a_e_m_a_delete", methods={"POST"})
     */
    public function delete(Request $request, NAEMA $nAEMA, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$nAEMA->getId(), $request->request->get('_token'))) {
            $entityManager->remove($nAEMA);
            $entityManager->flush();
        }

        return $this->redirectToRoute('n_a_e_m_a_index', [], Response::HTTP_SEE_OTHER);
    }
}
