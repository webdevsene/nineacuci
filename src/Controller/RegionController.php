<?php

namespace App\Controller;

use App\Entity\Region;
use App\Form\RegionType;
use App\Repository\RegionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * @Route("/region")
 */
class RegionController extends AbstractController
{
    /**
     * @Route("/", name="region_index", methods={"GET"})
     */
    public function index(RegionRepository $regionRepository): Response
    {
        return $this->render('region/index.html.twig', [
            'regions' => $regionRepository->findAll(),
        ]);
    }


    /**
     * @Route("/importRegion", name="importRegion", methods={"GET", "POST"})
     *  @param Request $request
     *  @throws \Exception
     */
    public function importRegion(Request $request, EntityManagerInterface $entityManager)
    {
            $new_region = new Region;
 
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
             dd($sheetData);
            
            
            
                
                foreach ($sheetData as $Row) {
                    $code_region = $Row['A']; // store the first_name on each iteration 
                    $libelle_region = $Row['B']; // store the first_name on each iteration 
                    // $last_name = $Row['B']; // store the last_name on each iteration
                    
                    $region_existant = $entityManager->getRepository(Region::class)->findOneBy(array('codeReg' => $code_region)); // ceci est necessaire seulement sur l'entité User
                    // make sure that the user does not already exists in your db 
                    
                    if (!$region_existant) {

                        
                        
                        $new_region->setCodeReg($code_region);
                        $new_region->setLibelle($libelle_region);
                        
                        $entityManager->persist($new_region);    
                        $entityManager->flush(); 
                        // here Doctrine checks all the fields of all fetched data and make a transaction to the database.
                    }
                    
                }
            
         return $this->redirectToRoute('region_new', ['id'=>$new_region->getId()], Response::HTTP_SEE_OTHER);
       
        }

    /**
     * @Route("/new", name="region_new", methods={"GET", "POST"})
     */
    public function new(Request $request, RegionRepository $regionRepository): Response
    {
        

        return $this->renderForm('region/new.html.twig', [
            'regions' =>  $regionRepository->findAll(),
           
        ]);
    }


     /**
     * @Route("/departementsRegion/{id}", name="departementsRegion", methods={"GET"})
     */
    public function departementsRegion( $id="")
    {
         $tab=[];
         $region=$this->getDoctrine()->getRepository(Region::class)->find($id);
         foreach ($region->getDepartements() as $key ) {

             array_push($tab,[$key->getId(),$key->getDescription()]);
         }        
        return new JsonResponse( $tab);
    }

    /**
     * @Route("/{id}", name="region_show", methods={"GET"})
     */
    public function show(Region $region): Response
    {
        return $this->render('region/show.html.twig', [
            'region' => $region,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="region_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Region $region, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RegionType::class, $region);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('region_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('region/edit.html.twig', [
            'region' => $region,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="region_delete", methods={"POST"})
     */
    public function delete(Request $request, Region $region, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$region->getId(), $request->request->get('_token'))) {
            $entityManager->remove($region);
            $entityManager->flush();
        }

        return $this->redirectToRoute('region_index', [], Response::HTTP_SEE_OTHER);
    }
}
