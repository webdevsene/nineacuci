<?php

namespace App\Controller;

use App\Entity\DbChange;
use App\Entity\Repertoire;
use App\Form\DbChangeType;
use App\Repository\DbChangeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Knp\Component\Pager\PaginatorInterface;

use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Csv as ReaderCsv;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * @Route("/journalisation/change")
 */
class DbChangeController extends AbstractController
{
    /**
     * @Route("/", name="app_db_change_index", methods={"GET", "POST"})
     */
    public function index(Request $request, EntityManagerInterface $entityManager, AuthorizationCheckerInterface $autorization, PaginatorInterface $paginator): Response
    {
        ini_set("memory_limit", -1);
        ini_set ( 'max_execution_time', -1);
        
        $dbChange = ""; 

        $tabNameFiltr = array('table_name' => "cuci_bilan",
                                          "cuci_compte_de_resultats",
                                          "cuci_etats_des_tresoreries",
                                          "cuci_immo_brut",
                                          "cuci_immo_plus",
                                          "cuci_effectifs_masse_salariale",
                                          "cuci_production_de_exercice",
                                          "cuci_achats_du_production",
                                          "cuci_bilansmt",
                                          "cuci_comptederesultat_smt",
                                          "cuci_repertoire" )
        ;

        // les actions en dure 
        $insert = "insert";
        $update  = "update";
        $delete = "delete";
        $nouveau_enr = "Nouveau enregistrement";
        $nouvelle_unite = "Nouvelle unite";
        
        /**if ($autorization->isGranted('ROLE_BSE_ADMIN')) {
            $dbChange = $entityManager->getRepository(DbChange::class)->findBy(array('action'=> array("insert", "update", "delete"), 'table_name'=>$tabNameFiltr), ['created_at'=>'DESC']);
        }
        
        if ($autorization->isGranted('ROLE_BREA_ADMIN') || $autorization->isGranted('ROLE_BSE_ADMIN')) {
            // separer la visualisation de l historique selon profile agent repertoire / agent etat financier
            $dbChange = $entityManager->getRepository(DbChange::class)->findBy(array('action'=> array("insert", "update", "delete"), 'table_name'=>'cuci_repertoire'), ['created_at'=>'DESC']);
        }        
        */

        $limits = 10;

        $conn = $this->getDoctrine()->getManager()->getConnection(); // cree la cnx 

        if ($autorization->isGranted('ROLE_SUPER_ADMIN') || $autorization->isGranted('ROLE_BREA_ADMIN') || $autorization->isGranted('ROLE_BSE_ADMIN')) {
            // separer la visualisation de l historique selon profile agent repertoire / agent etat financier
            //$sql = "SELECT * FROM cuci_ninea_db_journal_history WHERE cuci_ninea_db_journal_history.action='" .$insert. "' or cuci_ninea_db_journal_history.action='" .$update. "' or cuci_ninea_db_journal_history.action='".$delete."' or cuci_ninea_db_journal_history.action='".$nouvelle_unite."' or cuci_ninea_db_journal_history.action='".$nouveau_enr."'  ORDER BY  created_at DESC LIMIT 100;";
            $sql = "SELECT TOP 100 * FROM cuci_ninea_db_journal_history WHERE cuci_ninea_db_journal_history.action='" .$insert. "' or cuci_ninea_db_journal_history.action='" .$update. "' or cuci_ninea_db_journal_history.action='".$delete."' or cuci_ninea_db_journal_history.action='".$nouvelle_unite."' or cuci_ninea_db_journal_history.action='".$nouveau_enr."'  ORDER BY  created_at DESC ;";

            $dbChanges = $conn->prepare($sql);
            $stmt=$dbChanges->executeQuery();
            # $allChanges = $stmt->fetchAllAssociative();
            $donnees = $stmt->fetchAllAssociative();
            
            $articles = $paginator->paginate(
                $donnees, 
                $request->query->getInt('page', 1), 
                $limits,
            );

            
            /**if ($autorization->isGranted('ROLE_BREA_ADMIN') && $autorization->isGranted('ROLE_BSE_ADMIN')) {
                // separer la visualisation de l historique selon profile agent repertoire / agent etat financier
                $dbChange = $entityManager->getRepository(DbChange::class)->findBy(array('action'=> array("insert", "update", "delete")), ['created_at'=>'DESC']);
    
            }  */      
            
    
            // ajouter une operation pour exporter la table historique 
            if($request->get("filtrer")){
                
             return  DbChangeController::historyExcel($conn, $sql);
                 
            }

            if ($request->get("_actions")) {

                // TODO le traitement sql pour filtrer en fonction des inputs
                $_codecuci = $request->get("_codecuci");
                $_action = $request->get("_laction");
                $_anneefi = $request->get("_anneefi");
                $_table = $request->get("_tbl");

                $where= "";
                $req = "SELECT * FROM cuci_ninea_db_journal_history WHERE " ;
                
                if ($_action!="") {
                    $where=$where. "cuci_ninea_db_journal_history.action='".$_action."' ";
                }

                if ($_codecuci!="") {
                    $where=$where." and cuci_ninea_db_journal_history.code_cuci LIKE '%".$_codecuci."%' " ;
                }
                
                if($_table!=""){
                    $where=$where." and cuci_ninea_db_journal_history.tableau='".$_table."' ";
                }

                if($where==""){
                    
                    $req = "SELECT TOP 2000000 * FROM cuci_ninea_db_journal_history ;";
                    
                }else {
                    $req = "SELECT * FROM cuci_ninea_db_journal_history WHERE ".$where." ;" ;
                }
                
                $_donnees= $conn->prepare($req);
                $_donnees = $_donnees->executeQuery();
                $_donnees = $_donnees->fetchAllAssociative();

                if ($_donnees) {
                    
                    return DbChangeController::historyExcel2($_donnees);
                }

                return $this->redirectToRoute('app_db_change_index');

            }

        }
        

        return $this->render('db_change/index.html.twig', [
            // 'db_changes' => $allChanges,
            'articles' => $articles,
            'limits'=>$limits,
        ]);
    }



    public static function historyExcel($conn, $sql)
    {         

         // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $activeSheet = $spreadsheet->getActiveSheet();
        $spreadsheet->setActiveSheetIndex(0);
        $activeSheet->setTitle('Journal_donnees');
        $activeSheet->setCellValue('A1', 'CUCI')
                    ->setCellValue('B1', 'Action')
                    ->setCellValue('C1', 'Nom du Champ')
                    ->setCellValue('D1', 'Ancienne Valeur')
                    ->setCellValue('E1', 'Nouvelle Valeur')
                    ->setCellValue('F1', 'Date Saisie')
                    ->setCellValue('G1', 'Saisie Par')
                    ->setCellValue('H1', 'Date MAJ')
                    ->setCellValue('I1', 'MAJ Par')
        ;
            
            
        $i = 2;
            
        $allChanges = $conn->prepare($sql);            
        $stmt=$allChanges->executeQuery();
        $allDbChanges = $stmt->fetchAllAssociative();         
          
        foreach ($allDbChanges as $key_bilan ) {   

            $activeSheet->getCell('A'.$i)->setValueExplicit( $key_bilan['code_cuci'], DataType::TYPE_STRING2);
            $activeSheet->getCell('B'.$i)->setValueExplicit( $key_bilan['action'], DataType::TYPE_STRING2);
            $activeSheet->getCell('C'.$i)->setValueExplicit( $key_bilan['field_name'], DataType::TYPE_STRING2);
            $activeSheet->getCell('D'.$i)->setValueExplicit( $key_bilan['old_value'], DataType::TYPE_STRING2);
            $activeSheet->getCell('E'.$i)->setValueExplicit( $key_bilan['new_value'], DataType::TYPE_STRING2);
            $activeSheet->getCell('F'.$i)->setValueExplicit( $key_bilan['dateSaisie'], DataType::TYPE_STRING2);
            $activeSheet->getCell('G'.$i)->setValueExplicit( $key_bilan['saisiePar'], DataType::TYPE_STRING2);
            $activeSheet->getCell('H'.$i)->setValueExplicit( $key_bilan['created_at'], DataType::TYPE_STRING2);
            $activeSheet->getCell('I'.$i)->setValueExplicit( $key_bilan['userID'], DataType::TYPE_STRING2);
                    
            $i++; 
                    
  
        }

        $styleArrayFirstRow = [
            'font' => [
                'bold' => true,
            ]
        ];


        foreach (range('A1', 'I1') as $row) {
            //set first row bold
            $activeSheet->getStyle('A1:' . 'I1' )->applyFromArray($styleArrayFirstRow);
            $activeSheet->getColumnDimension($row)->setAutoSize(true); 

        }

           
               
        // $writer = new Xlsx($spreadsheet);
        $writer = new Csv($spreadsheet);
        //$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $fileName = "journals2021.csv";
        
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        
        // Create the excel file in the tmp directory of the system
        $writer->save($temp_file);

        $response = new BinaryFileResponse($temp_file);
        
        // Return the excel file as an attachment
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $fileName
        );
        $contentType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
        $response->headers->set('Content-Type', $contentType);
        $response->headers->set("Content-Disposition", $disposition);
        return $response;


    }


    public static function historyExcel2($allDbChanges)
    {

         // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $activeSheet = $spreadsheet->getActiveSheet();
        $spreadsheet->setActiveSheetIndex(0);
        $activeSheet->setTitle('Journal_donnees');
        $activeSheet->setCellValue('A1', 'CUCI')
                    ->setCellValue('B1', 'Action')
                    ->setCellValue('C1', 'Nom du Champ')
                    ->setCellValue('D1', 'Ancienne Valeur')
                    ->setCellValue('E1', 'Nouvelle Valeur')
                    ->setCellValue('F1', 'Date Saisie')
                    ->setCellValue('G1', 'Saisie Par')
                    ->setCellValue('H1', 'Date MAJ')
                    ->setCellValue('I1', 'MAJ Par')
        ;            
            
        $i = 2;
            
        // $allChanges = $conn->prepare($sql);            
        // $stmt=$allChanges->executeQuery();
        // $allDbChanges = $stmt->fetchAllAssociative();         
          
        foreach ($allDbChanges as $key_bilan ) {

            $activeSheet->getCell('A'.$i)->setValueExplicit( $key_bilan['code_cuci'], DataType::TYPE_STRING2);
            $activeSheet->getCell('B'.$i)->setValueExplicit( $key_bilan['action'], DataType::TYPE_STRING2);
            $activeSheet->getCell('C'.$i)->setValueExplicit( $key_bilan['field_name'], DataType::TYPE_STRING2);
            $activeSheet->getCell('D'.$i)->setValueExplicit( $key_bilan['old_value'], DataType::TYPE_STRING2);
            $activeSheet->getCell('E'.$i)->setValueExplicit( $key_bilan['new_value'], DataType::TYPE_STRING2);
            $activeSheet->getCell('F'.$i)->setValueExplicit( $key_bilan['dateSaisie'], DataType::TYPE_STRING2);
            $activeSheet->getCell('G'.$i)->setValueExplicit( $key_bilan['saisiePar'], DataType::TYPE_STRING2);
            $activeSheet->getCell('H'.$i)->setValueExplicit( $key_bilan['created_at'], DataType::TYPE_STRING2);
            $activeSheet->getCell('I'.$i)->setValueExplicit( $key_bilan['userID'], DataType::TYPE_STRING2);
                    
            $i++; 
                    
  
        }

        $styleArrayFirstRow = [
            'font' => [
                'bold' => true,
            ]
        ];


        foreach (range('A1', 'I1') as $row) {
            //set first row bold
            $activeSheet->getStyle('A1:' . 'I1' )->applyFromArray($styleArrayFirstRow);
            $activeSheet->getColumnDimension($row)->setAutoSize(true);
        }           
               
        // $writer = new Xlsx($spreadsheet);
        $writer = new Csv($spreadsheet);
        //$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $fileName = "journals2021.csv";
        
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        
        // Create the excel file in the tmp directory of the system
        $writer->save($temp_file);

        $response = new BinaryFileResponse($temp_file);
        
        // Return the excel file as an attachment
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $fileName
        );
       
        $response->headers->set('Content-Type', "text/csv; charset=utf-8");
        $response->headers->set("Content-Disposition", $disposition);
        return $response;

    }



    /**
     * @Route("/new", name="app_db_change_new", methods={"GET", "POST"})
     */
    public function new(Request $request, DbChangeRepository $dbChangeRepository): Response
    {
        $dbChange = new DbChange();
        $form = $this->createForm(DbChangeType::class, $dbChange);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dbChangeRepository->add($dbChange, true);

            return $this->redirectToRoute('app_db_change_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('db_change/new.html.twig', [
            'db_change' => $dbChange,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_db_change_show", methods={"GET"})
     */
    public function show(DbChange $dbChange): Response
    {
        return $this->render('db_change/show.html.twig', [
            'db_change' => $dbChange,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_db_change_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, DbChange $dbChange, DbChangeRepository $dbChangeRepository): Response
    {
        $form = $this->createForm(DbChangeType::class, $dbChange);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dbChangeRepository->add($dbChange, true);

            return $this->redirectToRoute('app_db_change_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('db_change/edit.html.twig', [
            'db_change' => $dbChange,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_db_change_delete", methods={"POST"})
     */
    public function delete(Request $request, DbChange $dbChange, DbChangeRepository $dbChangeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dbChange->getId(), $request->request->get('_token'))) {
            $dbChangeRepository->remove($dbChange, true);
        }

        return $this->redirectToRoute('app_db_change_index', [], Response::HTTP_SEE_OTHER);
    }


    
}
