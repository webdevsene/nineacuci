<?php

namespace App\Controller;

use App\Entity\CAV;
use App\Entity\Departement;
use App\Form\CAVType;
use App\Repository\CAVRepository;
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
 * @Route("/cav")
 * @IsGranted("ROLE_USER")
 */
class CAVController extends AbstractController
{
    /**
     * @Route("/", name="cav_index", methods={"GET"})
     */
    public function index(CAVRepository $cAVRepository): Response
    {
        return $this->render('cav/index.html.twig', [
            'c_a_vs' => $cAVRepository->findAll(),
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
     *  @Route("/importCav", name="importCav")
     *  @param Request $request
     *  @throws \Exception
     *  @return void
     */
    public function importCav(Request $request, EntityManagerInterface $entityManager)
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
        $mapColumns = CAVController::mapExcelColumns($spreadsheet);
        
        // // TODO: verifie l'existence des col d'entêtes 
        // ici on definit /c'est notre model qvh different de celui de pigor
        $excelColonnes = [
            'codeCav', 'libelle', 'codeDep',
        ];
        // avec code region correspond à dep_id dans la table donc deId dans l'entité

        
        // on verifie physiquement 
        $col = CAVController::excelNotFoundColumnException($excelColonnes, $mapColumns);

        // affiche à l'utilisateur un mssage d'erreur si le template ne suit pas ce format
        if (!empty($col)) {
            $this->addFlash(
                'danger',
                "La colonne <strong> {$col} </strong> n'est pas définie dans le fichier Excel. Merci de vous référer sur le template de base !"
            );
            return $this->redirectToRoute('cav_new'); // pour le moment on retourne la page new
        }

         // Récupère les index ou la position de chaque colonne
         $code_dep_index = array_search("codeCav", $mapColumns, true);
         $libelle_dep_index = array_search("libelle", $mapColumns, true);
         $code_reg_dep_index = array_search("codeDep", $mapColumns, true); 

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
                
                $isDepexists = $entityManager->getRepository(CAV::class)->findOneBy(['codeCav' => $_code]);

               
                
                
                // TODO: Permet de tester si le QVH existe déjà !
                if (!$isDepexists) {
                    
                    // $var_region = $this->regionRepo->findOneBy(['regCD' => $_code_reg_dep]);

                    $dep = $entityManager->getRepository(Departement::class)->findOneBy(['codeDep' => $_code_dep]);

                    
                    
                    $cav_obj = new CAV;
                    
                    $cav_obj->setCodeCav($_code)
                    ->setLibelle($_description)
                    ->setCavDEPID($dep)
                    ;                 
                    


                    if ($dep != NULL) {
                        // persist ssi tu trouves le CACR du QVH
                        $entityManager->persist($cav_obj);
                    }
                    $entityManager->flush();
                 }
           
        }
        
        return $this->redirectToRoute('cav_new');
    }


    /**
     * @Route("/new", name="cav_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,CAVRepository $cAVRepository): Response
    {
        

        return $this->renderForm('cav/new.html.twig', [
           'cav' => $cAVRepository->findAll(),
        ]);
    }

     /**
     * @Route("/cacrCav/{id}", name="cacrCav", methods={"GET"})
     */
    public function cacrCav( $id="")
    {
         $tab=[];
         $cav=$this->getDoctrine()->getRepository(CAV::class)->find($id);
         foreach ($cav->getCACRs() as $key ) {

             array_push($tab,[$key->getId(),$key->getLibelle()]);
         }        
        return new JsonResponse( $tab);
    }

    /**
     * @Route("/{id}", name="c_a_v_show", methods={"GET"})
     */
    public function show(CAV $cAV): Response
    {
        return $this->render('cav/show.html.twig', [
            'c_a_v' => $cAV,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cav_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CAV $cAV, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CAVType::class, $cAV);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('c_a_v_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cav/edit.html.twig', [
            'c_a_v' => $cAV,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="cav_delete", methods={"POST"})
     */
    public function delete(Request $request, CAV $cAV, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cAV->getId(), $request->request->get('_token'))) {
            $entityManager->remove($cAV);
            $entityManager->flush();
        }

        return $this->redirectToRoute('c_a_v_index', [], Response::HTTP_SEE_OTHER);
    }
}
