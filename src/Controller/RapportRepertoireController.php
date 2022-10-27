<?php

namespace App\Controller;

use App\Entity\Bilan;
use App\Entity\CompteDeResultats;
use App\Entity\FluxDesTresoreries;
use App\Entity\AchatProduction;
use App\Entity\Effectifs;
use App\Entity\ProductionDeExercice;
use App\Entity\ImmoBrut;
use App\Entity\CuciImmoPlus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Repertoire;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

 /**
     * @IsGranted("ROLE_USER")
     */
class RapportRepertoireController extends AbstractController
{
     /**
     * @Route("/rapport/interTableau", name="app_rapport_interTableau")
     * @IsGranted("ROLE_USER")
     */
    public function interTableau(Request $request,EntityManagerInterface $entityManager): Response
    {
        ini_set("memory_limit", -1);
        ini_set ( 'max_execution_time', -1);
        $annee=(new \DateTime())->format("Y");
        $annee=$annee-1;
        if($request->get("filtrer")){
            $annee=$request->get("annee");
    
             
        }
      
        $bilansactif=$entityManager->getRepository(Bilan::class)->findInterTableau($annee,"actif");
        
        $bilanspassif=$entityManager->getRepository(Bilan::class)->findInterTableau($annee,"passif");
        $compteDeResultats=$entityManager->getRepository(CompteDeResultats::class)->findInterTableau($annee);
        $fluxDesTresoreries=$entityManager->getRepository(FluxDesTresoreries::class)->findInterTableau($annee);
        $achatProduction=$entityManager->getRepository(AchatProduction::class)->findInterTableau($annee);
        $effectifs=$entityManager->getRepository(Effectifs::class)->findInterTableau($annee);
        $productionDeExercice=$entityManager->getRepository(ProductionDeExercice::class)->findInterTableau($annee);
        $immoBrut=$entityManager->getRepository(ImmoBrut::class)->findInterTableau($annee);
        $cuciImmoPlus=$entityManager->getRepository(CuciImmoPlus::class)->findInterTableau($annee);
        

        
    
        
       
        return $this->render('rapport_repertoire/interTableau.html.twig', [
            'annee' => $annee,
            'bilansactif' => $bilansactif,
            'bilanspassif' => $bilanspassif,
            'compteDeResultats' => $compteDeResultats,
            'fluxDesTresoreries' => $fluxDesTresoreries,
            'achatProduction' => $achatProduction,
            'effectifs' => $effectifs,
            'productionDeExercice' => $productionDeExercice,
            'immoBrut' => $immoBrut,
            'cuciImmoPlus' => $cuciImmoPlus,
            
          
            'repertoires' => $entityManager->getRepository(Repertoire::class)->findAll()
        ]);
    }


    public function export( $repertoire)
    {
       
       
       

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
       

        $activeSheet = $spreadsheet->getActiveSheet();
        $activeSheet->setTitle('Répertoire');
       

        $activeSheet->setCellValue('A1', 'NINEA/NINET');
        $activeSheet->setCellValue('B1', 'CUCI');
        $activeSheet->setCellValue('C1', 'RAISON_SOCIALE');
        $activeSheet->setCellValue('D1', 'ENSEIGNE/SIGLE');
        $activeSheet->setCellValue('E1', 'NUMRC');
        $activeSheet->setCellValue('F1', 'SYSCOA1');
        $activeSheet->setCellValue('G1', 'SYSCOA2');
        $activeSheet->setCellValue('H1', 'SYSCOA3');
        $activeSheet->setCellValue('I1', 'NAEMAS');
        $activeSheet->setCellValue('J1', 'NAEMA_rev1');
        $activeSheet->setCellValue('K1', 'CITI_rev4');
        $activeSheet->setCellValue('L1', 'ADRESSE COMPLETE');
        $activeSheet->setCellValue('M1', 'TEL1');
        $activeSheet->setCellValue('N1', 'TEL2');
        $activeSheet->setCellValue('O1', 'NUMERO DE TELECOPIE(fax)');
        $activeSheet->setCellValue('P1', 'EMAIL');
        $activeSheet->setCellValue('Q1', 'BP');
        $activeSheet->setCellValue('R1', 'REGION');
        $activeSheet->setCellValue('S1', 'DEPARTEMENT');
        $activeSheet->setCellValue('T1', 'VILLE/ARRONDISSEMENT');
        $activeSheet->setCellValue('U1','COMMUNE/COMMUNE RURALE');
        $activeSheet->setCellValue('V1','QUARTIER/HAMEAU/VILLAGE');
        $activeSheet->setCellValue('W1','PERSONNE_CONTACT');
        $activeSheet->setCellValue('X1','ADRESSE PERSONNE_CONTACT');
        $activeSheet->setCellValue('Y1','QUALITE PERSONNE_CONTACT');
        $activeSheet->setCellValue('Z1','PREMIER_ANNEE_EXERCICE');
        $activeSheet->setCellValue('AA1','FORME JURIDIQUE');
        $activeSheet->setCellValue('AB1','REGIME FISCAL');
        $activeSheet->setCellValue('AC1','PAYS DU SIEGE DE L\'ENTREPRISE');
        $activeSheet->setCellValue('AD1','NOMBRE D\'ETABLISSEMENT DANS LE PAYS');
        $activeSheet->setCellValue('AE1','CONTROLE');
        $activeSheet->setCellValue('AF1','DATE DE RECEPTION');
        $activeSheet->setCellValue('AG1','LIBELLE ACTIVITE PRINCIPALE ');
        $activeSheet->setCellValue('AH1','OBSERVATIONS');
        $activeSheet->setCellValue('AI1','SYSTEME (Normal, Allégé, Minimal)');
        $activeSheet->setCellValue('AJ1','ANNEE D\'EXERCICE');
        $activeSheet->setCellValue('AK1','CHIFFRE D\'AFFAIRES');
        $activeSheet->setCellValue('AL1','DATE DEBUT EXERCICE COMPTABLE');
        $activeSheet->setCellValue('AM1','DATE FIN EXERCICE COMPTABLE');
        $activeSheet->setCellValue('AN1','DATE D\'ARRET EFFECTIF');
        $activeSheet->setCellValue('AO1','DATE DE CLOTURE');
        $activeSheet->setCellValue('AP1','MISE A JOUR');
        $activeSheet->setCellValue('AQ1','MODIFIER PAR');
        

        $i = 2;

        foreach (range('A', $activeSheet->getHighestDataColumn()) as $col) {
               $activeSheet->getColumnDimension($col)->setAutoSize(true);
           }



        foreach ($repertoire as $tag ) {

            $activeSheet->getCell('A'.$i)->setValueExplicit( $tag->getNinea(), DataType::TYPE_STRING2 );
            $activeSheet->getCell('B'.$i)->setValueExplicit( $tag->getCodeCuci(), DataType::TYPE_STRING2);
            $activeSheet->getCell('C'.$i)->setValueExplicit( $tag->getDenominationSocial(), DataType::TYPE_STRING2);
            $activeSheet->getCell('D'.$i)->setValueExplicit( $tag->getSigle(), DataType::TYPE_STRING2);
            $activeSheet->getCell('E'.$i)->setValueExplicit( $tag->getNumeroRegistreCommerce(), DataType::TYPE_STRING2);
            
            if(count($tag->getActivities())>2){
              if($tag->getActivities()[0]->getSYSCOA())
                $activeSheet->getCell('F'.$i)->setValueExplicit( $tag->getActivities()[0]->getSYSCOA()->getId(), DataType::TYPE_STRING2);
              else
                $activeSheet->getCell('F'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
              if($tag->getActivities()[1]->getSYSCOA())  
                $activeSheet->getCell('G'.$i)->setValueExplicit( $tag->getActivities()[1]->getSYSCOA()->getId(), DataType::TYPE_STRING2);
              else
                $activeSheet->getCell('G'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);

              if($tag->getActivities()[2]->getSYSCOA())
                  $activeSheet->getCell('H'.$i)->setValueExplicit( $tag->getActivities()[2]->getSYSCOA()->getId(), DataType::TYPE_STRING2);
              else 
                $activeSheet->getCell('H'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
              
             if($tag->getActivities()[0]->getNAEMAS())
                $activeSheet->getCell('I'.$i)->setValueExplicit( $tag->getActivities()[0]->getNAEMAS()->getId(), DataType::TYPE_STRING2);
             else
               $activeSheet->getCell('I'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
             
             if($tag->getActivities()[0]->getNAEMA())
                $activeSheet->getCell('J'.$i)->setValueExplicit( $tag->getActivities()[0]->getNAEMA()->getId(), DataType::TYPE_STRING2);
             else
               $activeSheet->getCell('J'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
             if($tag->getActivities()[0]->getCITI())
                $activeSheet->getCell('K'.$i)->setValueExplicit( $tag->getActivities()[0]->getCITI()->getId(), DataType::TYPE_STRING2);
             else
              $activeSheet->getCell('K'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);

               
              }elseif(count($tag->getActivities())>1){
              
              if($tag->getActivities()[0]->getSYSCOA())
                $activeSheet->getCell('F'.$i)->setValueExplicit( $tag->getActivities()[0]->getSYSCOA()->getId(), DataType::TYPE_STRING2);
              else
                $activeSheet->getCell('F'.$i)->setValueExplicit("", DataType::TYPE_STRING2);
              if($tag->getActivities()[1]->getSYSCOA())
                 $activeSheet->getCell('G'.$i)->setValueExplicit( $tag->getActivities()[1]->getSYSCOA()->getId(), DataType::TYPE_STRING2);
              else
                $activeSheet->getCell('G'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
                
              $activeSheet->getCell('H'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
             
              if($tag->getActivities()[0]->getNAEMAS())
                 $activeSheet->getCell('I'.$i)->setValueExplicit( $tag->getActivities()[0]->getNAEMAS()->getId(), DataType::TYPE_STRING2);
              else
                $activeSheet->getCell('I'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
              
              if($tag->getActivities()[0]->getNAEMA())
                 $activeSheet->getCell('J'.$i)->setValueExplicit( $tag->getActivities()[0]->getNAEMA()->getId(), DataType::TYPE_STRING2);
              else
                $activeSheet->getCell('J'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
              if($tag->getActivities()[0]->getCITI())
                 $activeSheet->getCell('K'.$i)->setValueExplicit( $tag->getActivities()[0]->getCITI()->getId(), DataType::TYPE_STRING2);
              else
               $activeSheet->getCell('K'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);

            }elseif(count($tag->getActivities())==1){
              if($tag->getActivities()[0]->getSYSCOA())
                 $activeSheet->getCell('F'.$i)->setValueExplicit( $tag->getActivities()[0]->getSYSCOA()->getId(), DataType::TYPE_STRING2);
              else
              $activeSheet->getCell('F'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);

              $activeSheet->getCell('G'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
              $activeSheet->getCell('H'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
              if($tag->getActivities()[0]->getNAEMAS())
                 $activeSheet->getCell('I'.$i)->setValueExplicit( $tag->getActivities()[0]->getNAEMAS()->getId(), DataType::TYPE_STRING2);
              else
                $activeSheet->getCell('I'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
              
              if($tag->getActivities()[0]->getNAEMA())
                 $activeSheet->getCell('J'.$i)->setValueExplicit( $tag->getActivities()[0]->getNAEMA()->getId(), DataType::TYPE_STRING2);
              else
                $activeSheet->getCell('J'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
              if($tag->getActivities()[0]->getCITI())
                 $activeSheet->getCell('K'.$i)->setValueExplicit( $tag->getActivities()[0]->getCITI()->getId(), DataType::TYPE_STRING2);
              else
               $activeSheet->getCell('K'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
                

            }else{
              $activeSheet->getCell('F'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
              $activeSheet->getCell('G'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
              $activeSheet->getCell('H'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
              $activeSheet->getCell('I'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
              $activeSheet->getCell('J'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
              $activeSheet->getCell('K'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
            }

            $activeSheet->getCell('L'.$i)->setValueExplicit( $tag->getAddresseComplete(), DataType::TYPE_STRING2);
            $activeSheet->getCell('M'.$i)->setValueExplicit( $tag->getTelephone1(), DataType::TYPE_STRING2);
            $activeSheet->getCell('N'.$i)->setValueExplicit( $tag->getTelephone2(), DataType::TYPE_STRING2);
            $activeSheet->getCell('O'.$i)->setValueExplicit( $tag->getNumeroTelecopie(), DataType::TYPE_STRING2);
            $activeSheet->getCell('P'.$i)->setValueExplicit( $tag->getEmail(), DataType::TYPE_STRING2);
            $activeSheet->getCell('Q'.$i)->setValueExplicit( $tag->getBoitePostale(), DataType::TYPE_STRING2);
            if($tag->getQvh()){
               $activeSheet->getCell('R'.$i)->setValueExplicit( $tag->getQvh()->getQvhCACRID()->getCacrCAVID()->getCavDEPID()->getDepRegCD()->getLibelle(), DataType::TYPE_STRING2);
               $activeSheet->getCell('S'.$i)->setValueExplicit( $tag->getQvh()->getQvhCACRID()->getCacrCAVID()->getCavDEPID()->getDescription(), DataType::TYPE_STRING2);
               $activeSheet->getCell('T'.$i)->setValueExplicit( $tag->getQvh()->getQvhCACRID()->getCacrCAVID()->getLibelle(), DataType::TYPE_STRING2);
               $activeSheet->getCell('U'.$i)->setValueExplicit( $tag->getQvh()->getQvhCACRID()->getCacrCAVID()->getLibelle(), DataType::TYPE_STRING2);
               $activeSheet->getCell('V'.$i)->setValueExplicit( $tag->getQvh()->getQvhCACRID()->getLibelle(), DataType::TYPE_STRING2);
            }else{

              $activeSheet->getCell('R'.$i)->setValueExplicit("", DataType::TYPE_STRING2);
              $activeSheet->getCell('S'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
              $activeSheet->getCell('T'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
              $activeSheet->getCell('U'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
              $activeSheet->getCell('V'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
            }

            $activeSheet->getCell('W'.$i)->setValueExplicit( $tag->getPrenomDuContact()." ". $tag->getNomDuContact(), DataType::TYPE_STRING2);
            $activeSheet->getCell('X'.$i)->setValueExplicit( $tag->getAddresseDuContact(), DataType::TYPE_STRING2);
            if($tag->getFonctionDucontact())
              $activeSheet->getCell('Y'.$i)->setValueExplicit( $tag->getFonctionDucontact()->getLibelle(), DataType::TYPE_STRING2);
            else
              $activeSheet->getCell('Y'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
            $activeSheet->getCell('Z'.$i)->setValueExplicit( $tag->getPremiereAnneeExercice(), DataType::TYPE_STRING2);

            if($tag->getFormeJuridique())
              $activeSheet->getCell('AA'.$i)->setValueExplicit( $tag->getFormeJuridique()->getLibelle(), DataType::TYPE_STRING2);
            else
              $activeSheet->getCell('AA'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
            
            if($tag->getRegimeFiscal())
              $activeSheet->getCell('AB'.$i)->setValueExplicit( $tag->getRegimeFiscal()->getLibelle(), DataType::TYPE_STRING2);
            else
              $activeSheet->getCell('AB'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);

            
            if($tag->getPaysDuEntreprise())
              $activeSheet->getCell('AC'.$i)->setValueExplicit( $tag->getPaysDuEntreprise()->getLibelle(), DataType::TYPE_STRING2);
            else
              $activeSheet->getCell('AC'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
            
            $activeSheet->getCell('AD'.$i)->setValueExplicit($tag->getEtablissementsDansPays(), DataType::TYPE_STRING2);

                
            
            if($tag->getControle())
             $activeSheet->getCell('AE'.$i)->setValueExplicit( $tag->getControle()->getLibelle(), DataType::TYPE_STRING2);
            else
             $activeSheet->getCell('AE'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
              
            if($tag->getDateReception())
             $activeSheet->getCell('AF'.$i)->setValueExplicit( $tag->getDateReception()->format("d/m/Y"), DataType::TYPE_STRING2);
            else
             $activeSheet->getCell('AF'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
             
             $activeSheet->getCell('AG'.$i)->setValueExplicit( $tag->getActivitePrincipale(), DataType::TYPE_STRING2);
             $activeSheet->getCell('AH'.$i)->setValueExplicit( $tag->getObservation(), DataType::TYPE_STRING2);

             if($tag->getSystemeComptabilite())
               $activeSheet->getCell('AI'.$i)->setValueExplicit( $tag->getSystemeComptabilite()->getLibelle(), DataType::TYPE_STRING2);
             else
               $activeSheet->getCell('AI'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
              
              if($tag->getDebutExerciceComptable())
               $activeSheet->getCell('AJ'.$i)->setValueExplicit( $tag->getDebutExerciceComptable()->format("d/m/Y"), DataType::TYPE_STRING2);
              else
               $activeSheet->getCell('AJ'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);

              
             
            
             
             if(count($tag->getActivities())==1){
              
              $activeSheet->getCell('AK'.$i)->setValueExplicit( $tag->getActivities()[0]->getChiffreAffaire(), DataType::TYPE_STRING2);
             }else
              $activeSheet->getCell('AK'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);

            if($tag->getDebutExerciceComptable())
              $activeSheet->getCell('AL'.$i)->setValueExplicit( $tag->getDebutExerciceComptable()->format("d/m/Y"), DataType::TYPE_STRING2);
             else
              $activeSheet->getCell('AL'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
            

              if($tag->getFinExerciceComptable())
              $activeSheet->getCell('AM'.$i)->setValueExplicit( $tag->getFinExerciceComptable()->format("d/m/Y"), DataType::TYPE_STRING2);
             else
              $activeSheet->getCell('AM'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
              
              if($tag->getDateArreteEffectif())
              $activeSheet->getCell('AN'.$i)->setValueExplicit( $tag->getDateArreteEffectif()->format("d/m/Y"), DataType::TYPE_STRING2);
             else
              $activeSheet->getCell('AN'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
              
              if($tag->getClotureDeExercice())
              $activeSheet->getCell('AO'.$i)->setValueExplicit( $tag->getClotureDeExercice()->format("d/m/Y"), DataType::TYPE_STRING2);
             else
              $activeSheet->getCell('AO'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);
              

              if($tag->getUpdatedAt())
              $activeSheet->getCell('AP'.$i)->setValueExplicit( $tag->getUpdatedAt()->format("d/m/Y"), DataType::TYPE_STRING2);
             else
              $activeSheet->getCell('AP'.$i)->setValueExplicit( "", DataType::TYPE_STRING2);

             

              $editedBy = $tag->getUpdatedBy()!=null ? $tag->getUpdatedBy()->getPrenomNom() : "";
              $activeSheet->getCell('AQ'.$i)->setValueExplicit( $editedBy, DataType::TYPE_STRING2);
             
              
           

            
            $i++;
           
        }

            // $activeSheet->fromArray(array_keys($columnNames, NULL, 'A1'));
            
        $writer = new Xlsx($spreadsheet);
        //$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $fileName = "repertoire.xlsx";
        
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
     * @Route("/exportationRepertoire", name="app_exportationRepertoire")
     */
    public function exportationRepertoire(Request $request,EntityManagerInterface $entityManager): Response
    {
      
      
      $dateDebut="";
      $dateFin="";
      $datedebutMaj="";
      $datefinMaj="";
      ini_set("memory_limit", -1);
      ini_set ( 'max_execution_time', -1);
      

      
      if($request->get("filtrer")){
          
        $dateDebut=$request->get("dateDebut");
        $dateFin=$request->get("dateFin");
        $datedebutMaj=$request->get("datedebutMaj");
        $datefinMaj=$request->get("datefinMaj");
        $repertoires= $entityManager->getRepository(Repertoire::class)->exportationRepertoire($dateDebut,$dateFin,$datedebutMaj, $datefinMaj);
       
        return $this->export($repertoires);

      }

     

      return $this->render('rapport_repertoire/exportationRepertoire.html.twig', [
        "dateFin"=> $dateFin,
        "dateDebut"=> $dateDebut,

        "datefinMaj"=> $datefinMaj,
        "datedebutMaj"=> $datedebutMaj,
        

      ]);


    }


    /**
     * @Route("/rapport/repertoire", name="app_rapport_repertoire")
     */
    public function index(Request $request,EntityManagerInterface $entityManager): Response
    {
        $dateDebut="";
        $dateFin="";
        ini_set("memory_limit", -1);
        ini_set ( 'max_execution_time', -1);

        if($request->get("exporter")){
         return $this->exportRepertoire( $request,$entityManager);
        }
       
        
        if($request->get("filtrer")){
            $dateDebut=$request->get("dateDebut");
            $dateFin=$request->get("dateFin");
            $departement=$entityManager->getRepository(Repertoire::class)->findNombreRepertoireDepartement($dateDebut,$dateFin);
            $activiter=$entityManager->getRepository(Repertoire::class)->findNombreRepertoireActiviter($dateDebut,$dateFin);
            $ville=$entityManager->getRepository(Repertoire::class)->findNombreRepertoireVille($dateDebut,$dateFin);
            $control=$entityManager->getRepository(Repertoire::class)->findNombreRepertoireControle($dateDebut,$dateFin);
            $formjuridique=$entityManager->getRepository(Repertoire::class)->findNombreRepertoireFormJuriduque($dateDebut,$dateFin);
            $repertoire= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoire($dateDebut,$dateFin));
            $regionDakar= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("01",$dateDebut,$dateFin));
            $regionZIGUINCHOR= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("02",$dateDebut,$dateFin));
            $regionDIOURBEL= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("03",$dateDebut,$dateFin));
            $regionSL= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("04",$dateDebut,$dateFin));
            $regionTAMBACOUNDA= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("05",$dateDebut,$dateFin));
            $regionKAOLACK= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("06",$dateDebut,$dateFin));
            $regionTHIES= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("07",$dateDebut,$dateFin));
            $regionLOUGA= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("08",$dateDebut,$dateFin));
            $regionFATICK= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("09",$dateDebut,$dateFin));
            $regionKOLDA= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("10",$dateDebut,$dateFin));
            $regionMATAM= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("11",$dateDebut,$dateFin));
            $regionKAFFRINE= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("12",$dateDebut,$dateFin));
            $regionKEDOUGOU= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("13",$dateDebut,$dateFin));
            $regionSEDHIOU= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("14",$dateDebut,$dateFin));
            $nonLocaliser=$entityManager->getRepository(Repertoire::class)->findNombreRepertoireNonLocaliser($dateDebut,$dateFin);
        }else{
            $nonLocaliser=$entityManager->getRepository(Repertoire::class)->findNombreRepertoireNonLocaliser(null,null);
            $activiter=$entityManager->getRepository(Repertoire::class)->findNombreRepertoireActiviter(null,null);
            $departement=$entityManager->getRepository(Repertoire::class)->findNombreRepertoireDepartement(null,null);
            $repertoire= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoire(null,null));
            $ville=$entityManager->getRepository(Repertoire::class)->findNombreRepertoireVille(null,null);
            $control=$entityManager->getRepository(Repertoire::class)->findNombreRepertoireControle(null,null);
            $formjuridique=$entityManager->getRepository(Repertoire::class)->findNombreRepertoireFormJuriduque(null,null);
            $regionDakar= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("01",null,null));
            $regionZIGUINCHOR= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("02",null,null));
            $regionDIOURBEL= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("03",null,null));
            $regionSL= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("04",null,null));
            $regionTAMBACOUNDA= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("05",null,null));
            $regionKAOLACK= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("06",null,null));
            $regionTHIES= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("07",null,null));
            $regionLOUGA= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("08",null,null));
            $regionFATICK= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("09",null,null));
            $regionKOLDA= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("10",null,null));
            $regionMATAM= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("11",null,null));
            $regionKAFFRINE= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("12",null,null));
            $regionKEDOUGOU= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("13",null,null));
            $regionSEDHIOU= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("14",null,null));
        }
        
        $regions=[ $regionDakar, $regionZIGUINCHOR,$regionDIOURBEL,$regionSL,$regionTAMBACOUNDA,$regionKAOLACK,$regionTHIES,$regionLOUGA,
        $regionFATICK,$regionKOLDA,$regionMATAM,$regionKAFFRINE,$regionKEDOUGOU,$regionSEDHIOU,$nonLocaliser];
        $regionLabel=["Dakar","Ziguinchor","Diourbel","Saint-Louis","Tambacounda","Kaolack","Thies","Louga","Fatick","Koldat","Matam","Kaffrine","Kedougou","Sedhiou","Non localisÃ©"];
        
        $departementNombre=[];
        $departementLibelle=[];

        foreach ($departement as $key ) {
           array_push($departementNombre,$key["nombre"]);
           array_push($departementLibelle,$key["description"]);
        }

        $villeNombre=[];
        $villeLibelle=[];

        foreach ($ville as $key ) {
           array_push($villeNombre,$key["nombre"]);
           array_push($villeLibelle,$key["libelle"]);
        }


        $controlNombre=[];
        $controlLibelle=[];

        foreach ($control as $key ) {
           array_push($controlNombre,$key["nombre"]);
           array_push($controlLibelle,$key["libelle"]);
        }

        

        $fjNombre=[];
        $fjLibelle=[];

        foreach ($formjuridique as $key ) {
           array_push($fjNombre,$key["nombre"]);
           array_push($fjLibelle,$key["libelle"]);
        }


        $activiterNombre=[];
        $activiterLibelle=[];

        foreach ($activiter as $key ) {
           array_push($activiterNombre,$key["nombre"]);
           array_push($activiterLibelle,$key["libelle"]);
        }
    

      
        
        return $this->render('rapport_repertoire/index.html.twig', [
            'regions' => $regions,
            'regionLabel' => $regionLabel,
            "dateFin"=> $dateFin,
            "dateDebut"=> $dateDebut,
            "repertoire"=> $repertoire,
            "departementNombre"=> $departementNombre,
            "departementLibelle"=> $departementLibelle,
            "villeNombre"=> $villeNombre,
            "villeLibelle"=> $villeLibelle,
            "controlNombre"=> $controlNombre,
            "controlLibelle"=> $controlLibelle,
            "fjNombre"=> $fjNombre,
            "fjLibelle"=> $fjLibelle,
            "activiterNombre"=> $activiterNombre,
            "activiterLibelle"=> $activiterLibelle,
        ]);
    }


    public function exportRepertoire( $request, $entityManager)
    {
        ini_set("memory_limit", -1);
        ini_set ( 'max_execution_time', -1);
        // recuperer les parametres du formulaire 


    
        $dateDebut=$request->get("dateDebut");
        $dateFin=$request->get("dateFin");
        $departement=$entityManager->getRepository(Repertoire::class)->findNombreRepertoireDepartement($dateDebut,$dateFin);
        $activiter=$entityManager->getRepository(Repertoire::class)->findNombreRepertoireActiviter($dateDebut,$dateFin);
        $ville=$entityManager->getRepository(Repertoire::class)->findNombreRepertoireVille($dateDebut,$dateFin);
        $control=$entityManager->getRepository(Repertoire::class)->findNombreRepertoireControle($dateDebut,$dateFin);
        $formjuridique=$entityManager->getRepository(Repertoire::class)->findNombreRepertoireFormJuriduque($dateDebut,$dateFin);
        $repertoire= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoire($dateDebut,$dateFin));
        $regionDakar= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("01",$dateDebut,$dateFin));
        $regionZIGUINCHOR= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("02",$dateDebut,$dateFin));
        $regionDIOURBEL= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("03",$dateDebut,$dateFin));
        $regionSL= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("04",$dateDebut,$dateFin));
        $regionTAMBACOUNDA= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("05",$dateDebut,$dateFin));
        $regionKAOLACK= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("06",$dateDebut,$dateFin));
        $regionTHIES= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("07",$dateDebut,$dateFin));
        $regionLOUGA= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("08",$dateDebut,$dateFin));
        $regionFATICK= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("09",$dateDebut,$dateFin));
        $regionKOLDA= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("10",$dateDebut,$dateFin));
        $regionMATAM= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("11",$dateDebut,$dateFin));
        $regionKAFFRINE= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("12",$dateDebut,$dateFin));
        $regionKEDOUGOU= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("13",$dateDebut,$dateFin));
        $regionSEDHIOU= count($entityManager->getRepository(Repertoire::class)->findNombreRepertoireParRegion("14",$dateDebut,$dateFin));
        $nonLocaliser=$entityManager->getRepository(Repertoire::class)->findNombreRepertoireNonLocaliser($dateDebut,$dateFin);
        
        $regions=[ $regionDakar, $regionZIGUINCHOR,$regionDIOURBEL,$regionSL,$regionTAMBACOUNDA,$regionKAOLACK,$regionTHIES,$regionLOUGA,
        $regionFATICK,$regionKOLDA,$regionMATAM,$regionKAFFRINE,$regionKEDOUGOU,$regionSEDHIOU,$nonLocaliser];
        $regionLabel=["Dakar","Ziguinchor","Diourbel","Saint-Louis","Tambacounda","Kaolack","Thies","Louga","Fatick","Koldat","Matam","Kaffrine","Kedougou","Sedhiou","Non localisÃ©"];
        

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
       

        $activeSheet = $spreadsheet->getActiveSheet();
        $activeSheet->setTitle('RÃ©gion');
       

        $activeSheet->setCellValue('A1', 'RÃ©gion')
        ->setCellValue('B1', 'Nombre de rÃ©pertoire');

        $i = 2;
        $j=0;
        foreach ($regions as $reg ) {

            $activeSheet->getCell('A'.$i)->setValueExplicit( $regionLabel[$j], DataType::TYPE_STRING2 );
            $activeSheet->getCell('B'.$i)->setValueExplicit( $reg, DataType::TYPE_NUMERIC);
            $i++;
            $j++;
        }

        $worksheet = $spreadsheet->createSheet();
        $worksheet->setTitle('DÃ©partement');
        $worksheet->setCellValue('A1', 'DÃ©partement')->setCellValue('B1', 'Nombre de rÃ©pertoire');

        $i = 2;
        foreach ($departement as $key ) {
            $worksheet->getCell('A'.$i)->setValueExplicit( $key["description"], DataType::TYPE_STRING2 );
            $worksheet->getCell('B'.$i)->setValueExplicit( $key["nombre"], DataType::TYPE_NUMERIC );
            $i++;
        }


        $worksheet = $spreadsheet->createSheet();
        $worksheet->setTitle('Ville');
        $worksheet->setCellValue('A1', 'CAV')->setCellValue('B1', 'Nombre de rÃ©pertoire');

        $i = 2;
       
        foreach ($ville as $key ) {
           
            $worksheet->getCell('A'.$i)->setValueExplicit( $key["libelle"], DataType::TYPE_STRING2 );
            $worksheet->getCell('B'.$i)->setValueExplicit( $key["nombre"], DataType::TYPE_NUMERIC );
            $i++;
         }


         $worksheet = $spreadsheet->createSheet();
         $worksheet->setTitle('Form juridique');
         $worksheet->setCellValue('A1', 'Form juridique')->setCellValue('B1', 'Nombre de rÃ©pertoire');
 
         $i = 2;


         foreach ($formjuridique as $key ) {
            $worksheet->getCell('A'.$i)->setValueExplicit( $key["libelle"], DataType::TYPE_STRING2 );
            $worksheet->getCell('B'.$i)->setValueExplicit( $key["nombre"], DataType::TYPE_NUMERIC );
            $i++;
         }


         $worksheet = $spreadsheet->createSheet();
         $worksheet->setTitle('ContrÃ´le');
         $worksheet->setCellValue('A1', 'ContrÃ´le')->setCellValue('B1', 'Nombre de rÃ©pertoire');
 
         $i = 2;
          
         foreach ($control as $key ) {
            $worksheet->getCell('A'.$i)->setValueExplicit( $key["libelle"], DataType::TYPE_STRING2 );
            $worksheet->getCell('B'.$i)->setValueExplicit( $key["nombre"], DataType::TYPE_NUMERIC );
            $i++;
         }



         
         $worksheet = $spreadsheet->createSheet();
         $worksheet->setTitle('ActivitÃ©');
         $worksheet->setCellValue('A1', 'ActivitÃ©')->setCellValue('B1', 'Nombre de rÃ©pertoire');
 
         $i = 2;
         
         foreach ($activiter as $key ) {
            $worksheet->getCell('A'.$i)->setValueExplicit( $key["libelle"], DataType::TYPE_STRING2 );
            $worksheet->getCell('B'.$i)->setValueExplicit( $key["nombre"], DataType::TYPE_NUMERIC );
            $i++;
         }
         
        

       //output headers
            // $activeSheet->fromArray(array_keys($columnNames, NULL, 'A1'));
            
        $writer = new Xlsx($spreadsheet);
        //$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $fileName = "rapportRepertoire.xlsx";
        
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
     * @Route("/rapport/verification", name="app_rapport_verification")
     */
    public function verificationDonneesNMoinsUnFouriniesEnN(Request $request): Response
    {
        ini_set("memory_limit", -1);
        ini_set ( 'max_execution_time', -1);
        // recuperer les parametres du formulaire 
        if ($request->get('annee-input')) {
            
            $annee = $request->get('annee-input');

            // get tous les etats fiannciers avec des donnÃƒÂ©es en n-1 

            // first find all-repertoire 
            # $tousRepertoires = $this->getDoctrine()->getRepository(Repertoire::class)->findAll();
            /*$tousBilans = $this->getDoctrine()->getRepository(Bilan::class)->findBy(["anneeFinanciere"=>$annee]);
            $tousComptes = $this->getDoctrine()->getRepository(CompteDeResultats::class)->findBy(["annee_financiere"=>$annee]);
            $tousFluxTresor = $this->getDoctrine()->getRepository(FluxDesTresoreries::class)->findBy(["annee_financiere"=>$annee]);*/
           
             // Create new Spreadsheet object
            $spreadsheet = new Spreadsheet();
            $activeSheet = $spreadsheet->getActiveSheet();
            $spreadsheet->setActiveSheetIndex(0);
            $activeSheet->setTitle('Bilan Actif');
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
              $sql = "SELECT ref_code, annee_financiere, net1, code_cuci, cuci_bilan.type as cat FROM cuci_bilan inner join cuci_repertoire on cuci_repertoire.id=cuci_bilan.repertoire_id where cuci_bilan.type='".$act."' and cuci_bilan.annee_financiere=".$annee."  ORDER BY  ref_code ASC ,code_cuci ASC ;";
              $tousBilans = $conn->prepare($sql);
              $stmt=$tousBilans->executeQuery();
              $tousBilansActif = $stmt->fetchAllAssociative();

              $anneen=intval($annee)+1;
              $sql2 = "SELECT ref_code, annee_financiere, net2, code_cuci, cuci_bilan.type as cat FROM cuci_bilan inner join cuci_repertoire on cuci_repertoire.id=cuci_bilan.repertoire_id where cuci_bilan.type='".$act."' and cuci_bilan.annee_financiere=".$anneen."  ORDER BY  ref_code ASC, code_cuci ASC;";
              $allbilans = $conn->prepare($sql2);
              $stmt=$allbilans->executeQuery();
              $tousBilansN_1Actif = $stmt->fetchAllAssociative();


              $sql = "SELECT ref_code, annee_financiere, net1, code_cuci, cuci_bilan.type as cat FROM cuci_bilan inner join cuci_repertoire on cuci_repertoire.id=cuci_bilan.repertoire_id where cuci_bilan.type='".$pass."' and cuci_bilan.annee_financiere=".$annee."  ORDER BY  ref_code ASC ,code_cuci ASC ;";
              $tousBilans = $conn->prepare($sql);
              $stmt=$tousBilans->executeQuery();
              $tousBilansPassif = $stmt->fetchAllAssociative();

              $anneen=intval($annee)+1;
              $sql2 = "SELECT ref_code, annee_financiere, net2, code_cuci, cuci_bilan.type as cat FROM cuci_bilan inner join cuci_repertoire on cuci_repertoire.id=cuci_bilan.repertoire_id where cuci_bilan.type='".$pass."' and cuci_bilan.annee_financiere=".$anneen."  ORDER BY  ref_code ASC, code_cuci ASC;";
              $allbilans = $conn->prepare($sql2);
              $stmt=$allbilans->executeQuery();
              $tousBilansN_1Passif = $stmt->fetchAllAssociative();
         
            
              $indice=0;
              foreach ($tousBilansActif as $key_bilan ) {

                
                if ($key_bilan['cat']=="Actif") {

                    
                    
                    // traitement des valeurs NET2 de N
                    $activeSheet->getCell('A'.$i)->setValueExplicit( "Bilan actif", DataType::TYPE_STRING2);
                    $activeSheet->getCell('B'.$i)->setValueExplicit( $key_bilan['code_cuci'], DataType::TYPE_STRING2);
                    $activeSheet->getCell('C'.$i)->setValueExplicit( $key_bilan['ref_code'], DataType::TYPE_STRING2);
                    $activeSheet->getCell('D'.$i)->setValueExplicit( "NET", DataType::TYPE_STRING2);
                    $activeSheet->getCell('E'.$i)->setValueExplicit( $key_bilan['annee_financiere'], DataType::TYPE_STRING2);
                    $activeSheet->getCell('F'.$i)->setValueExplicit( $key_bilan['net1'], DataType::TYPE_STRING2);
                    $activeSheet->getCell('G'.$i)->setValueExplicit( $key_bilan['annee_financiere'], DataType::TYPE_STRING2);
                    
                    $i++; 
                    
                    if($indice<count($tousBilansN_1Actif)){
                    $activeSheet->getCell('A'.$i)->setValueExplicit( "Bilan actif", DataType::TYPE_STRING2);
                    $activeSheet->getCell('B'.$i)->setValueExplicit( $tousBilansN_1Actif[$indice]['code_cuci'], DataType::TYPE_STRING2);
                    $activeSheet->getCell('C'.$i)->setValueExplicit( $tousBilansN_1Actif[$indice]['ref_code'], DataType::TYPE_STRING2);
                    $activeSheet->getCell('D'.$i)->setValueExplicit( "NET", DataType::TYPE_STRING2);
                    $activeSheet->getCell('E'.$i)->setValueExplicit( $tousBilansN_1Actif[$indice]['annee_financiere']-1, DataType::TYPE_STRING2);
                    $activeSheet->getCell('F'.$i)->setValueExplicit( $tousBilansN_1Actif[$indice]['net2'], DataType::TYPE_STRING2);
                    $activeSheet->getCell('G'.$i)->setValueExplicit( $tousBilansN_1Actif[$indice]['annee_financiere'], DataType::TYPE_STRING2);
                    
                    $i++; 

                    $indice++;
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


                    // exporter les valeurs NET2 
                    $activeSheet->getCell('A'.$i)->setValueExplicit( "Bilan passif", DataType::TYPE_STRING2);
                    $activeSheet->getCell('B'.$i)->setValueExplicit( $key_bilan['code_cuci'], DataType::TYPE_STRING2);
                    $activeSheet->getCell('C'.$i)->setValueExplicit( $key_bilan['ref_code'], DataType::TYPE_STRING2);
                    $activeSheet->getCell('D'.$i)->setValueExplicit( "NET", DataType::TYPE_STRING2);
                    $activeSheet->getCell('E'.$i)->setValueExplicit( $key_bilan['annee_financiere'], DataType::TYPE_STRING2);
                    $activeSheet->getCell('F'.$i)->setValueExplicit( $key_bilan['net1'], DataType::TYPE_STRING2);
                    $activeSheet->getCell('G'.$i)->setValueExplicit( $key_bilan['annee_financiere'], DataType::TYPE_STRING2);
                    

                    $i++;

                    if($indice<count($tousBilansN_1Passif)){
                    $activeSheet->getCell('A'.$i)->setValueExplicit( "Bilan actif", DataType::TYPE_STRING2);
                    $activeSheet->getCell('B'.$i)->setValueExplicit( $tousBilansN_1Passif[$indice]['code_cuci'], DataType::TYPE_STRING2);
                    $activeSheet->getCell('C'.$i)->setValueExplicit( $tousBilansN_1Passif[$indice]['ref_code'], DataType::TYPE_STRING2);
                    $activeSheet->getCell('D'.$i)->setValueExplicit( "NET", DataType::TYPE_STRING2);
                    $activeSheet->getCell('E'.$i)->setValueExplicit( $tousBilansN_1Passif[$indice]['annee_financiere']-1, DataType::TYPE_STRING2);
                    $activeSheet->getCell('F'.$i)->setValueExplicit( $tousBilansN_1Passif[$indice]['net2'], DataType::TYPE_STRING2);
                    $activeSheet->getCell('G'.$i)->setValueExplicit( $tousBilansN_1Passif[$indice]['annee_financiere'], DataType::TYPE_STRING2);
                    
                    $i++;
                    $indice++;
                    }
    
                  

                    
                    
                }else {
                    # code...
                }
                
              }


            }elseif($request->get('table')==2){
              $sql = 'SELECT ref_code, annee_financiere, net1, code_cuci FROM cuci_compte_de_resultats inner join cuci_repertoire on cuci_repertoire.id=cuci_compte_de_resultats.cuci_rep_code_id where cuci_compte_de_resultats.annee_financiere='.$annee;
              $tousComptes = $conn->prepare($sql);
              $stmt=$tousComptes->executeQuery();
              $tousComptes= $stmt->fetchAllAssociative();

              $anneen=intval($annee)+1;
              $sqln = 'SELECT ref_code, annee_financiere, net2, code_cuci FROM cuci_compte_de_resultats inner join cuci_repertoire on cuci_repertoire.id=cuci_compte_de_resultats.cuci_rep_code_id where cuci_compte_de_resultats.annee_financiere='.$anneen;
              $tousComptes_n = $conn->prepare($sqln);
              $stmt=$tousComptes_n->executeQuery();
              $tousComptes_n= $stmt->fetchAllAssociative();
              
              $indice=0;
              // compte de resultats put into xlsx file 
              foreach ($tousComptes as $key_compte ) {
                      
                /// compte resultat NET2
                $activeSheet->getCell('A'.$i)->setValueExplicit( "Compte de résultats", DataType::TYPE_STRING2);
                $activeSheet->getCell('B'.$i)->setValueExplicit( $key_compte['code_cuci'], DataType::TYPE_STRING2);
                $activeSheet->getCell('C'.$i)->setValueExplicit( $key_compte['ref_code'], DataType::TYPE_STRING2);
                $activeSheet->getCell('D'.$i)->setValueExplicit( "NET", DataType::TYPE_STRING2);
                $activeSheet->getCell('E'.$i)->setValueExplicit( $key_compte['annee_financiere'], DataType::TYPE_STRING2);
                $activeSheet->getCell('F'.$i)->setValueExplicit( $key_compte['net1'], DataType::TYPE_STRING2);
                $activeSheet->getCell('G'.$i)->setValueExplicit( $key_compte['annee_financiere'], DataType::TYPE_STRING2);
                
                $i++;



        
        

                if ($indice<count($tousComptes_n) ) {
                  $activeSheet->getCell('A'.$i)->setValueExplicit( "Compte de résultats", DataType::TYPE_STRING2);
                  $activeSheet->getCell('B'.$i)->setValueExplicit( $tousComptes_n[$indice]['code_cuci'], DataType::TYPE_STRING2);
                  $activeSheet->getCell('C'.$i)->setValueExplicit( $tousComptes_n[$indice]['ref_code'], DataType::TYPE_STRING2);
                  $activeSheet->getCell('D'.$i)->setValueExplicit( "NET", DataType::TYPE_STRING2);
                  $activeSheet->getCell('E'.$i)->setValueExplicit( $tousComptes_n[$indice]['annee_financiere']-1, DataType::TYPE_STRING2);
                  $activeSheet->getCell('F'.$i)->setValueExplicit( $tousComptes_n[$indice]['net2'], DataType::TYPE_STRING2);
                  $activeSheet->getCell('G'.$i)->setValueExplicit( $tousComptes_n[$indice]['annee_financiere'], DataType::TYPE_STRING2);
                  
                  $i++;
                  $indice++;

                }
              }


            }else{
              $sql = 'SELECT ref_code, annee_financiere, net1, code_cuci FROM cuci_etats_des_tresoreries inner join cuci_repertoire on cuci_repertoire.id=cuci_etats_des_tresoreries.cuci_rep_code_id where cuci_etats_des_tresoreries.annee_financiere='.$annee;
              $tousFluxTresor = $conn->prepare($sql);
              $tousFluxTresor=$tousFluxTresor->executeQuery()->fetchAllAssociative();

              $anneen=intval($annee)+1;
              $sqln = 'SELECT ref_code, annee_financiere, net2, code_cuci FROM cuci_etats_des_tresoreries inner join cuci_repertoire on cuci_repertoire.id=cuci_etats_des_tresoreries.cuci_rep_code_id where cuci_etats_des_tresoreries.annee_financiere='.$anneen;
              $tousFluxTresorn = $conn->prepare($sqln);
              $tousFluxTresorn=$tousFluxTresorn->executeQuery()->fetchAllAssociative();
              
              $indice=0;
               // put content of flux de tresorerie into xlsx file 
              foreach ($tousFluxTresor as $key_tresoreri ) {
                ////traitement du NET2
                $activeSheet->getCell('A'.$i)->setValueExplicit( "Flux de trÃƒÂ©sorerie", DataType::TYPE_STRING2);
                $activeSheet->getCell('B'.$i)->setValueExplicit( $key_tresoreri['code_cuci'], DataType::TYPE_STRING2);
                $activeSheet->getCell('C'.$i)->setValueExplicit( $key_tresoreri['ref_code'], DataType::TYPE_STRING2);
                $activeSheet->getCell('D'.$i)->setValueExplicit( "NET", DataType::TYPE_STRING2);
                $activeSheet->getCell('E'.$i)->setValueExplicit( $key_tresoreri['annee_financiere'], DataType::TYPE_STRING2);
                $activeSheet->getCell('F'.$i)->setValueExplicit( $key_tresoreri['net1'], DataType::TYPE_STRING2);
                $activeSheet->getCell('G'.$i)->setValueExplicit( $key_tresoreri['annee_financiere'], DataType::TYPE_STRING2);
                
                $i++;



                
        
              

                if ($indice<count($tousFluxTresorn)) {
                    $activeSheet->getCell('A'.$i)->setValueExplicit( "Flux de trésorerie", DataType::TYPE_STRING2);
                    $activeSheet->getCell('B'.$i)->setValueExplicit( $tousFluxTresorn[$indice]['code_cuci'], DataType::TYPE_STRING2);
                    $activeSheet->getCell('C'.$i)->setValueExplicit( $tousFluxTresorn[$indice]['ref_code'], DataType::TYPE_STRING2);
                    $activeSheet->getCell('D'.$i)->setValueExplicit( "NET", DataType::TYPE_STRING2);
                    $activeSheet->getCell('E'.$i)->setValueExplicit( $tousFluxTresorn[$indice]['annee_financiere']-1, DataType::TYPE_STRING2);
                    $activeSheet->getCell('F'.$i)->setValueExplicit( $tousFluxTresorn[$indice]['net2'], DataType::TYPE_STRING2);
                    $activeSheet->getCell('G'.$i)->setValueExplicit( $tousFluxTresorn[$indice]['annee_financiere'], DataType::TYPE_STRING2);
                    
                    $i++;
                    $indice++;

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

            $fileName = "verificationAnnee.xlsx";
            
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
        return $this->render('rapport_repertoire/_verification_annee.html.twig', [
            'controller_name' => 'DataCubingController',
        ]);
    }


}
