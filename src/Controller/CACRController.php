<?php

namespace App\Controller;

use App\Entity\CACR;
use App\Entity\CAV;
use App\Form\CACRType;
use App\Repository\CACRRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * @Route("/cacr")
 */
class CACRController extends AbstractController
{
    /**
     * @Route("/", name="c_a_c_r_index", methods={"GET"})
     */
    public function index(CACRRepository $cACRRepository): Response
    {
        return $this->render('cacr/index.html.twig', [
            'c_a_c_rs' => $cACRRepository->findAll(),
        ]);
    }

     // Permet de recupèrer les entete des colonnes du fichier Excel à importer
    public static function mapExcelColumns($spreadsheet): array
    {
        $colonnes = array();

        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        foreach ($sheetData as $Row) {
            array_push($colonnes, $Row);
            break;
        }
        return $colonnes[0];
    }

    // Permet de tester la non existence d'une colonne au niveau du fichier Excel
    public static function excelNotFoundColumnException($colums, $mapColumns): string
    {
        foreach ($colums as $col) {
            $isColumn = array_search($col, $mapColumns, true);

            if ($isColumn == false) {
                return $col;
            }
        }
        return "";
    }


    
    /**
     *  @Route("/importCacr", name="importCacr")
     *  @param Request $request
     *  @throws \Exception
     *  @return void
     */
    public function importCacr(Request $request, EntityManagerInterface $entityManager)
    {
        $file = $request->files->get('_file');

        $fileFolder = __DIR__ . '/../../public/uploads/';  

        // $filePathName = md5(uniqid()) . $file->getClientOriginalName();
        $filePathName = uniqid() . $file->getClientOriginalName() . '.' . $file->getClientOriginalExtension();

        try {
            $file->move($fileFolder, $filePathName);
        } catch (FileExists $e) {
            dd($e);
        }
        $spreadsheet = IOFactory::load($fileFolder . $filePathName); // Here we are able to read from the excel file
        
        // récupère le nom des colonnes
        $mapColumns = CACRController::mapExcelColumns($spreadsheet);
        
        // // TODO: verifie l'existence des col d'entêtes 
        // ici on definit /c'est notre model qvh different de celui de pigor
        $excelColonnes = [
            'codeCacr', 'libelle', 'codeCav',
        ];
        // avec code region correspond à dep_id dans la table donc deId dans l'entité

        
        // on verifie physiquement 
        $col = CACRController::excelNotFoundColumnException($excelColonnes, $mapColumns);

        // affiche à l'utilisateur un mssage d'erreur si le template ne suit pas ce format
        if (!empty($col)) {
            $this->addFlash(
                'danger',
                "La colonne <strong> {$col} </strong> n'est pas définie dans le fichier Excel. Merci de vous référer sur le template de base !"
            );
            return $this->redirectToRoute('cacr_new'); // pour le moment on retourne la page new
        }

         // Récupère les index ou la position de chaque colonne
         $code_dep_index = array_search("codeCacr", $mapColumns, true);
         $libelle_dep_index = array_search("libelle", $mapColumns, true);
         $code_reg_dep_index = array_search("codeCav", $mapColumns, true); 

         $row = $spreadsheet->getActiveSheet()->removeRow(1); // I added this to be able to remove the first file line 
         $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true); // here, the read data is turned into an array
         // si je veux voir la liste des données au format json 
         // je décommente cette ligne suivante
         // dd($sheetData);      
         
         // enregistrer les donnees en base
         $entityManager = $this->getDoctrine()->getManager();
         
         foreach ($sheetData as $Row) {
             
         
                 // $_codeqvh = $Row['A'];
                 $_code = $Row[$code_dep_index];  
                 $_description = $Row[$libelle_dep_index]; 
                 $_code_dep = $Row[$code_reg_dep_index];  
                 //dd($_code_dep, $_description_dep, $_code_reg_dep);//// code COM.AR / C.RUR
                
                $isDepexists = $entityManager->getRepository(CACR::class)->findOneBy(['codeCacr' => $_code]);

               
                
                
                // TODO: Permet de tester si le QVH existe déjà !
                if (!$isDepexists) {
                    
                    // $var_region = $this->regionRepo->findOneBy(['regCD' => $_code_reg_dep]);

                    $cav = $entityManager->getRepository(CAV::class)->findOneBy(['codeCav' => $_code_dep]);

                    
                    
                    $cav_obj = new CACR;
                    
                    $cav_obj->setCodeCacr($_code)
                    ->setLibelle($_description)
                    ->setCacrCAVID($cav)
                    ;                 
                    
                    

                    if ($cav != NULL) {
                        // persist ssi tu trouves le CACR du QVH
                        $entityManager->persist($cav_obj);
                    }
                    $entityManager->flush();
                 }
           
        }
        
        return $this->redirectToRoute('cacr_new');
    }

    /**
     * @Route("/new", name="cacr_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,CACRRepository $cACRRepository): Response
    {
       

        return $this->renderForm('cacr/new.html.twig', [
           'cacr' => $cACRRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="c_a_c_r_show", methods={"GET"})
     */
    public function show(CACR $cACR): Response
    {
        return $this->render('cacr/show.html.twig', [
            'c_a_c_r' => $cACR,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="c_a_c_r_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CACR $cACR, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CACRType::class, $cACR);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('c_a_c_r_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cacr/edit.html.twig', [
            'c_a_c_r' => $cACR,
            'form' => $form,
        ]);
    }



     /**
     * @Route("/qvhCacr/{id}", name="qvhCacr", methods={"GET"})
     */
    public function qvhCacr( $id="")
    {
         $tab=[];
         $cacr=$this->getDoctrine()->getRepository(CACR::class)->find($id);
         foreach ($cacr->getQVHs() as $key ) {

             array_push($tab,[$key->getId(),$key->getLibelle()]);
         }        
        return new JsonResponse( $tab);
    }


    /**
     * @Route("/{id}", name="c_a_c_r_delete", methods={"POST"})
     */
    public function delete(Request $request, CACR $cACR, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cACR->getId(), $request->request->get('_token'))) {
            $entityManager->remove($cACR);
            $entityManager->flush();
        }

        return $this->redirectToRoute('c_a_c_r_index', [], Response::HTTP_SEE_OTHER);
    }
}
