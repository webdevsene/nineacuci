<?php

namespace App\Controller;

use App\Entity\Departement;
use App\Entity\Region;
use App\Form\DepartementType;
use App\Repository\DepartementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * @Route("/departement")
 */
class DepartementController extends AbstractController
{
    /**
     * @Route("/", name="departement_index", methods={"GET"})
     */
    public function index(DepartementRepository $departementRepository): Response
    {
        return $this->render('departement/index.html.twig', [
            'departements' => $departementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="departement_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,DepartementRepository $departementRepository): Response
    {

        return $this->renderForm('departement/new.html.twig', [
            'departements' => $departementRepository->findAll(),
           
        ]);
    }


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
     *  @Route("/importDepartement", name="importDepartement", methods={"GET", "POST"})
     *  @param Request $request
     *  @param KernelInterface $kernel
     *  @throws \Exception
     *  @return void
     */
    public function importDepartement(Request $request, EntityManagerInterface $entityManager)
    {
        $file = $request->files->get('_file');




        // $fileFolder = $kernel->getCacheDir() . '/';
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
        $mapColumns = DepartementController::mapExcelColumns($spreadsheet);
        
        // // TODO: verifie l'existence des col d'entêtes 
        // ici on definit /c'est notre model qvh different de celui de pigor
        $excelColonnes = [
            'codeDep', 'libelle', 'codeReg',
        ];
        // avec code region correspond à dep_id dans la table donc deId dans l'entité

        
        // on verifie physiquement 
        $col = DepartementController::excelNotFoundColumnException($excelColonnes, $mapColumns);




        // affiche à l'utilisateur un mssage d'erreur si le template ne suit pas ce format
        if (!empty($col)) {
            $this->addFlash(
                'danger',
                "La colonne <strong> {$col} </strong> n'est pas définie dans le fichier Excel. Merci de vous référer sur le template de base !"
            );
            return $this->redirectToRoute('departement_new'); // pour le moment on retourne la page new
        }

         // Récupère les index ou la position de chaque colonne
         $code_dep_index = array_search("codeDep", $mapColumns, true);
         $libelle_dep_index = array_search("libelle", $mapColumns, true);
         $code_reg_dep_index = array_search("codeReg", $mapColumns, true);

         

         $row = $spreadsheet->getActiveSheet()->removeRow(1); // I added this to be able to remove the first file line 
         $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true); // here, the read data is turned into an array
         // si je veux voir la liste des données au format json 
         // je décommente cette ligne suivante
         // dd($sheetData); 



         
         // enregistrer les donnees en base
         $entityManager = $this->getDoctrine()->getManager();
         
         foreach ($sheetData as $Row) {
             
           
                 // $_codeqvh = $Row['A'];
                 $_code_dep = $Row[$code_dep_index]; 
                 $_description_dep = $Row[$libelle_dep_index]; 
                 $_code_reg_dep = $Row[$code_reg_dep_index]; 

                 //dd($_code_dep, $_description_dep, $_code_reg_dep);//// code COM.AR / C.RUR





                
                $isDepexists = $entityManager->getRepository(Departement::class)->findOneBy(['codeDep' => $_code_dep]);

                
              
                // TODO: Permet de tester si le QVH existe déjà !
                if (!$isDepexists) {
                  
                 
                    $var_region = $entityManager->getRepository(Region::class)->findOneBy(['codeReg' => $_code_reg_dep]);

                   
                    
                    
                    $dep_obj = new Departement();

                    $dep_obj->setCodeDep($_code_dep)
                             ->setLibelle($_description_dep)
                             ->setDepRegCD($var_region)
                    ;                 


                    if ($var_region != NULL) {
                        
                        $entityManager->persist($dep_obj);
                    }
                    $entityManager->flush();
                 }
           
        }
        
        return $this->redirectToRoute('departement_new');
    }




     /**
     * @Route("/cavDepartement/{id}", name="cavDepartement", methods={"GET"})
     */
    public function cavDepartement( $id="")
    {
         $tab=[];
         $departement=$this->getDoctrine()->getRepository(Departement::class)->find($id);
         foreach ($departement->getCAVs() as $key ) {

             array_push($tab,[$key->getId(),$key->getLibelle()]);
         }        
        return new JsonResponse( $tab);
    }

    /**
     * @Route("/{id}", name="departement_show", methods={"GET"})
     */
    public function show(Departement $departement): Response
    {
        return $this->render('departement/show.html.twig', [
            'departement' => $departement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="departement_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Departement $departement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DepartementType::class, $departement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('departement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('departement/edit.html.twig', [
            'departement' => $departement,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="departement_delete", methods={"POST"})
     */
    public function delete(Request $request, Departement $departement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$departement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($departement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('departement_index', [], Response::HTTP_SEE_OTHER);
    }
}
