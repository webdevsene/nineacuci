<?php

namespace App\Controller;

use App\Entity\Citi;
use App\Entity\CategoryCiti;
use App\Entity\RefCategoryCitiNew;
use App\Form\CitiType;
use App\Repository\CitiRepository;
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
 * @Route("/citi")
 * @IsGranted("ROLE_USER")
 */
class CitiController extends AbstractController
{

    
     /**
     * @Route("/citicat/{id}", name="citicat", methods={"GET"})
     */
    public function citicat( $id="")
    {
         $tab=[];
         $categoryciti=$this->getDoctrine()->getRepository(RefCategoryCitiNew::class)->find($id);
         foreach ($categoryciti->getCiti() as $key ) {

             array_push($tab,[$key->getId(),$key->getLibelle()]);
         }        
        return new JsonResponse( $tab);
    }




      /**
     * @Route("/importCategoryCiti", name="importCategoryCiti", methods={"GET", "POST"})
     *  @param Request $request
     *  @throws \Exception
     */
    public function importCategoryCiti(Request $request, EntityManagerInterface $entityManager)
    {
            $importCategoryCiti = new CategoryCiti();
 
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
                    
                    $categoryCiti_existant = $entityManager->getRepository(CategoryCiti::class)->findOneBy(array('id' => $code)); // ceci est necessaire seulement sur l'entité User
                    // make sure that the user does not already exists in your db 
                    
                    if (!$categoryCiti_existant) {

                        $categoryCiti = new CategoryCiti();
                        
                        $categoryCiti->setCode($code);
                        $categoryCiti->setId($code);
                        $categoryCiti->setLibelle($libelle);
                        
                        $entityManager->persist($categoryCiti);    
                        $entityManager->flush(); 
                        // here Doctrine checks all the fields of all fetched data and make a transaction to the database.
                    }
                    
                }
            
         return $this->redirectToRoute('citi_new', Response::HTTP_SEE_OTHER);
       
        }
   


      /**
     * @Route("/importCiti", name="importCiti", methods={"GET", "POST"})
     *  @param Request $request
     *  @throws \Exception
     */
    public function importCiti(Request $request, EntityManagerInterface $entityManager)
    {
            $importCiti = new Citi();
 
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
                    $codeCategory = $Row['C']; // store the first_name on each iteration 
                    // $last_name = $Row['B']; // store the last_name on each iteration


                    
                    $citi_existant = $entityManager->getRepository(Citi::class)->findOneBy(array('id' => $code)); // ceci est necessaire seulement sur l'entité User
                    // make sure that the user does not already exists in your db 
                    
                    if (!$citi_existant) {

                        $citi = new Citi();

                        $category = $entityManager->getRepository(CategoryCiti::class)->find($codeCategory);
                        
                        $citi->setCode($code);
                        $citi->setCategoryCiti( $category);
                        $citi->setId($code);
                        $citi->setLibelle($libelle);
                        
                       if($category)
                        $entityManager->persist($citi);    
                        $entityManager->flush(); 
                        // here Doctrine checks all the fields of all fetched data and make a transaction to the database.
                    }
                    
                }
            
         return $this->redirectToRoute('citi_new', Response::HTTP_SEE_OTHER);
       
        }



    /**
     * @Route("/", name="citi_index", methods={"GET"})
     */
    public function index(CitiRepository $citiRepository): Response
    {
        return $this->render('citi/index.html.twig', [
            'citis' => $citiRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="citi_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $citi = new Citi();
        $form = $this->createForm(CitiType::class, $citi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($citi);
            $entityManager->flush();

            return $this->redirectToRoute('citi_index', [], Response::HTTP_SEE_OTHER);
        }

        $citis= $entityManager->getRepository(CategoryCiti::class)->findAll();

        return $this->renderForm('citi/new.html.twig', [
            'citi' => $citi,
            'citis' => $citis,
            'form' => $form,

        ]);
    }

    /**
     * @Route("/{id}", name="citi_show", methods={"GET"})
     */
    public function show(Citi $citi): Response
    {
        return $this->render('citi/show.html.twig', [
            'citi' => $citi,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="citi_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Citi $citi, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CitiType::class, $citi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('citi_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('citi/edit.html.twig', [
            'citi' => $citi,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="citi_delete", methods={"POST"})
     */
    public function delete(Request $request, Citi $citi, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$citi->getId(), $request->request->get('_token'))) {
            $entityManager->remove($citi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('citi_index', [], Response::HTTP_SEE_OTHER);
    }
}
