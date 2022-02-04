<?php

namespace App\Controller;

use App\Entity\QVH;
use App\Entity\CACR;
use App\Form\QVHType;
use App\Repository\QVHRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
/**
 * @Route("/qvh")
 */
class QVHController extends AbstractController
{
    /**
     * @Route("/", name="q_v_h_index", methods={"GET"})
     */
    public function index(QVHRepository $qVHRepository): Response
    {
        return $this->render('qvh/index.html.twig', [
            'q_v_hs' => $qVHRepository->findAll(),
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
     *  @Route("/importQvh", name="importQvh")
     *  @param Request $request
     *  @throws \Exception
     *  @return void
     */
    public function importQvh(Request $request, EntityManagerInterface $entityManager)
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
        $mapColumns = QVHController::mapExcelColumns($spreadsheet);
        
        // // TODO: verifie l'existence des col d'entêtes 
        // ici on definit /c'est notre model qvh different de celui de pigor
        $excelColonnes = [
            'codeQvh', 'libelle', 'codeCacr',
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
            return $this->redirectToRoute('qvh_new'); // pour le moment on retourne la page new
        }

         // Récupère les index ou la position de chaque colonne
         $code_dep_index = array_search("codeQvh", $mapColumns, true);
         $libelle_dep_index = array_search("libelle", $mapColumns, true);
         $code_reg_dep_index = array_search("codeCacr", $mapColumns, true); 

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
                
                $isDepexists = $entityManager->getRepository(QVH::class)->findOneBy(['codeQvh' => $_code]);

               
                
                
                // TODO: Permet de tester si le QVH existe déjà !
                if (!$isDepexists) {
                    
                    // $var_region = $this->regionRepo->findOneBy(['regCD' => $_code_reg_dep]);

                    $cav = $entityManager->getRepository(CACR::class)->findOneBy(['id' => $_code_dep]);
                   

                    
                    
                    $cav_obj = new QVH;
                    
                   
                    $cav_obj->setId($_code);
                    $cav_obj->setCodeQvh($_code);

                    $cav_obj->setLibelle($_description);
                    $cav_obj->setQvhCACRID($cav);
                    ;                 
                    
                    

                    if ($cav != NULL) {
                        // persist ssi tu trouves le CACR du QVH
                        $entityManager->persist($cav_obj);
                    }
                    $entityManager->flush();
                 }
           
        }
        
        return $this->redirectToRoute('qvh_new');
    }

    /**
     * @Route("/new", name="qvh_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,QVHRepository $qVHRepository): Response
    {
      

        return $this->renderForm('qvh/new.html.twig', [
           'qvh' => $qVHRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="q_v_h_show", methods={"GET"})
     */
    public function show(QVH $qVH): Response
    {
        return $this->render('qvh/show.html.twig', [
            'q_v_h' => $qVH,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="q_v_h_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, QVH $qVH, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(QVHType::class, $qVH);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('q_v_h_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('qvh/edit.html.twig', [
            'q_v_h' => $qVH,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="q_v_h_delete", methods={"POST"})
     */
    public function delete(Request $request, QVH $qVH, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$qVH->getId(), $request->request->get('_token'))) {
            $entityManager->remove($qVH);
            $entityManager->flush();
        }

        return $this->redirectToRoute('q_v_h_index', [], Response::HTTP_SEE_OTHER);
    }
}
