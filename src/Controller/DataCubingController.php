<?php

namespace App\Controller;

use App\Entity\Bilan;
use App\Entity\Category;
use App\Entity\CompteDeResultats;
use App\Entity\CuciImmoPlus;
use App\Entity\Effectifs;
use App\Entity\FluxDesTresoreries;
use App\Entity\ImmoBrut;
use App\Entity\Repertoire;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Writer\Ods;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

 /**
     * @IsGranted("ROLE_USER")
     */

class DataCubingController extends AbstractController
{
    /**
     * @Route("/data/cubing", name="app_data_cubing")
     *
     */
    public function index(Request $request): Response
    {
        // recuperer les parametres du formulaire 
        ini_set("memory_limit", -1);
        ini_set ( 'max_execution_time', -1);
        $fileName = "rapportAnnee.xlsx";
        if ($request->get('debut-periode-input')) {
            
            $annee = $request->get('debut-periode-input');

            $spreadsheet = new Spreadsheet();
            $activeSheet = $spreadsheet->getActiveSheet();
            $spreadsheet->setActiveSheetIndex(0);
           
            $activeSheet->setCellValue('A1', 'TABLEAU')
                         ->setCellValue('B1', 'CODE CUCI')
                         ->setCellValue('C1', 'OPERATIONS')
                         ->setCellValue('D1', 'STATUT')
                         ->setCellValue('E1', 'EXERCICE')
                         ->setCellValue('F1', 'VALEUR')
                         ->setCellValue('G1', 'ANNEE SOURCE');
            $i = 2;
            $conn = $this->getDoctrine()->getManager()->getConnection();
           
            if($request->get('table')==1){

              $act="Actif";
              $pass="Passif";
              $sql = "SELECT ref_code, annee_financiere,brut,amort_pr, net1,net2, code_cuci, cuci_bilan.type as cat FROM cuci_bilan inner join cuci_repertoire on cuci_repertoire.id=cuci_bilan.repertoire_id where cuci_bilan.type='".$act."' and cuci_bilan.annee_financiere=".$annee."  ORDER BY  ref_code ASC ,code_cuci ASC ;";
              $tousBilans = $conn->prepare($sql);
              $stmt=$tousBilans->executeQuery();
              $tousBilansActif = $stmt->fetchAllAssociative();
              $activeSheet->setTitle('Bilan actif');
            

              $sql = "SELECT ref_code, annee_financiere, net1,net2, code_cuci, cuci_bilan.type as cat FROM cuci_bilan inner join cuci_repertoire on cuci_repertoire.id=cuci_bilan.repertoire_id where cuci_bilan.type='".$pass."' and cuci_bilan.annee_financiere=".$annee."  ORDER BY  ref_code ASC ,code_cuci ASC ;";
              $tousBilans = $conn->prepare($sql);
              $stmt=$tousBilans->executeQuery();
              $tousBilansPassif = $stmt->fetchAllAssociative();

              $fileName = "bilan".$annee.".xlsx";
            
              $indice=0;
              foreach ($tousBilansActif as $key_bilan ) {

                
                if ($key_bilan['cat']=="Actif") {
                   
                   if($key_bilan['brut']){
                     // traitement des valeurs brut
                     $activeSheet->getCell('A'.$i)->setValueExplicit( "Bilan actif", DataType::TYPE_STRING2);
                     $activeSheet->getCell('B'.$i)->setValueExplicit( $key_bilan['code_cuci'], DataType::TYPE_STRING2);
                     $activeSheet->getCell('C'.$i)->setValueExplicit( $key_bilan['ref_code'], DataType::TYPE_STRING2);
                     $activeSheet->getCell('D'.$i)->setValueExplicit( "BRUT", DataType::TYPE_STRING2);
                     $activeSheet->getCell('E'.$i)->setValueExplicit( $key_bilan['annee_financiere'], DataType::TYPE_STRING2);
                     $activeSheet->getCell('F'.$i)->setValueExplicit( $key_bilan['brut'], DataType::TYPE_STRING2);
                     $activeSheet->getCell('G'.$i)->setValueExplicit( $key_bilan['annee_financiere'], DataType::TYPE_STRING2);
                     $i++; 
                   }

                   if($key_bilan['amort_pr']){
                      // traitement des valeurs ammo
                    $activeSheet->getCell('A'.$i)->setValueExplicit( "Bilan actif", DataType::TYPE_STRING2);
                    $activeSheet->getCell('B'.$i)->setValueExplicit( $key_bilan['code_cuci'], DataType::TYPE_STRING2);
                    $activeSheet->getCell('C'.$i)->setValueExplicit( $key_bilan['ref_code'], DataType::TYPE_STRING2);
                    $activeSheet->getCell('D'.$i)->setValueExplicit( "AMMO", DataType::TYPE_STRING2);
                    $activeSheet->getCell('E'.$i)->setValueExplicit( $key_bilan['annee_financiere'], DataType::TYPE_STRING2);
                    $activeSheet->getCell('F'.$i)->setValueExplicit( $key_bilan['amort_pr'], DataType::TYPE_STRING2);
                    $activeSheet->getCell('G'.$i)->setValueExplicit( $key_bilan['annee_financiere'], DataType::TYPE_STRING2);
                    $i++; 
                   }
                    
                   if($key_bilan['net1']){
                    // traitement des valeurs NET2 de N
                    $activeSheet->getCell('A'.$i)->setValueExplicit( "Bilan actif", DataType::TYPE_STRING2);
                    $activeSheet->getCell('B'.$i)->setValueExplicit( $key_bilan['code_cuci'], DataType::TYPE_STRING2);
                    $activeSheet->getCell('C'.$i)->setValueExplicit( $key_bilan['ref_code'], DataType::TYPE_STRING2);
                    $activeSheet->getCell('D'.$i)->setValueExplicit( "NET1", DataType::TYPE_STRING2);
                    $activeSheet->getCell('E'.$i)->setValueExplicit( $key_bilan['annee_financiere'], DataType::TYPE_STRING2);
                    $activeSheet->getCell('F'.$i)->setValueExplicit( $key_bilan['net1'], DataType::TYPE_STRING2);
                    $activeSheet->getCell('G'.$i)->setValueExplicit( $key_bilan['annee_financiere'], DataType::TYPE_STRING2);
                    $i++; 
                   }

                   if($key_bilan['net2']){
                     // traitement des valeurs NET2 de N
                     $activeSheet->getCell('A'.$i)->setValueExplicit( "Bilan actif", DataType::TYPE_STRING2);
                     $activeSheet->getCell('B'.$i)->setValueExplicit( $key_bilan['code_cuci'], DataType::TYPE_STRING2);
                     $activeSheet->getCell('C'.$i)->setValueExplicit( $key_bilan['ref_code'], DataType::TYPE_STRING2);
                     $activeSheet->getCell('D'.$i)->setValueExplicit( "NET2", DataType::TYPE_STRING2);
                     $activeSheet->getCell('E'.$i)->setValueExplicit( $key_bilan['annee_financiere']-1, DataType::TYPE_STRING2);
                     $activeSheet->getCell('F'.$i)->setValueExplicit( $key_bilan['net2'], DataType::TYPE_STRING2);
                     $activeSheet->getCell('G'.$i)->setValueExplicit( $key_bilan['annee_financiere'], DataType::TYPE_STRING2);
                     $i++; 
                   }
                    
                  
  
                } 
                
              }

              $activeSheet = $spreadsheet->createSheet();
              $activeSheet->setTitle('Bilan Passif');
              $activeSheet->setCellValue('A1', 'TABLEAU')
              ->setCellValue('B1', 'CODE CUCI')
              ->setCellValue('C1', 'OPERATIONS')
              ->setCellValue('D1', 'STATUT')
              ->setCellValue('E1', 'EXERCICE')
              ->setCellValue('F1', 'VALEUR')
              ->setCellValue('G1', 'ANNEE SOURCE');
              $i = 2;
              foreach ($tousBilansPassif as $key_bilan ) {

                
                if ($key_bilan['cat']=="Passif") {

                    if($key_bilan['net1']){
                    // exporter les valeurs NET1
                    $activeSheet->getCell('A'.$i)->setValueExplicit( "Bilan passif", DataType::TYPE_STRING2);
                    $activeSheet->getCell('B'.$i)->setValueExplicit( $key_bilan['code_cuci'], DataType::TYPE_STRING2);
                    $activeSheet->getCell('C'.$i)->setValueExplicit( $key_bilan['ref_code'], DataType::TYPE_STRING2);
                    $activeSheet->getCell('D'.$i)->setValueExplicit( "NET1", DataType::TYPE_STRING2);
                    $activeSheet->getCell('E'.$i)->setValueExplicit( $key_bilan['annee_financiere'], DataType::TYPE_STRING2);
                    $activeSheet->getCell('F'.$i)->setValueExplicit( $key_bilan['net1'], DataType::TYPE_STRING2);
                    $activeSheet->getCell('G'.$i)->setValueExplicit( $key_bilan['annee_financiere'], DataType::TYPE_STRING2);
                    $i++;
                    }
                    

                    if($key_bilan['net2']){
                     // exporter les valeurs NET2 
                     $activeSheet->getCell('A'.$i)->setValueExplicit( "Bilan passif", DataType::TYPE_STRING2);
                     $activeSheet->getCell('B'.$i)->setValueExplicit( $key_bilan['code_cuci'], DataType::TYPE_STRING2);
                     $activeSheet->getCell('C'.$i)->setValueExplicit( $key_bilan['ref_code'], DataType::TYPE_STRING2);
                     $activeSheet->getCell('D'.$i)->setValueExplicit( "NET2", DataType::TYPE_STRING2);
                     $activeSheet->getCell('E'.$i)->setValueExplicit( $key_bilan['annee_financiere']-1, DataType::TYPE_STRING2);
                     $activeSheet->getCell('F'.$i)->setValueExplicit( $key_bilan['net2'], DataType::TYPE_STRING2);
                     $activeSheet->getCell('G'.$i)->setValueExplicit( $key_bilan['annee_financiere'], DataType::TYPE_STRING2);
                     $i++;
                    }

                   

                    
                    
                }else {
                    # code...
                }
                
              }


            }elseif($request->get('table')==2){
              $sql = 'SELECT ref_code, annee_financiere, net1,net2 ,code_cuci FROM cuci_compte_de_resultats inner join cuci_repertoire on cuci_repertoire.id=cuci_compte_de_resultats.cuci_rep_code_id where cuci_compte_de_resultats.annee_financiere='.$annee;
              $tousComptes = $conn->prepare($sql);
              $stmt=$tousComptes->executeQuery();
              $tousComptes= $stmt->fetchAllAssociative();

              $fileName = "comptederesultats".$annee.".xlsx";
              $activeSheet->setTitle('Compte de resultats');
              $indice=0;
              // compte de resultats put into xlsx file 
              foreach ($tousComptes as $key_compte ) {
                if($key_compte['net1']){     
                /// compte resultat NET1
                $activeSheet->getCell('A'.$i)->setValueExplicit( "Compte de résultats", DataType::TYPE_STRING2);
                $activeSheet->getCell('B'.$i)->setValueExplicit( $key_compte['code_cuci'], DataType::TYPE_STRING2);
                $activeSheet->getCell('C'.$i)->setValueExplicit( $key_compte['ref_code'], DataType::TYPE_STRING2);
                $activeSheet->getCell('D'.$i)->setValueExplicit( "NET1", DataType::TYPE_STRING2);
                $activeSheet->getCell('E'.$i)->setValueExplicit( $key_compte['annee_financiere'], DataType::TYPE_STRING2);
                $activeSheet->getCell('F'.$i)->setValueExplicit( $key_compte['net1'], DataType::TYPE_STRING2);
                $activeSheet->getCell('G'.$i)->setValueExplicit( $key_compte['annee_financiere'], DataType::TYPE_STRING2);
                
                $i++;
                }
                if($key_compte['net2']){
                /// compte resultat NET1
                $activeSheet->getCell('A'.$i)->setValueExplicit( "Compte de résultats", DataType::TYPE_STRING2);
                $activeSheet->getCell('B'.$i)->setValueExplicit( $key_compte['code_cuci'], DataType::TYPE_STRING2);
                $activeSheet->getCell('C'.$i)->setValueExplicit( $key_compte['ref_code'], DataType::TYPE_STRING2);
                $activeSheet->getCell('D'.$i)->setValueExplicit( "NET2", DataType::TYPE_STRING2);
                $activeSheet->getCell('E'.$i)->setValueExplicit( $key_compte['annee_financiere']-1, DataType::TYPE_STRING2);
                $activeSheet->getCell('F'.$i)->setValueExplicit( $key_compte['net2'], DataType::TYPE_STRING2);
                $activeSheet->getCell('G'.$i)->setValueExplicit( $key_compte['annee_financiere'], DataType::TYPE_STRING2);
                
                $i++;
                }


               
              }


            }else{
              $sql = 'SELECT ref_code, annee_financiere, net1,net2, code_cuci FROM cuci_etats_des_tresoreries inner join cuci_repertoire on cuci_repertoire.id=cuci_etats_des_tresoreries.cuci_rep_code_id where cuci_etats_des_tresoreries.annee_financiere='.$annee;
              $tousFluxTresor = $conn->prepare($sql);
              $tousFluxTresor=$tousFluxTresor->executeQuery()->fetchAllAssociative();
              $fileName = "fluxdetresorerie".$annee.".xlsx";
              $activeSheet->setTitle('Flux de tresorerie');
               // put content of flux de tresorerie into xlsx file 
              foreach ($tousFluxTresor as $key_tresoreri ) {
                ////traitement du NET2
                if($key_tresoreri['net1']){
                $activeSheet->getCell('A'.$i)->setValueExplicit( "Flux de trÃƒÂ©sorerie", DataType::TYPE_STRING2);
                $activeSheet->getCell('B'.$i)->setValueExplicit( $key_tresoreri['code_cuci'], DataType::TYPE_STRING2);
                $activeSheet->getCell('C'.$i)->setValueExplicit( $key_tresoreri['ref_code'], DataType::TYPE_STRING2);
                $activeSheet->getCell('D'.$i)->setValueExplicit( "NET1", DataType::TYPE_STRING2);
                $activeSheet->getCell('E'.$i)->setValueExplicit( $key_tresoreri['annee_financiere'], DataType::TYPE_STRING2);
                $activeSheet->getCell('F'.$i)->setValueExplicit( $key_tresoreri['net1'], DataType::TYPE_STRING2);
                $activeSheet->getCell('G'.$i)->setValueExplicit( $key_tresoreri['annee_financiere'], DataType::TYPE_STRING2);
                
                $i++;
                }

                if($key_tresoreri['net2']){
                $activeSheet->getCell('A'.$i)->setValueExplicit( "Flux de trÃƒÂ©sorerie", DataType::TYPE_STRING2);
                $activeSheet->getCell('B'.$i)->setValueExplicit( $key_tresoreri['code_cuci'], DataType::TYPE_STRING2);
                $activeSheet->getCell('C'.$i)->setValueExplicit( $key_tresoreri['ref_code'], DataType::TYPE_STRING2);
                $activeSheet->getCell('D'.$i)->setValueExplicit( "NET2", DataType::TYPE_STRING2);
                $activeSheet->getCell('E'.$i)->setValueExplicit( $key_tresoreri['annee_financiere']-1, DataType::TYPE_STRING2);
                $activeSheet->getCell('F'.$i)->setValueExplicit( $key_tresoreri['net2'], DataType::TYPE_STRING2);
                $activeSheet->getCell('G'.$i)->setValueExplicit( $key_tresoreri['annee_financiere'], DataType::TYPE_STRING2);
                
                $i++;
                }



              }
            }

            $styleArrayFirstRow = [
                    'font' => [
                        'bold' => true,
                    ]
                ];


            foreach (range('A1', 'G1') as $row) {
                //set first row bold
                $activeSheet->getStyle('A1:' . 'G1' )->applyFromArray($styleArrayFirstRow);
                $activeSheet->getColumnDimension($row)->setAutoSize(true); 

            }

            //output headers
            // $activeSheet->fromArray(array_keys($columnNames, NULL, 'A1'));
            
            
           // $writer = new Csv($spreadsheet);

            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

            
            
            $temp_file = tempnam(sys_get_temp_dir(), $fileName);
            
            // Create the excel file in the tmp directory of the system
            $writer->save($temp_file);

            $response = new BinaryFileResponse($temp_file);
            
            // Return the excel file as an attachment
            $disposition = $response->headers->makeDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                $fileName
            );
           // $contentType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
           $contentType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
           $response->headers->set('Content-Type', $contentType);
           $response->headers->set("Content-Disposition", $disposition);
            
            return $response;
            //$writer->save('php://output');
            
        }

        return $this->render('data_cubing/index.html.twig', [
            'controller_name' => 'DataCubingController',
        ]);
    }



    /**
     * @Route("/data/effectifMasseSalarialeReport", name="effectifMasseSalarialeReport", methods={"GET", "POST"})
     */
    public function effectifMasseSalarialeReport(Request $request): Response
    {
        
        if ($request->get('annee-input')) { // quand le btn submit est envoye
            
            $annee = $request->get('annee-input');
            $codeCuci = $request->get('cuci-input'); 
            
            $effectifs_by_annee = $this->getDoctrine()->getRepository(Effectifs::class)->findByCodeCuci($codeCuci, $annee,'Effectif');


            $personnel_by_annee = $this->getDoctrine()->getRepository(Effectifs::class)->findByCodeCuci($codeCuci, $annee,'Personnel');

            $spreadsheet = new Spreadsheet(); 

            $sheet = null ;
            
            // Create a new worksheet called "Interne and a nother called Externe"
            $interne_sheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Interne');
            $ext_sheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Externe');
            
            // Attach the "Interne", "Externe" worksheet as the first worksheet in the Spreadsheet object
            $spreadsheet->addSheet($interne_sheet, 0);     
            $spreadsheet->addSheet($ext_sheet, 1); 

            $i=2; $j=2;
            
            
            if (!$effectifs_by_annee) {
                $request->getSession()->getFlashBag()->add('notice', 'Aucune donnée trouvée pour cette recherche !.');

                return $this->redirectToRoute("effectifMasseSalarialeReport");
            }else{
                $spreadsheet->setActiveSheetIndex(0);            
                $spreadsheet->getDefaultStyle()->getFont()->setName('Calibri');
                /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
                $sheet = $spreadsheet->getActiveSheet();

                $sheet->setCellValue('A1', 'CODE CUCI')
                ->setCellValue('B1', 'ANNEE')
                ->setCellValue('C1', 'EFF_NAT_MASCULIN')
                ->setCellValue('D1', 'EFF_NAT_FEMININ')
                ->setCellValue('E1', 'EFF_OHADA_M')
                ->setCellValue('F1', 'EFF_OHADA_F')
                ->setCellValue('G1', 'EFF_HORS_OHADA_M')
                ->setCellValue('H1', 'EFF_HORS_OHADA_F')
                ->setCellValue('I1', 'EFF_TOTAL')
                ->setCellValue('J1', 'MS_NAT_M')
                ->setCellValue('K1', 'MS_NAT_F')
                ->setCellValue('L1', 'MS_OHADA_M')
                ->setCellValue('M1', 'MS_OHADA_F')
                ->setCellValue('N1', 'MS_HORS_OHADA_M')
                ->setCellValue('O1', 'MS_HORS_OHADA_F')
                ->setCellValue('P1', 'MS_TOT')
                ->setCellValue('Q1', 'QUALIFICATION');


                
                foreach ($effectifs_by_annee as $key ) {


                    $sheet->getCell('A'.$i)->setValueExplicit($key->getRepertoire()->getCodeCuci(), DataType::TYPE_STRING2);
                    $sheet->getCell('B'.$i)->setValueExplicit($key->getAnneeFinanciere(), DataType::TYPE_STRING2);

                    $sheet->getCell('C'.$i)->setValueExplicit( $key->getNmef(), DataType::TYPE_STRING2);
                    $sheet->getCell('D'.$i)->setValueExplicit( $key->getNfef(), DataType::TYPE_STRING2);

                    $sheet->getCell('E'.$i)->setValueExplicit( $key->getUmmef(), DataType::TYPE_STRING2);
                    $sheet->getCell('F'.$i)->setValueExplicit( $key->getUmfef(), DataType::TYPE_STRING2);

                    $sheet->getCell('G'.$i)->setValueExplicit( $key->getHmmef(), DataType::TYPE_STRING2);
                    $sheet->getCell('H'.$i)->setValueExplicit( $key->getHmfef(), DataType::TYPE_STRING2);

                    $sheet->getCell('I'.$i)->setValueExplicit( $key->getTotalEf(), DataType::TYPE_STRING2);

                    $sheet->getCell('J'.$i)->setValueExplicit( $key->getMnmef(), DataType::TYPE_STRING2);
                    $sheet->getCell('K'.$i)->setValueExplicit( $key->getMnfef(), DataType::TYPE_STRING2);

                    $sheet->getCell('L'.$i)->setValueExplicit( $key->getMummef(), DataType::TYPE_STRING2);
                    $sheet->getCell('M'.$i)->setValueExplicit( $key->getMumfef(), DataType::TYPE_STRING2);

                    $sheet->getCell('N'.$i)->setValueExplicit( $key->getMhmmef(), DataType::TYPE_STRING2);
                    $sheet->getCell('O'.$i)->setValueExplicit( $key->getMhmfef(), DataType::TYPE_STRING2);

                    $sheet->getCell('P'.$i)->setValueExplicit( $key->getTotalMs(), DataType::TYPE_STRING2);
                    $sheet->getCell('Q'.$i)->setValueExplicit( $key->getRefCode(), DataType::TYPE_STRING2);
                    
                    $i++;
                    
                }


            }

            if (!$personnel_by_annee) {
                $request->getSession()->getFlashBag()->add('notice', 'Aucune donnée trouvée pour cette recherche !.');

                return $this->redirectToRoute("effectifMasseSalarialeReport");
            }else{

                $spreadsheet->setActiveSheetIndex(1);            
                /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
                $sheet = $spreadsheet->getActiveSheet();


                // set header load entete MF
                $sheet->setCellValue('A1', 'CODE CUCI');
                $sheet->setCellValue('B1', 'ANNEE');
                $sheet->setCellValue('C1', 'PERS_NAT_M');
                $sheet->setCellValue('D1', 'PERS_NAT_F');
                $sheet->setCellValue('E1', 'PERS_OHADA_M');
                $sheet->setCellValue('F1', 'PERS_OHADA_F');
                $sheet->setCellValue('G1', 'PERS_HORS_OHADA_M');
                $sheet->setCellValue('H1', 'PERS_HORS_OHADA_F');
                $sheet->setCellValue('I1', 'PERS_Total');
                $sheet->setCellValue('J1', 'Fac M');
                $sheet->setCellValue('K1', 'Fact F');


                foreach ($personnel_by_annee as $key ) {

                    $sheet->getCell('A'.$j)->setValueExplicit($key->getRepertoire()->getCodeCuci(), DataType::TYPE_STRING2);
                    $sheet->getCell('B'.$j)->setValueExplicit($key->getAnneeFinanciere(), DataType::TYPE_STRING2);

                    $sheet->getCell('C'.$j)->setValueExplicit( $key->getNmef(), DataType::TYPE_STRING2);
                    $sheet->getCell('D'.$j)->setValueExplicit( $key->getNfef(), DataType::TYPE_STRING2);

                    $sheet->getCell('E'.$j)->setValueExplicit( $key->getUmmef(), DataType::TYPE_STRING2);
                    $sheet->getCell('F'.$j)->setValueExplicit( $key->getUmfef(), DataType::TYPE_STRING2);

                    $sheet->getCell('G'.$j)->setValueExplicit( $key->getHmmef(), DataType::TYPE_STRING2);
                    $sheet->getCell('H'.$j)->setValueExplicit( $key->getHmfef(), DataType::TYPE_STRING2);

                    $sheet->getCell('I'.$j)->setValueExplicit( $key->getTotalEf(), DataType::TYPE_STRING2);

                    $sheet->getCell('J'.$j)->setValueExplicit( $key->getFacm(), DataType::TYPE_STRING2);
                    $sheet->getCell('K'.$j)->setValueExplicit( $key->getFacf(), DataType::TYPE_STRING2);

                    $j++;

                }

            }

            
            $writer = new Xlsx($spreadsheet);

            $fileName = "Effectifs.xlsx";
            
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

        
        return $this->render('data_cubing/effectif_masse_salariale_report.html.twig', [
            'controller_name' => 'DataCubingController',
        ]);

    }



    /**
     * @Route("/data/exportation_par_cuci_annee_type", name="export_par_cuci_annee_type")
     */
    public function exportParCuciAnneeType(Request $request): Response
    {

        ini_set("memory_limit", -1);
        ini_set ( 'max_execution_time', -1);


        // recuperer les parametres du formulaire 
        if ($request->get('debut-periode-input')) {
            
            $annee = $request->get('debut-periode-input');
            $codeCuci = $request->get('cuci-input');

            $_type_tableau = $request->get('format-input');


            $repertoire = "";

             if ($codeCuci != "") {
                 
                 $repertoire = $this->getDoctrine()->getRepository(Repertoire::class)->findBy(["codeCuci"=>$codeCuci]);
             }else {
                 $repertoire = "";
             }           
            // first find all-repertoire 

                        
            // Create new Spreadsheet object
            $spreadsheet = new Spreadsheet();
            $activeSheet = $spreadsheet->getActiveSheet();
            $spreadsheet->setActiveSheetIndex(0);
            
            $activeSheet->setCellValue('A1', 'Index')
            ->setCellValue('B1', 'CODE CUCI')
            ->setCellValue('C1', 'Tableau')
            ->setCellValue('D1', 'OPERATION')
            ->setCellValue('E1', 'STATUT')
            ->setCellValue('F1', 'VALEUR')
            ->setCellValue('G1', 'Exercice')
            ->setCellValue('H1', 'COMMENTS')
            ;
            


            switch ($_type_tableau) {
                case '1':
                    $etat_financier= "" != $repertoire
                        ? $this->getDoctrine()->getRepository(Bilan::class)->findBy([ "repertoire"=>$repertoire, "anneeFinanciere"=>$annee]) 
                        : $this->getDoctrine()->getRepository(Bilan::class)->findBy([ "anneeFinanciere"=>$annee]);

                    if (!$etat_financier) {
                        
                        $request->getSession()->getFlashBag()->add('notice', 'Not found data pour cette recherche !.');

                        return $this->redirectToRoute("export_par_cuci_annee_type");
                        
                    } else {
                        $i = 2;
                        
                        foreach ($etat_financier as $key => $obj) {
                            $activeSheet->setCellValue('A'.$i , $obj->getRepertoire()->getCodeCuci().$annee);
                            $activeSheet->setCellValue('B'.$i , $obj->getRepertoire()->getCodeCuci());
        
                            $_tableau = $this->getDoctrine()->getRepository(Category::class)->findOneBy(["id"=>$_type_tableau]);
                            if ($_tableau) {
                                $activeSheet->setCellValue('C'.$i , $_tableau->getLibelle().' - '.$obj->getType());
                                
                            }else {
                                
                                $activeSheet->setCellValue('C'.$i , "Neant");
                            }
                            $activeSheet->setCellValue('D'.$i , $obj->getRefCode());
                            $activeSheet->setCellValue('E'.$i , "Brut");


                            if ($obj->getBrut()) {
                                
                                $activeSheet->getCell('F'.$i)->setValueExplicit($obj->getBrut(), DataType::TYPE_STRING2);
                            }
                            else{
                                
                                $activeSheet->setCellValue('F'.$i, "");
                            }

                            $activeSheet->setCellValue('G'.$i , $obj->getAnneeFinanciere());

                            
                            /**TODO test sur comment directbis* ou direct  */

                            $activeSheet->setCellValue('H'.$i , $obj->getStatut());

                            $i++;


                            $activeSheet->setCellValue('A'.$i , $obj->getRepertoire()->getCodeCuci().$annee);
                            $activeSheet->setCellValue('B'.$i , $obj->getRepertoire()->getCodeCuci());
        
                            $_tableau = $this->getDoctrine()->getRepository(Category::class)->findOneBy(["id"=>$_type_tableau]);
                            if ($_tableau) {
                                $activeSheet->setCellValue('C'.$i , $_tableau->getLibelle().' - '.$obj->getType());
                                
                            }else {
                                
                                $activeSheet->setCellValue('C'.$i , "Neant");
                            }
                            $activeSheet->setCellValue('D'.$i , $obj->getRefCode());
                            $activeSheet->setCellValue('E'.$i , "Ammo");


                            if ($obj->getAmortPR()) {
                                
                                $activeSheet->getCell('F'.$i)->setValueExplicit($obj->getAmortPR(), DataType::TYPE_STRING2);
                            }
                            else{
                                
                                $activeSheet->setCellValue('F'.$i,"");
                            }

                            $activeSheet->setCellValue('G'.$i , $obj->getAnneeFinanciere());
                            
                            /**TODO test sur comment directbis* ou direct  */
                            $activeSheet->setCellValue('H'.$i , $obj->getStatut());

                            $i++;



                            // traitement pour les valeurs nettes 
                            
                            $activeSheet->setCellValue('A'.$i , $obj->getRepertoire()->getCodeCuci().$annee);
                            $activeSheet->setCellValue('B'.$i , $obj->getRepertoire()->getCodeCuci());
        
                            $_tableau = $this->getDoctrine()->getRepository(Category::class)->findOneBy(["id"=>$_type_tableau]);
                            if ($_tableau) {
                                $activeSheet->setCellValue('C'.$i , $_tableau->getLibelle().' - '.$obj->getType());
                                
                            }else {
                                
                                $activeSheet->setCellValue('C'.$i , "");
                            }
                            $activeSheet->setCellValue('D'.$i , $obj->getRefCode());
                            $activeSheet->setCellValue('E'.$i , "NET");
                            
                            if ($obj->getNet1()) {
                                
                                $activeSheet->getCell('F'.$i)->setValueExplicit($obj->getNet1(), DataType::TYPE_STRING2);
                            }
                            elseif($obj->getNet2()){
                                
                                $activeSheet->getCell('F'.$i)->setValueExplicit($obj->getNet2(), DataType::TYPE_STRING2);
                            }else {
                                # $activeSheet->getCell('F'.$i)->setValueExplicit($obj->getNet1(), DataType::TYPE_STRING2);
                                $activeSheet->setCellValue('F'.$i , "");
                                
                                
                            }
                            
                            $activeSheet->setCellValue('G'.$i , $obj->getAnneeFinanciere());

                            /**TODO test sur comment directbis* ou direct  */
                            $activeSheet->setCellValue('H'.$i , $obj->getStatut());



                            $i++;
        
                        }
                    } // nd for
        
                    break;
                
                case '2':
                    $etat_financier= "" != $repertoire
                        ? $this->getDoctrine()->getRepository(CompteDeResultats::class)->findBy([ "cuci_rep_code"=>$repertoire, "annee_financiere"=>$annee]) 
                        : $this->getDoctrine()->getRepository(CompteDeResultats::class)->findBy([ "annee_financiere"=>$annee]);
                                        
                    if (!$etat_financier) {
                        $request->getSession()->getFlashBag()->add('notice', 'Not found data pour cette recherche !.');

                        return $this->redirectToRoute("export_par_cuci_annee_type");
                        
                    } else {
                        $i = 2;
                        
                        foreach ($etat_financier as $key => $obj) {
                            $activeSheet->setCellValue('A'.$i , $obj->getCuciRepCode()->getCodeCuci().$annee);
                            $activeSheet->setCellValue('B'.$i , $obj->getCuciRepCode()->getCodeCuci());
        
                            $_tableau = $this->getDoctrine()->getRepository(Category::class)->findOneBy(["id"=>$_type_tableau]);
                            if ($_tableau) {
                                $activeSheet->setCellValue('C'.$i , $_tableau->getLibelle());
                                
                            }else {
                                
                                $activeSheet->setCellValue('C'.$i , "Neant");
                            }
                            $activeSheet->setCellValue('D'.$i , $obj->getRefCode());
                            $activeSheet->setCellValue('E'.$i , "NET");
                            
                            
                            if ($obj->getNet1()) {
                                
                                $activeSheet->getCell('F'.$i)->setValueExplicit($obj->getNet1(), DataType::TYPE_STRING2);
                            }
                            elseif($obj->getNet2()){
                                
                                $activeSheet->getCell('F'.$i)->setValueExplicit($obj->getNet2(), DataType::TYPE_STRING2);
                            }else {
                                # $activeSheet->getCell('F'.$i)->setValueExplicit($obj->getNet1(), DataType::TYPE_STRING2);
                                $activeSheet->setCellValue('F'.$i , "");
                                
                                
                            }
                            
                            
                            
                            $activeSheet->setCellValue('G'.$i , $obj->getAnneeFinanciere());
                            
                            $activeSheet->setCellValue('H'.$i , $obj->getStatus());


                            $i++;
        
                        }
                    } // nd for
        

                    break;
                
                case '3':
                    
                    $etat_financier= "" != $repertoire
                        ? $this->getDoctrine()->getRepository(FluxDesTresoreries::class)->findBy([ "cuci_rep_code"=>$repertoire, "annee_financiere"=>$annee]) 
                        : $this->getDoctrine()->getRepository(FluxDesTresoreries::class)->findBy([  "annee_financiere"=>$annee]);


                    if (!$etat_financier) {
                        $request->getSession()->getFlashBag()->add('notice', 'Not found data pour cette recherche !.');

                        return $this->redirectToRoute("export_par_cuci_annee_type");
                        
                    } else {
                        $i = 2;
                        
                        foreach ($etat_financier as $key => $obj) {
                            $activeSheet->setCellValue('A'.$i , $obj->getCuciRepCode()->getCodeCuci().$annee);
                            $activeSheet->setCellValue('B'.$i , $obj->getCuciRepCode()->getCodeCuci());
        
                            $_tableau = $this->getDoctrine()->getRepository(Category::class)->findOneBy(["id"=>$_type_tableau]);
                            if ($_tableau) {
                                $activeSheet->setCellValue('C'.$i , $_tableau->getLibelle());
                                
                            }else {
                                
                                $activeSheet->setCellValue('C'.$i , "Neant");
                            }
                            $activeSheet->setCellValue('D'.$i , $obj->getRefCode());
                            $activeSheet->setCellValue('E'.$i , "NET");


                            if ($obj->getNet1()) {
                                
                                $activeSheet->getCell('F'.$i)->setValueExplicit($obj->getNet1(), DataType::TYPE_STRING2);
                            }
                            elseif($obj->getNet2()){
                                
                                $activeSheet->getCell('F'.$i)->setValueExplicit($obj->getNet2(), DataType::TYPE_STRING2);
                            }else {
                                # $activeSheet->getCell('F'.$i)->setValueExplicit($obj->getNet1(), DataType::TYPE_STRING2);
                                $activeSheet->setCellValue('F'.$i , "");
                                
                                
                            }

                            $activeSheet->setCellValue('G'.$i , $obj->getAnneeFinanciere());

                            $activeSheet->setCellValue('H'.$i , $obj->getStatus());

                            $i++;
        
                        }
                    } // nd for
        


                    break;
                
                default:
                    $etat_bilan = $this->getDoctrine()->getRepository(Bilan::class)->findBy([ "repertoire"=>$repertoire, "anneeFinanciere"=>$annee]);
                    $etat_compte = $this->getDoctrine()->getRepository(CompteDeResultats::class)->findBy([ "cuci_rep_code"=>$repertoire, "annee_financiere"=>$annee]);
                    $etat_flux = $this->getDoctrine()->getRepository(FluxDesTresoreries::class)->findBy([ "cuci_rep_code"=>$repertoire, "annee_financiere"=>$annee]);

                    $i = 2;
                        
                        
                    foreach ($etat_bilan as $key => $obj) {
                        $activeSheet->setCellValue('A'.$i , $obj->getRepertoire()->getCodeCuci().$annee);
                        $activeSheet->setCellValue('B'.$i , $obj->getRepertoire()->getCodeCuci());
    
                        if ($obj->getType()!="Passif") {
                            $activeSheet->setCellValue('C'.$i , 'Bilan'.' - '.$obj->getType());
                            
                        }else {
                            
                            $activeSheet->setCellValue('C'.$i , 'Bilan'.' - '.$obj->getType());
                        }
                        $activeSheet->setCellValue('D'.$i , $obj->getRefCode());
                        $activeSheet->setCellValue('E'.$i , "Brut");


                        if ($obj->getBrut()) {
                            
                            $activeSheet->getCell('F'.$i)->setValueExplicit($obj->getBrut(), DataType::TYPE_STRING2);
                        }
                        else{
                            
                            $activeSheet->setCellValue('F'.$i, "");
                        }

                        $activeSheet->setCellValue('G'.$i , $obj->getAnneeFinanciere());

                        
                        /**TODO test sur comment directbis* ou direct  */

                        $activeSheet->setCellValue('H'.$i , $obj->getStatut());

                        $i++;


                        $activeSheet->setCellValue('A'.$i , $obj->getRepertoire()->getCodeCuci().$annee);
                        $activeSheet->setCellValue('B'.$i , $obj->getRepertoire()->getCodeCuci());
    
                        if ($obj->getType()!="Passif") {
                            $activeSheet->setCellValue('C'.$i , 'Bilan'.' - '.$obj->getType());
                            
                        }else {
                            
                            $activeSheet->setCellValue('C'.$i , 'Bilan'.' - '.$obj->getType());
                        }
                        $activeSheet->setCellValue('D'.$i , $obj->getRefCode());
                        $activeSheet->setCellValue('E'.$i , "Ammo");


                        if ($obj->getAmortPR()) {
                            
                            $activeSheet->getCell('F'.$i)->setValueExplicit($obj->getAmortPR(), DataType::TYPE_STRING2);
                        }
                        else{
                            
                            $activeSheet->setCellValue('F'.$i, "");
                        }

                        $activeSheet->setCellValue('G'.$i , $obj->getAnneeFinanciere());
                        
                        /**TODO test sur comment directbis* ou direct  */

                        $activeSheet->setCellValue('H'.$i , $obj->getStatut());



                        $i++;



                        $activeSheet->setCellValue('A'.$i , $obj->getRepertoire()->getCodeCuci().$annee);
                        $activeSheet->setCellValue('B'.$i , $obj->getRepertoire()->getCodeCuci());
    
                        if ($obj->getType()!="Passif") {
                            $activeSheet->setCellValue('C'.$i , 'Bilan'.' - '.$obj->getType());
                            
                        }else {
                            
                            $activeSheet->setCellValue('C'.$i , 'Bilan'.' - '.$obj->getType());
                        }
                        $activeSheet->setCellValue('D'.$i , $obj->getRefCode());
                        $activeSheet->setCellValue('E'.$i , "NET");
                        
                        if ($obj->getNet1()) {
                            
                            $activeSheet->getCell('F'.$i)->setValueExplicit($obj->getNet1(), DataType::TYPE_STRING2);
                        }
                        else{
                            
                            $activeSheet->setCellValue('F'.$i, "");
                        }
                        
                        $activeSheet->setCellValue('G'.$i , $obj->getAnneeFinanciere());

                        /**TODO test sur comment directbis* ou direct  */

                        $activeSheet->setCellValue('H'.$i , $obj->getStatut());


                        $i++;
    
                    }

                    foreach ($etat_compte as $key => $obj) {
                        $activeSheet->setCellValue('A'.$i , $obj->getCuciRepCode()->getCodeCuci().$annee);
                        $activeSheet->setCellValue('B'.$i , $obj->getCuciRepCode()->getCodeCuci());
    
                        $activeSheet->setCellValue('C'.$i , "Compte résultats");
                        $activeSheet->setCellValue('D'.$i , $obj->getRefCode());
                        $activeSheet->setCellValue('E'.$i , "NET");
                        if ($obj->getNet1()) {
                            
                            $activeSheet->getCell('F'.$i)->setValueExplicit($obj->getNet1(), DataType::TYPE_STRING2);
                        }
                        else{
                            
                            $activeSheet->setCellValue('F'.$i, "");
                        }

                        $activeSheet->setCellValue('G'.$i , $obj->getAnneeFinanciere());

                        /**TODO test sur comment directbis* ou direct  */

                        $activeSheet->setCellValue('H'.$i , $obj->getStatus());

                        $i++;
    
                    }

                    foreach ($etat_flux as $key => $obj) {
                        $activeSheet->setCellValue('A'.$i , $obj->getCuciRepCode()->getCodeCuci().$annee);
                        $activeSheet->setCellValue('B'.$i , $obj->getCuciRepCode()->getCodeCuci());
    
                        $activeSheet->setCellValue('C'.$i , "Flux trésorerie");
                            
                        $activeSheet->setCellValue('D'.$i , $obj->getRefCode());
                        $activeSheet->setCellValue('E'.$i , "NET");
                        if ($obj->getNet1()) {
                            
                            $activeSheet->getCell('F'.$i)->setValueExplicit($obj->getNet1(), DataType::TYPE_STRING2);
                        }
                        else{
                            
                            $activeSheet->setCellValue('F'.$i, "");
                        }

                        $activeSheet->setCellValue('G'.$i , $obj->getAnneeFinanciere());

                        /**TODO test sur comment directbis* ou direct  */
                        
                        $activeSheet->setCellValue('H'.$i , $obj->getStatus());
                        
                        
                        
                        
                        $i++;
    
                    }

                break;
            }
            

                $styleArrayFirstRow = [
                    'font' => [
                        'bold' => true,
                    ]
                ];


                foreach (range('A1', 'H1') as $row) {
                    //set first row bold
                    $activeSheet->getStyle('A1:' . 'H1' )->applyFromArray($styleArrayFirstRow);
                    $activeSheet->getColumnDimension($row)->setAutoSize(true); 

                }
           
            
                $writer = new Xlsx($spreadsheet);

                $fileName = $_type_tableau."tableau.xlsx";
            
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



        } //end if submit request


        return $this->render('data_cubing/_export_cuci_annee_type.html.twig', [
            'controller_name' => 'DataCubingController',
        ]);
    }


    
    /**
     * @Route("/jrepertoire", name="jrepertoire")
     */
    public function jrepertoire(Request $request, EntityManagerInterface $entityManager): Response
    {

      
        $dateannee=new DateTime("");
        
        ini_set("memory_limit", -1);
        ini_set ( 'max_execution_time', -1);

      
        if($request->get("filtrer")){
          
            $dateannee= new DateTime($request->get("dateAnnee"));

            if($dateannee!=null){
                
                // TODO traitement d'exception si la date est vide 
                $repertoires= $entityManager->getRepository(Repertoire::class)->findBy(['updatedAt'=>$dateannee]);
                dd($repertoires);
                foreach ($repertoires as $key => $obj) {
                }
            }
           
    
          }
    

        return $this->render('data_cubing/_jrepertoire.html.twig', [
            'controller_name' => 'DataCubingController',
        ]);
    }

}

