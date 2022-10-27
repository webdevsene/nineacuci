<?php

namespace App\Controller;

use App\Entity\NINinea;
use App\Entity\NiNineaproposition;
use App\Repository\NINineaRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class NineaDataReportController extends AbstractController
{

    private $requestStack;
    
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @Route("/ninea/data/report", name="app_ninea_data_report")
     */
    public function index(Request $request, EntityManagerInterface $entitymanager): Response
    {
        $dateDebut ="";
        $dateFin ="";

        if ($request->get("submit-templ")) {
            
            $dateDebut = $request->get("var-datedebut");
            $dateFin = $request->get("var-datefin");
            
            $session = $this->requestStack->getSession();            
            $session->set('startDate', $dateDebut);
            $session->set('endDate', $dateFin);
            
            $obj = $entitymanager->getRepository(NINinea::class)->findByCreatedAt($dateDebut, $dateFin);
            if ($obj) {
                return NineaDataReportController::reportingExcel($obj);
            }
        }
        return $this->render('ninea_data_report/index.html.twig', [
            'controller_name' => 'NineaDataReportController',
            'date1'=> (new \DateTime('now'))->format('Y-m-d'),
            'date2' => (new \DateTime('now'))->format('Y-m-d'),
        ]);
    }
    
    
    
    /**
     * Funciton personnalisee pour exportation usuelle
     * @param [type] $allDbChanges
     * @return void
     */
    public static function reportingExcel($allDbChanges): Response
    {         

         // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $activeSheet = $spreadsheet->getActiveSheet();
        $spreadsheet->setActiveSheetIndex(0);
        $activeSheet->setTitle('Journal_donnees');
        $activeSheet->setCellValue('A1', 'NINEA')
                    ->setCellValue('B1', 'Raison sociale')
                    ->setCellValue('C1', 'Enseigne')
                    ->setCellValue('D1', 'Registre commerce')
                    ->setCellValue('E1', 'Regime juridique')
                    ->setCellValue('F1', 'Forme unite')
                    ->setCellValue('G1', 'Date de creation')
                    ->setCellValue('H1', 'Services')
                    ->setCellValue('I1', 'Statut')
        ;
            
            
        $i = 2;
            
        // $allChanges = $conn->prepare($sql);            
        // $stmt=$allChanges->executeQuery();
        // $allDbChanges = $stmt->fetchAllAssociative();        
          
        foreach ($allDbChanges as $key_bilan ) {

            /**$activeSheet->getCell('A'.$i)->setValueExplicit( $key_bilan['code_cuci'], DataType::TYPE_STRING2);
            $activeSheet->getCell('B'.$i)->setValueExplicit( $key_bilan['action'], DataType::TYPE_STRING2);
            $activeSheet->getCell('C'.$i)->setValueExplicit( $key_bilan['field_name'], DataType::TYPE_STRING2);
            $activeSheet->getCell('D'.$i)->setValueExplicit( $key_bilan['old_value'], DataType::TYPE_STRING2);
            $activeSheet->getCell('E'.$i)->setValueExplicit( $key_bilan['new_value'], DataType::TYPE_STRING2);
            $activeSheet->getCell('F'.$i)->setValueExplicit( $key_bilan['dateSaisie'], DataType::TYPE_STRING2);
            $activeSheet->getCell('G'.$i)->setValueExplicit( $key_bilan['saisiePar'], DataType::TYPE_STRING2);
            $activeSheet->getCell('H'.$i)->setValueExplicit( $key_bilan['created_at'], DataType::TYPE_STRING2);
            $activeSheet->getCell('I'.$i)->setValueExplicit( $key_bilan['userID'], DataType::TYPE_STRING2);
            */
            
            $activeSheet->getCell('A'.$i)->setValueExplicit( $key_bilan->getNinNinea(), DataType::TYPE_STRING);
            if($key_bilan->getNiPersonne()!=null)
             $activeSheet->getCell('B'.$i)->setValueExplicit( $key_bilan->getNiPersonne()->getNinRaison(), DataType::TYPE_STRING2);
             else
             $activeSheet->getCell('B'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);

            $activeSheet->getCell('C'.$i)->setValueExplicit( $key_bilan->getNinEnseigne(), DataType::TYPE_STRING2);
            $activeSheet->getCell('D'.$i)->setValueExplicit( $key_bilan->getNinRegcom(), DataType::TYPE_STRING2);
            $activeSheet->getCell('E'.$i)->setValueExplicit( $key_bilan->getFormeJuridique()->getFojLibelle(), DataType::TYPE_STRING2);
            $activeSheet->getCell('F'.$i)->setValueExplicit( $key_bilan->getFormeJuridique()->getNiFormeunite()->getLibelle(), DataType::TYPE_STRING2);
            $activeSheet->getCell('G'.$i)->setValueExplicit( $key_bilan->getCreatedAt()->format("Y/m/d"), DataType::TYPE_STRING2);
            $activeSheet->getCell('H'.$i)->setValueExplicit( $key_bilan->getCreatedBy()->getNiAdministration()->getAdmlibelle(), DataType::TYPE_STRING2);
            $activeSheet->getCell('I'.$i)->setValueExplicit( $key_bilan->getNinStatut(), DataType::TYPE_STRING2);
                    
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

        $fileName = "NinenasReport.csv";
        
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


    /**
     * @Route("/ninea/data/reports/{dateDebut}/{dateFin}", name="app_ninea_data_reports", methods={"POST", "GET"})
     */
    public function processBar(AuthorizationCheckerInterface $autorization, $dateDebut="", $dateFin=""): Response
    {
        // on recupere ici le id csi du current user 
        $user = $this->getUser();
        $_csi = $user->getNiAdministration()->getId();
            
        // if ($autorization->isGranted('ROLE_VALIDER_DEMANDE_NINEA') || $autorization->isGranted('ROLE_NINEA_ADMIN')) {
        // }
            // $obj = $this->getDoctrine()->getRepository(NiNineaproposition::class)->findByCreatedAtAndNiAdmin($dateDebut, $dateFin, $_csi);

            $obj = $this->getDoctrine()->getRepository(NINinea::class)->findByCreatedAt($dateDebut, $dateFin);

        
        $data = [];

        if (!$obj) {
            return $this->json(0);
        }else {
            
            /**
             * fiche  enterprise
             * @var $record NINinea
             */
            foreach ($obj as $record) {
                $obj_dmde = $this->getDoctrine()->getRepository(NiNineaproposition::class)->findOneBy(["ninNinea"=>$record->getNinNinea()]);

                // dd($obj_dmde->getCreatedBy()->getNiAdministration()->getId());

                $doc_create = str_replace("_", "", $record->getNinRegcom()); // init docu creation
                if ($doc_create==null) {
                    $doc_create = $record->getNinBordereau();
                }
                if ($doc_create==null) {
                    $doc_create = $record->getNinTitrefoncier();
                }
                if ($doc_create==null) {
                    $doc_create = $record->getNinAgrement();
                }
                if ($doc_create==null) {
                    $doc_create = $record->getNinArrete();
                }
                if ($doc_create==null) {
                    $doc_create = $record->getNinRecepisse();
                }
                if ($doc_create==null) {
                    $doc_create = $record->getNinAccord();
                }
                if ($doc_create==null) {
                    $doc_create = $record->getNinBail();
                }
                if ($doc_create==null) {
                    $doc_create = $record->getNinPermisoccuper();
                }
                if ($doc_create==null) {
                    $doc_create = $record->getNiPersonne() ? $record->getNiPersonne()->getNinCNI() : "";
                }

                
                $raison_sociale = $record->getNiPersonne() ? str_replace("", ",", $record->getNiPersonne()->getNinRaison()) : "";
                
                if($raison_sociale==""){
                    $raison_sociale = $record->getNiPersonne() ? str_replace("", ",", $record->getNiPersonne()->getNinPrenom()." ".$record->getNiPersonne()->getNinNom()) :"";
                }
                $data[] = [
                    'Ninea' => $record->getNinNinea(),
                    'Raison sociale' =>  $raison_sociale,
                    'Enseigne' => str_replace("", ",", $record->getNinEnseigne()),
                    'Document de creation' => $doc_create,
                    'Regime juridique' => $record->getFormeJuridique()->getFojLibelle(),
                    'Forme unite' => $record->getFormeJuridique()->getNiFormeunite()->getLibelle(),
                    'Date de creation' => $record->getCreatedAt()->format("Y/m/d"),
                    'Service delever' => $obj_dmde->getCreatedBy()->getNiAdministration()->getAdmlibelle(),
                    'Statut' => $record->getStatut()
                ];
            }
            
            if (!$data){
                throw $this->createNotFoundException("aucune recette trouvé");
            }else{
                return $this->json($data, 200, []);
            }
        }
        return $this->render('ninea_data_report/index.html.twig', [
            'date1'=> $dateDebut,
            'date2' => $dateFin,
        ]);
                
        //$filename = 'export_nineas_'.date_create()->format('d-m-y').'.csv';
        
        // $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
        
        // $response = new Response($serializer->encode($data, CsvEncoder::FORMAT));
        //$response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        // $response->headers->set('Content-Disposition', "attachment; filename=\"$filename\"");
        
        // return $this->json($data, 201, []);
        
    }

}
