<?php

namespace App\Controller;

use App\Entity\NAEMA;
use App\Entity\CategoryNaema;
use App\Form\NAEMAType;
use App\Repository\NAEMARepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * @Route("/naema")
 */
class NAEMAController extends AbstractController
{



         /**
     * @Route("/naemacat/{id}", name="naemacat", methods={"GET"})
     */
    public function naema( $id="")
    {
         $tab=[];
         $categorynaema=$this->getDoctrine()->getRepository(CategoryNaema::class)->find($id);
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
                        
                        $categoryNaema->setCode($code);
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
        return $this->render('naema/index.html.twig', [
            'n_a_e_m_as' => $nAEMARepository->findAll(),
        ]);
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

        return $this->renderForm('naema/new.html.twig', [
            'n_a_e_m_a' => $nAEMA,
            'form' => $form,
            'categorynaemas' => $categorynaemas,
        ]);
    }

    /**
     * @Route("/{id}", name="n_a_e_m_a_show", methods={"GET"})
     */
    public function show(NAEMA $nAEMA): Response
    {
        return $this->render('naema/show.html.twig', [
            'n_a_e_m_a' => $nAEMA,
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
