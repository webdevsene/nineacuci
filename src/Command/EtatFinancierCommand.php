<?php
namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Entity\Repertoire;
use App\Entity\Bilan;
use App\Entity\User;
use App\Entity\CuciImmoPlus;
use App\Entity\ImmoBrut;
use App\Entity\Effectifs;
use App\Entity\ProductionDeExercice;
use App\Entity\CompteDeResultats;
use App\Entity\FluxDesTresoreries;
use App\Entity\AchatProduction;
use App\Entity\ProductionDeExerciceUtil;
use App\Entity\AchatProductionUtil;
use App\Entity\CuciMigLog;
use App\Repository\CuciMigLogRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;


class EtatFinancierCommand extends Command
{
    protected static $defaultName = 'etatfinancier:import';

    private  $entityManager;
    private $container;

    public function __construct(EntityManagerInterface  $entityManager,ContainerInterface $container)
    {
        // 3. Update the value of the private entityManager variable through injection
        $this->entityManager =  $entityManager;
        $this->container = $container;

        parent::__construct();
    }

    protected function configure()
    {
        // ...
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        ini_set("memory_limit", '1280M');
        ini_set ( 'max_execution_time', -1);  
        ini_set ( 'upload_max_filesize', -1);  
       
        $etatfinanciers=$this->container->getParameter("path_absolu").DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."etatfinanciers";
       
        $dossier = scandir($etatfinanciers);


        $spreadsheet_log = new Spreadsheet();
        $activeExcel = $spreadsheet_log->getActiveSheet();
        $activeExcel->setCellValue('A1', 'NINEA/NINET');
        $activeExcel->setCellValue('B1', 'CUCI');
        $activeExcel->setCellValue('C1', 'Année');
        $activeExcel->setCellValue('D1', 'Table');
        $activeExcel->setCellValue('E1', 'Etat');
        $activeExcel->setCellValue('F1', 'Description');
        $countExcel=2;
        

        $dossiertemp=uniqid();
        $date=new \DateTime();
        $dossiertemp=$date->format("d_m_Y")."_".$dossiertemp;
        $logetatfinanciers=$this->container->getParameter("path_absolu").DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."logetatfinanciers";
       
        $nombreFichier=0;
        $taberreur=[];
        foreach($dossier as $fichier){
            if($fichier != '.' && $fichier != '..'){
              try {
                    $nombreFichier++;
                    $spreadsheet = IOFactory::load($etatfinanciers.DIRECTORY_SEPARATOR.$fichier);
                
                    $nomFichier= explode(".",$fichier);
                    $tabnomFichier= explode("_",$nomFichier[0]);
                    
                    $ws=$spreadsheet->getSheet(1);
                
                    $rows = $ws->toArray();
                    $ninea=$tabnomFichier[0];
                    $annee=$tabnomFichier[2];
                    $verifiedAnnee=0;
                    $errorBilan="";
                    $errorcompteDeResultat="";
                    $errorflux="";
                    $errorimmobrut="";
                    $errorimmoplus="";
                    $erroreffectif="";
                    $erroreproduction="";
                    $erroreachat="";
                    $error=0;

                    $repertoire= $this->entityManager->getRepository(Repertoire::class)->findOneBy(["ninea"=>$ninea]);
                    $user= $this->entityManager->getRepository(User::class)->find("4f4acee7-9641-401a-9cca-fb5c149345f3");
                
                    
                    if($repertoire){
                        // Bilan
                        $bilan=$spreadsheet->getSheetByName("BILAN PAYSAGE");
                        if($bilan){
                            $rowsBilan=$bilan->toArray();
                            $bn= $this->entityManager->getRepository(Bilan::class)->findByCodeCuci($repertoire->getCodeCuci(),$annee,"Actif");
                            if(count($bn)>1){
                                $errorBilan="Info : l'etat financier pour le  bilan  est déjà chargé pour l'année ".$annee."\n" ;
                                $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                                $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                                $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                                $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "BILAN", DataType::TYPE_STRING2);
                                $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Info", DataType::TYPE_STRING2);
                                $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "L'etat financier pour le  bilan  est déjà chargé pour l'année", DataType::TYPE_STRING2);
                                $countExcel++;
                            }
                            else{
                                if(count($rowsBilan)>=31){
                                    for ($i=2; $i <=30 ; $i++) { 
                                        if(count($rowsBilan[$i])>=11){
                                        $bilan = new Bilan();
                                        $bilanPassif = new Bilan();
                                        $bilan->setAnneeFinanciere($annee);
                                        $bilan->setRepertoire($repertoire);
                                        $bilan->setDemat(true);
                                        
                                        
                                        if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsBilan[$i][3])))
                                            $bilan->setBrut(preg_replace('/[^0-9-]/',"",$rowsBilan[$i][3]));
                                        
                                        if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsBilan[$i][4])))
                                            $bilan->setAmortPR(preg_replace('/[^0-9-]/',"",$rowsBilan[$i][4]));

                                        if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsBilan[$i][5]))) 
                                            $bilan->setNet1(preg_replace('/[^0-9-]/',"",$rowsBilan[$i][5]));

                                        if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsBilan[$i][6])))  
                                            $bilan->setNet2(preg_replace('/[^0-9-]/',"",$rowsBilan[$i][6]));

                                        $bilan->setRefCode(strtoupper(str_replace(" ","",$rowsBilan[$i][0])));
                                        $bilan->setType("Actif");
                                        $bilan->setSubmit(false);
                                        $bilan->setUploadedFileName(1);
                                        $bilan->setCreatedBy($user);
                                        $bilan->setModifiedBy($user);
                                        $this->entityManager->persist($bilan);
                                        $this->entityManager->flush();
                                        

                                        ///  Bilan passif
                                        $bn= $this->entityManager->getRepository(Bilan::class)->findByCodeCuci($repertoire->getCodeCuci(),$annee,"Passif");
                                        $bilanPassif->setAnneeFinanciere($annee);
                                        $bilanPassif->setRepertoire($repertoire);
                                        if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsBilan[$i][10])))  
                                            $bilanPassif->setNet1(preg_replace('/[^0-9-]/',"",$rowsBilan[$i][10]));
                                        if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsBilan[$i][11]))) 
                                            $bilanPassif->setNet2(preg_replace('/[^0-9-]/',"",$rowsBilan[$i][11]));
                                        if(strtoupper(str_replace(" ","",$rowsBilan[$i][7]))!="CJ")
                                        $bilanPassif->setRefCode(strtoupper(str_replace(" ","",$rowsBilan[$i][7])));
                                        else
                                        $bilanPassif->setRefCode("CI");
                                        $bilanPassif->setType("Passif");
                                        $bilanPassif->setUploadedFileName(1);
                                        $bilanPassif->setSubmit(false);
                                        $bilan->setCreatedBy($user);
                                        $bilan->setModifiedBy($user);
                                        $this->entityManager->persist($bilanPassif);
                                        $this->entityManager->flush();
                                    }
                                }
                                }else{
                                    $errorBilan="Erreur de format : Vérifier le format du fichier pour bilan [".$ninea."]   \n" ; 
                                    $error=1; 
                                    $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                                    $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                                    $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                                    $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "BILAN", DataType::TYPE_STRING2);
                                    $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Erreur", DataType::TYPE_STRING2);
                                    $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "Le format du fichier pour bilan n'est pas correcte", DataType::TYPE_STRING2);
                                    $countExcel++;
                                
                                }
                            
                            }
                        
                        }else{
                            $error=1; 
                            $errorBilan="Erreur : Vérifier si le fichier contient une feuille nommée <<BILAN PAYSAGE>>"."\n" ;

                            $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                            $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                            $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                            $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "BILAN", DataType::TYPE_STRING2);
                            $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Erreur", DataType::TYPE_STRING2);
                            $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "Vérifier si le fichier contient une feuille nommée <<BILAN PAYSAGE>>", DataType::TYPE_STRING2);
                            $countExcel++;
                        }
                        // CompteResultat
                    $compteResultat=$spreadsheet->getSheetByName("COMPTE DE RESULTAT");
                        if($compteResultat){
                            $cr =  $this->entityManager->getRepository(CompteDeResultats::class)->findByCodeCuci($repertoire->getCodeCuci(),$annee); 
                            if(count($cr)>1){

                                $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                                $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                                $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                                $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "COMPTE DE RESULTAT", DataType::TYPE_STRING2);
                                $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Info", DataType::TYPE_STRING2);
                                $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "L'etat financier pour le compte de resultat est déjà chargé pour l'année", DataType::TYPE_STRING2);
                                $countExcel++; 
                                $errorcompteDeResultat="L'etat financier pour le compte de resultat est déjà chargé pour l'année";
                            
                            }
                            else{
                                    $rowscompteResultat=$compteResultat->toArray();
                                    if(count($rowscompteResultat)>=43){
                                        for ($i=1; $i <=42 ; $i++) {
                                            if(count($rowscompteResultat[$i])>=6){
                                                $compteDeResultats = new CompteDeResultats();
                                                $net1=0;
                                                $net2=0;
                                                if(is_numeric(preg_replace('/[^0-9-]/',"",$rowscompteResultat[$i][4])))  
                                                    $net1=preg_replace('/[^0-9-]/',"",$rowscompteResultat[$i][4]);
                                                
                                                if(is_numeric(preg_replace('/[^0-9-]/',"",$rowscompteResultat[$i][5])))  
                                                    $net2=preg_replace('/[^0-9-]/',"",$rowscompteResultat[$i][5]);
                                            
                                                $compteDeResultats->setAnneeFinanciere($annee)
                                                    ->setCuciRepCode($repertoire)
                                                    ->setRefCode(strtoupper(str_replace(" ","",$rowscompteResultat[$i][0])))
                                                    ->setNet1($net1)
                                                    ->setNet2($net2)
                                                    ->setDemat(true)

                                                    ->setModifiedBy($user)
                                                    ->setCreatedBy($user)
                                                    ->setUploadedFileName(1)
                                                
                                                    ->setSubmit(false) ;
                                                $this->entityManager->persist($compteDeResultats);
                                                $this->entityManager->flush();
                                            }
                                        }
                                    }else{
                                        $error=1; 
                                        
                                            $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                                            $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                                            $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                                            $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "COMPTE DE RESULTAT", DataType::TYPE_STRING2);
                                            $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Erreur", DataType::TYPE_STRING2);
                                            $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "Vérifier le format du fichier pour le Compte de resultat", DataType::TYPE_STRING2);
                                            $countExcel++;
                                        $errorcompteDeResultat="Erreur de format: Vérifier le format du fichier pour le Compte de resultat  [".$ninea."] \n" ; 
                                    }
                            }
                    
                        }else{
                            $error=1;
                            $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                            $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                            $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                            $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "COMPTE DE RESULTAT", DataType::TYPE_STRING2);
                            $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Erreur", DataType::TYPE_STRING2);
                            $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "Vérifier si le fichier contient une feuille nommée <<COMPTE DE RESULTAT>>", DataType::TYPE_STRING2);
                            $countExcel++;
                            $errorcompteDeResultat="Erreur : Vérifier si le fichier contient une feuille nommée <<COMPTE DE RESULTAT>>"."\n" ;
                        }
                        //FLUX DE TRESORERIE
                        $flux=$spreadsheet->getSheetByName("FLUX DE TRESORERIE");
                        if($flux){
                            $ef =  $this->entityManager->getRepository(FluxDesTresoreries::class)->findByCodeCuciAnneeAndCategory($repertoire->getCodeCuci(),$annee); 
                            if(count($ef)>1){
                                $errorflux="Info : l'etat financier pour l'etats des flux des trésorerie est déjà chargé pour l'année ".$annee."\n" ;
                                $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                                $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                                $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                                $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "FLUX DE TRESORERIE", DataType::TYPE_STRING2);
                                $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Info", DataType::TYPE_STRING2);
                                $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "l'etat financier pour l'etats des flux des trésorerie est déjà chargé pour l'année", DataType::TYPE_STRING2);
                                $countExcel++;
                            }
                            else{
                                    $rowscompteflux=$flux->toArray();
                                    if(count( $rowscompteflux)>=43){
                                        for ($i=1; $i <=42 ; $i++) {
                                            $flux = new FluxDesTresoreries();
                                            $net1=0;
                                            $net2=0;
                                            if(count($rowscompteflux[$i])>=6){
                                            if(strtoupper(str_replace(" ","",$rowscompteflux[$i][0]))!=""){
                                                if(is_numeric(preg_replace('/[^0-9-]/',"",$rowscompteflux[$i][4])))  
                                                    $net1=preg_replace('/[^0-9-]/',"",$rowscompteflux[$i][4]);
                                                
                                                if(is_numeric(preg_replace('/[^0-9-]/',"", $rowscompteflux[$i][5])))
                                                    $net2=preg_replace('/[^0-9-]/',"", $rowscompteflux[$i][5]);
                                                
                                                

                                                $flux->setAnneeFinanciere($annee)
                                                ->setCuciRepCode($repertoire)
                                                ->setNet1($net1)
                                                ->setNet2($net2)
                                                ->setUploadFileName(1)
                                                ->setSubmit(false) 
                                                ->setDemat(true)
                                                ->setModifiedBy($user)
                                                ->setEditedBy($user);
                                                if(strtoupper(str_replace(" ","",$rowscompteflux[$i][0]))=="XI")
                                                    $flux->setRefCode("ZH");
                                                else
                                                    $flux->setRefCode(strtoupper(str_replace(" ","",$rowscompteflux[$i][0])));

                                                
                                                $this->entityManager->persist($flux);
                                                $this->entityManager->flush();
                                            }
                                            }

                                        }
                                    }else{
                                        $error=1;
                                        $errorflux="Erreur de format :Vérifier le format du fichier pour FLUX DE TRESORERIE [".$ninea."] "."\n" ;
                                        
                                        $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                                        $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                                        $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                                        $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "FLUX DE TRESORERIE", DataType::TYPE_STRING2);
                                        $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Erreur", DataType::TYPE_STRING2);
                                        $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "Vérifier le format du fichier pour FLUX DE TRESORERIE", DataType::TYPE_STRING2);
                                        $countExcel++;
                                    }
                                }
                    
                            
                            
                            }
                            else{
                            $error=1;
                            $errorflux="Erreur : Vérifier si le fichier contient une feuille nommée <<FLUX DE TRESORERIE>>"."\n" ;
                            $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                            $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                            $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                            $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "FLUX DE TRESORERIE", DataType::TYPE_STRING2);
                            $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Erreur", DataType::TYPE_STRING2);
                            $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "Vérifier si le fichier contient une feuille nommée <<FLUX DE TRESORERIE>>", DataType::TYPE_STRING2);
                            $countExcel++;
                        }
                        //Immo brut
                        $immoBrut=$spreadsheet->getSheetByName("Note 3A");
                        if($immoBrut) {
                            $ib =  $this->entityManager->getRepository(ImmoBrut::class)->findByCodeCuci($repertoire->getCodeCuci(),$annee); 
                            if(count($ib)>1){
                                $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                                $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                                $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                                $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "IMMO BRUT", DataType::TYPE_STRING2);
                                $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Info", DataType::TYPE_STRING2);
                                $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "L'etat financier pour immo brut  est déjà chargé pour l'année", DataType::TYPE_STRING2);
                                $countExcel++;
                                $errorimmobrut="Info : l'etat financier pour immo brut  est déjà chargé pour l'année ".$annee."\n" ;
                            }
                                else{
                                    $rowscompteimmoBrut=$immoBrut->toArray();
                                    $code=[9=>"GA",10=>"GB",11=>"GC",12=>"GD",13=>"GE",14=>"GF",15=>"GGA",16=>"GGB",17=>"GHA",18=>'GHB',19=>"GI",20=>"GJ",21=>"GK",22=>"GL",23=>"GM",24=>"GN",25=>"GO",26=>"GP",27=>"GQ"];
                                    if(count($rowscompteimmoBrut)>=29){
                                    for ($i=9; $i <28 ; $i++) {
                                    if(count($rowscompteimmoBrut[$i])>=8){
                                            $immobrut = new ImmoBrut();
                                        
                                            $immobrut->setAnneeFinanciere($annee);
                                            $immobrut->setRefCode($code[$i]);
                                            $immobrut->setSubmit(false);
                                            $immobrut->setDemat(true);
                                            $immobrut->setRepertoire($repertoire);
                                            if(is_numeric(preg_replace('/[^0-9-]/',"",$rowscompteimmoBrut[$i][1]))) 
                                                    $immobrut->setBrutA(preg_replace('/[^0-9-]/',"",$rowscompteimmoBrut[$i][1]));
                                            if(is_numeric(preg_replace('/[^0-9-]/',"",$rowscompteimmoBrut[$i][2]))) 
                                                    $immobrut->setAugmentationB1(preg_replace('/[^0-9-]/',"",$rowscompteimmoBrut[$i][2]));

                                            if(is_numeric(preg_replace('/[^0-9-]/',"",$rowscompteimmoBrut[$i][3]))) 
                                                    $immobrut->setAugmentationB2(preg_replace('/[^0-9-]/',"",$rowscompteimmoBrut[$i][3]));
                                            if(is_numeric(preg_replace('/[^0-9-]/',"",$rowscompteimmoBrut[$i][4]))) 
                                                    $immobrut->setAugmentationB3(preg_replace('/[^0-9-]/',"",$rowscompteimmoBrut[$i][4]));
                                            if(is_numeric(preg_replace('/[^0-9-]/',"",$rowscompteimmoBrut[$i][5]))) 
                                                    $immobrut->setDiminutionC1(preg_replace('/[^0-9-]/',"",$rowscompteimmoBrut[$i][5]));
                                            if(is_numeric(preg_replace('/[^0-9-]/',"",$rowscompteimmoBrut[$i][6]))) 
                                                    $immobrut->setDiminutionC2(preg_replace('/[^0-9-]/',"",$rowscompteimmoBrut[$i][6]));
                                            
                                            if(is_numeric(preg_replace('/[^0-9-]/',"",$rowscompteimmoBrut[$i][7]))) 
                                                    $immobrut->setBrutD(preg_replace('/[^0-9-]/',"",$rowscompteimmoBrut[$i][7]));

                                            $immobrut->setCreatedby($user);
                                            $immobrut->setModifiedby($user);
                                            $this->entityManager->persist($immobrut);
                                            $this->entityManager->flush();
                                    
                                        }
                                        
                                        }
                                    }else{
                                        $error=1;
                                        $errorimmobrut="Erreur de format : Vérifier le format du fichier pour  Immobilisations brutes [".$ninea."] "."\n" ;  
                                        $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                                        $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                                        $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                                        $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "IMMO BRUT", DataType::TYPE_STRING2);
                                        $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Erreur", DataType::TYPE_STRING2);
                                        $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "Vérifier le format du fichier pour  Immobilisations brutes", DataType::TYPE_STRING2);
                                        $countExcel++;
                                    } 
                                }
                                }else{
                                    $error=1;
                                    $errorimmobrut="Erreur : Vérifier si le fichier contient une feuille nommée <<Note 3A>>"."\n" ;
                                    $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                                    $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                                    $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                                    $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "IMMO BRUT", DataType::TYPE_STRING2);
                                    $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Erreur", DataType::TYPE_STRING2);
                                    $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "Vérifier si le fichier contient une feuille nommée <<Note 3A>>", DataType::TYPE_STRING2);
                                    $countExcel++;
                                }

                        $immoPlusMoins=$spreadsheet->getSheetByName("Note 3D");
                        if($immoPlusMoins) {
                                    $ip =  $this->entityManager->getRepository(CuciImmoPlus::class)->findByCodeCuci($repertoire->getCodeCuci(),$annee); 
                                    if(count($ip)>1){
                                        $errorimmoplus="Info : l'etat financier pour immobilisations: Plus-value et moins-value de cession est déjà chargé pour l'année ".$annee."\n" ;
                                    
                                        $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                                        $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                                        $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                                        $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "IMMO Plus-value et moins-value", DataType::TYPE_STRING2);
                                        $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Info", DataType::TYPE_STRING2);
                                        $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "L'etat financier pour immobilisations: Plus-value et moins-value de cession est déjà chargé pour l'année", DataType::TYPE_STRING2);
                                        $countExcel++;
                                    }
                                    else{
                                    $rowsimmoPlusMoins=$immoPlusMoins->toArray();
                                    $code=[13=>"PA",9=>"PB",10=>"PC",11=>"PD",12=>"PE",19=>"PF",14=>"PG",15=>"PH",16=>"PI",17=>"PJ",18=>"PK",22=>"PL",20=>"PM",21=>"PN"];
                                    if(count($rowsimmoPlusMoins)>=24){
                                    for ($i=9; $i <23 ; $i++) {
                                    if(count($rowsimmoPlusMoins[$i])>=7){
                                    $immo = new CuciImmoPlus();
                                    $immo->setSubmit(false);
                                    $immo->setAnneeFinanciere($annee);
                                    $immo->setRefCode($code[$i]);
                                    $immo->setRepertoire($repertoire);
                                    $immo->setCreatedBy($user);
                                    $immo->setModifiedby($user);
                                    $immo->setDemat(true);


                                    
                                    if(strtoupper(str_replace(" ","",$rowsimmoPlusMoins[$i][0]))!=""){

                                    if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoPlusMoins[$i][1]))) 
                                        $immo->setBrut(preg_replace('/[^0-9-]/',"",$rowsimmoPlusMoins[$i][1]));
                                    

                                    if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoPlusMoins[$i][2]))) 
                                        $immo->setAmortPr(preg_replace('/[^0-9-]/',"",$rowsimmoPlusMoins[$i][2]));
                                        
                                

                                    if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoPlusMoins[$i][3]))) 
                                        $immo->setValeur(preg_replace('/[^0-9-]/',"",$rowsimmoPlusMoins[$i][3]));
                                    
                                    if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoPlusMoins[$i][4]))) 
                                        $immo->setPrixCession(preg_replace('/[^0-9-]/',"",$rowsimmoPlusMoins[$i][4]));

                                    if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoPlusMoins[$i][5]))) 
                                        $immo->setNet(preg_replace('/[^0-9-]/',"",$rowsimmoPlusMoins[$i][5]));

                                
                                    $this->entityManager->persist($immo);
                                    $this->entityManager->flush();
                                    }
                                    }
                                    }
                                }else{
                                    $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                                    $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                                    $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                                    $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "IMMO Plus-value et moins-value", DataType::TYPE_STRING2);
                                    $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Erreur", DataType::TYPE_STRING2);
                                    $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "Vérifier le format du fichier pour  immobilisations: Plus-value et moins-value", DataType::TYPE_STRING2);
                                    $errorimmoplus="Error de format : Vérifier le format du fichier pour  immobilisations: Plus-value et moins-value [".$ninea."]\n" ;
                                    $countExcel++;
                                }
                                }

                        }else{
                            $error=1;
                            $errorimmoplus="Erreur : Vérifier si le fichier contient une feuille nommée <<Note 3D>>"."\n" ;
                            $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                            $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                            $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                            $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "IMMO Plus-value et moins-value", DataType::TYPE_STRING2);
                            $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Erreur", DataType::TYPE_STRING2);
                            $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "Vérifier si le fichier contient une feuille nommée <<Note 3D>>", DataType::TYPE_STRING2);
                            $countExcel++;
                        }

                        $effectifs=$spreadsheet->getSheetByName("Note 27B");
                        if($effectifs) {
                                                $ef =  $this->entityManager->getRepository(Effectifs::class)->findBy(["repertoire"=>$repertoire,"anneeFinanciere"=>$annee]); 
                                                if(count($ef)>1){
                                                $erroreffectif="Info : l'etat financier pour effectif est déjà chargé pour l'année ".$annee."\n" ;
                                                $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                                                $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                                                $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                                                $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "Effectifs, masse salariale et personnel exterieur", DataType::TYPE_STRING2);
                                                $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Info", DataType::TYPE_STRING2);
                                                $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "l'etat financier pour effectif est déjà chargé pour l'année", DataType::TYPE_STRING2);
                                                $countExcel++;
                                                }
                                                else{
                                                $rowsimmoeffectifs=$effectifs->toArray();
                                                if(count($rowsimmoeffectifs)>=18){
                                                for ($i=9; $i <17 ; $i++) {

                                                if(count($rowsimmoeffectifs[$i])>=16){
                                                    $effectif = new Effectifs();
                                
                                                    $effectif->setAnneeFinanciere($annee);
                                
                                                    $effectif->setRepertoire($repertoire);
                                                if(strtoupper(str_replace(" ","",$rowsimmoeffectifs[$i][0]))!=""){

                                                if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][2]))) 
                                                    $effectif->setNmef(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][2]));
                                                
                                                if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][3])))
                                                    $effectif->setNfef(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][3]));
                                                
                                                if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][4])))
                                                    $effectif->setUmmef(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][4]));
                                                
                                                if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][5])))
                                                    $effectif->setUmfef(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][5]));
                                                
                                                if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][6])))
                                                    $effectif->setHmmef(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][6])); 
                                                
                                                if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][7])))
                                                    $effectif->setHmfef(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][7]));

                                                if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][8])))
                                                    $effectif->setTotalEf(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][8]));
                                                
                                                if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][9])))
                                                    $effectif->setMnmef(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][9]));
                            
                                                if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][10])))
                                                    $effectif->setMnfef(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][10]));
                                                
                                                if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][11])))
                                                    $effectif->setMummef(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][11]));
                                                
                                                if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][12])))
                                                    $effectif->setMumfef(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][12]));
                                                
                                                if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][13])))
                                                    $effectif->setMhmmef(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][13]));
                                                
                                                if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][14])))
                                                    $effectif->setMhmfef(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][14]));
                                                    
                                                if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][15])))
                                                    $effectif->setTotalMs(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][15]));
                                                
                                                    
                                                    $effectif->setRefCode($rowsimmoeffectifs[$i][0]);
                                                    $effectif->setType("Effectif")
                                                            ->setSubmit(false);
                                                
                                                    $effectif->setDemat(true);
                                                
                                                    $effectif->setUploadedFileName(1);  
                                                    $effectif->setUpdatedBy($user);
                                                    $effectif->setCreatedBy($user); 
                                                    $this->entityManager->persist($effectif);
                                                    $this->entityManager->flush();
                                                }
                                                }
                                                }
                                                }else{
                                                        $error=1;
                                                        $erroreffectif="Erreur de format : Vérifier  le format pour effectif [".$ninea."] \n" ;
                                                        $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                                                        $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                                                        $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                                                        $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "Effectifs, masse salariale et personnel exterieur", DataType::TYPE_STRING2);
                                                        $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Erreur", DataType::TYPE_STRING2);
                                                        $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "Vérifier  le format pour effectif", DataType::TYPE_STRING2);
                                                        $countExcel++;
                                                    }
                                                if(count($rowsimmoeffectifs)>=30){
                                                for ($i=20; $i <30 ; $i++) {
                                                if(count($rowsimmoeffectifs[$i])>=10){
                                                if(strtoupper(str_replace(" ","",$rowsimmoeffectifs[$i][0]))!=""){
                                                    $new_effectif = new Effectifs();
                                                    $new_effectif->setAnneeFinanciere($annee);
                                                    $new_effectif->setRepertoire($repertoire);
                                                    
                                                    if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][2])))
                                                        $new_effectif->setNmef(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][2]));
                                                    
                                                    if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][3])))
                                                        $new_effectif->setNfef(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][3]));
                                                        
                                                    if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][4])))
                                                        $new_effectif->setUmmef(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][4]));
                                                    
                                                    if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][5])))
                                                        $new_effectif->setUmfef(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][5]));
                                                    
                                                    if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][6])))
                                                        $new_effectif->setHmmef(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][6]));

                                                    if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][7])))
                                                        $new_effectif->setHmfef(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][7]));

                                                    if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][8])))
                                                        $new_effectif->setTotalEf(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][8]));
                                                        
                                                    if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][9])))
                                                        $new_effectif->setFacm(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][9]));
                                                    
                                                    if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][10])))
                                                        $new_effectif->setFacf(preg_replace('/[^0-9-]/',"",$rowsimmoeffectifs[$i][10]));
                                                
                                                    
                                                    $new_effectif->setRefCode($rowsimmoeffectifs[$i][0]);
                                                    $new_effectif->setType("Personnel")
                                                                ->setSubmit(false);
                                                    $new_effectif->setDemat(true);

                                                    $new_effectif->setUploadedFileName(1); 
                                                    $new_effectif->setUpdatedBy($user);
                                                    $new_effectif->setCreatedBy($user); 
                                                    $this->entityManager->persist($new_effectif);
                                                    $this->entityManager->flush();
                                                }
                                                }
                                            }
                                            }else{
                                                $error=1;
                                                $erroreffectif="Erreur de format : Vérifier  le format  du fichier  pour Effectifs, masse salariale et personnel exterieur  [".$ninea."].\n" ;
                                                $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                                                $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                                                $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                                                $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "Effectifs, masse salariale et personnel exterieur", DataType::TYPE_STRING2);
                                                $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Erreur", DataType::TYPE_STRING2);
                                                $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "Vérifier  le format  du fichier  pour Effectifs, masse salariale et personnel exterieur", DataType::TYPE_STRING2);
                                                $countExcel++;
                                            }
                                            }
                    }else{
                            $error=1;
                            $erroreffectif="Erreur : Vérifier si le fichier contient une feuille nommée <<Note 27B>>"."\n" ;
                            $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                            $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                            $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                            $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "Effectifs, masse salariale et personnel exterieur", DataType::TYPE_STRING2);
                            $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Erreur", DataType::TYPE_STRING2);
                            $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "Vérifier si le fichier contient une feuille nommée <<Note 27B>>", DataType::TYPE_STRING2);
                            $countExcel++;
                        }
                        $production=$spreadsheet->getSheetByName("Note 32");
                        if($production) {
                            $prod =  $this->entityManager->getRepository(ProductionDeExercice::class)->findBy(["repertoire"=>$repertoire,"anneeFinanciere"=>$annee]); 
                            if(count($prod)>1){
                                $erroreproduction="Info : l'etat financier pour production de l'exercice est déjà chargé pour l'année ".$annee."\n" ;
                                $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                                $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                                $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                                $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "Production de l'exercice", DataType::TYPE_STRING2);
                                $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Erreur", DataType::TYPE_STRING2);
                                $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "L'etat financier pour production de l'exercice est déjà chargé pour l'année", DataType::TYPE_STRING2);
                                $countExcel++;
                            }
                            else{
                            $rowsimmoproduction=$production->toArray();
                            if(count($rowsimmoproduction)>=17){
                                $prod_de_exer_util = new ProductionDeExerciceUtil();
                                $this->entityManager->persist($prod_de_exer_util);

                            for ($i=8; $i <17 ; $i++) {
                            if(count($rowsimmoproduction[$i])>=13){
                            if(str_replace(" ","",$rowsimmoproduction[$i][0])!=""){
                                // #pour chaque objet production util, on cree un objet produtionExer
                                $prodExer = new ProductionDeExercice();
                                
                                // # setter les valeur saisie 
                                $prodExer->setRepertoire($repertoire);
                                $prodExer->setProductionDeExerciceUtil($prod_de_exer_util);
                                
                                $prodExer->setAnneeFinanciere($annee)
                                        ->setSubmit(false);
                                
                                $prodExer->setDemat(true);
                                
                                
                                
                                $prodExer->setLibelle($rowsimmoproduction[$i][0]);
                                
                                $prodExer->setUnites($rowsimmoproduction[$i][1]);
                                
                                if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoproduction[$i][2])))
                                    $prodExer->setQtyProdVenduDansEtat(preg_replace('/[^0-9-]/',"",$rowsimmoproduction[$i][2]));
                                
                                if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoproduction[$i][3])))
                                    $prodExer->setValProdVenduDansEtat(preg_replace('/[^0-9-]/',"",$rowsimmoproduction[$i][3]));
                                
                                if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoproduction[$i][4])))
                                    $prodExer->setQtyProdVenduDansUemoa(preg_replace('/[^0-9-]/',"",$rowsimmoproduction[$i][4]));
                                
                                if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoproduction[$i][5])))    
                                    $prodExer->setValProdVenduDansUemoa(preg_replace('/[^0-9-]/',"",$rowsimmoproduction[$i][5]));
                                
                                if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoproduction[$i][6])))    
                                    $prodExer->setQtyProdVenduHorsUemoa(preg_replace('/[^0-9-]/',"",$rowsimmoproduction[$i][6]));
                                
                                if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoproduction[$i][7])))    
                                    $prodExer->setValProdVenduHorsUemoa(preg_replace('/[^0-9-]/',"",$rowsimmoproduction[$i][7]));
                                
                                if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoproduction[$i][8])))    
                                    $prodExer->setQtyProdImmobilisee(preg_replace('/[^0-9-]/',"",$rowsimmoproduction[$i][8]));
                                    
                                if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoproduction[$i][9])))    
                                    $prodExer->setValProdImmobilisee(preg_replace('/[^0-9-]/',"",$rowsimmoproduction[$i][9]));
                                
                                if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoproduction[$i][10])))    
                                    $prodExer->setQtyStkOuverture(preg_replace('/[^0-9-]/',"",$rowsimmoproduction[$i][10]));
                                
                                if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoproduction[$i][11])))    
                                    $prodExer->setValStkOuverture(preg_replace('/[^0-9-]/',"",$rowsimmoproduction[$i][11]));
                                
                                if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoproduction[$i][11])))    
                                    $prodExer->setQtyStkCloture(preg_replace('/[^0-9-]/',"",$rowsimmoproduction[$i][11]));
                                
                                if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsimmoproduction[$i][12])))    
                                    $prodExer->setValStkCloture(preg_replace('/[^0-9-]/',"",$rowsimmoproduction[$i][12]));
                                
                                
                            
                                $prodExer->setCreatedBy($user);
                                $prodExer->setUpdatedBy($user);              
                                //TODO setter les autres champs
                                
                                $this->entityManager->persist($prodExer);
                                $this->entityManager->flush();
                            }
                            }
                            }
                            }else{
                                $error=1;
                                $erroreproduction="Erreur de format : Vérifier  le format du fichier production de l'exercice [".$ninea."]\n" ;
                                $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                                $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                                $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                                $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "Production de l'exercice", DataType::TYPE_STRING2);
                                $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Erreur", DataType::TYPE_STRING2);
                                $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "Vérifier  le format du fichier production de l'exercice", DataType::TYPE_STRING2);
                                $countExcel++;
                            }
                            }
                        
                            }else{
                                $error=1;
                                $erroreproduction="Erreur : Vérifier si le fichier contient une feuille nommée <<Note 32>>"."\n" ;
                                $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                                $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                                $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                                $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "Production de l'exercice", DataType::TYPE_STRING2);
                                $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Erreur", DataType::TYPE_STRING2);
                                $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "Vérifier si le fichier contient une feuille nommée <<Note 32>>", DataType::TYPE_STRING2);
                                $countExcel++;
                            }
                        $achat=$spreadsheet->getSheetByName("Note 33");
                        if($achat) {

                                    $ach=  $this->entityManager->getRepository(AchatProduction::class)->findBy(["repertoire"=>$repertoire,"anneeFinanciere"=>$annee]); 
                                    if(count($ach)>1){
                                        $erroreachat="Info : l'etat financier pour achats destinés à la production est déjà chargé pour l'année ".$annee."\n" ;
                                        $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                                        $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                                        $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                                        $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "Achats destinés à la production", DataType::TYPE_STRING2);
                                        $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Info", DataType::TYPE_STRING2);
                                        $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "L'etat financier pour achats destinés à la production est déjà chargé pour l'année", DataType::TYPE_STRING2);
                                        $countExcel++;
                                
                                        }
                                    else{
                                    $rowsachat=$achat->toArray();
                                    if(count($rowsachat)>=27){
                                        $achatProductionUtil = new AchatProductionUtil();
                                        $this->entityManager->persist($achatProductionUtil);
                                        
                                        
                                    
                                    for ($i=10; $i <27 ; $i++) {
                                    if(count($rowsachat[$i])>=8){
                                    if(str_replace(" ","",$rowsachat[$i][0])!=""){
                                        $achatProd = new AchatProduction();
                                        $achatProd->setAchatProductionUtil($achatProductionUtil);
                                        $achatProd->setRepertoire($repertoire);
                                        $achatProd->setAnneeFinanciere($annee)
                                                ->setSubmit(false);
                                        $achatProd->setDemat(true);
                                        $achatProd->setLibelle($rowsachat[$i][0]);
                                        if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsachat[$i][1])))
                                            $achatProd->setUnites($rowsachat[$i][1]);
                                        
                                        if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsachat[$i][2])))
                                            $achatProd->setQtyAcheteeDansEtat($rowsachat[$i][2]);

                                        
                                        if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsachat[$i][3])))
                                            $achatProd->setValAcheteeDansPays($rowsachat[$i][3]);
                                        
                                        if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsachat[$i][4])))
                                            $achatProd->setQtyProduitDansEtat($rowsachat[$i][4]);
                                        
                                        if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsachat[$i][5])))
                                            $achatProd->setValProduitDansEtat($rowsachat[$i][5]);
                                        
                                        if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsachat[$i][6])))
                                            $achatProd->setQtyAcheteeHorsPays($rowsachat[$i][6]);
                                        
                                        if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsachat[$i][7])))
                                            $achatProd->setValAcheteeHorsPays($rowsachat[$i][7]);
                                        
                                        if(is_numeric(preg_replace('/[^0-9-]/',"",$rowsachat[$i][7])))
                                            $achatProd->setVariationDesStocks($rowsachat[$i][7]);
                                            $achatProd->setCreatedBy($user);
                                            $achatProd->setUpdatedBy($user);

                                        $this->entityManager->persist($achatProd);
                                        $this->entityManager->flush();
                                    }
                                    }
                                    }
                                
                                    
                                }else{
                                    $error=1;
                                    $erroreachat="Erreur de format : Vérifier le format du fichier Achats destinés à la production [".$ninea."]\n" ;
                                    $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                                    $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                                    $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                                    $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "Achats destinés à la production", DataType::TYPE_STRING2);
                                    $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Erreur", DataType::TYPE_STRING2);
                                    $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "Vérifier le format du fichier Achats destinés à la production", DataType::TYPE_STRING2);
                                    $countExcel++;
                                }
                                }
                        } else{
                            $error=1;
                            $erroreachat="Erreur : Vérifier si le fichier contient une feuille nommée <<Note 33>>"."\n" ;
                            $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                            $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                            $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                            $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "Achats destinés à la production", DataType::TYPE_STRING2);
                            $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Erreur", DataType::TYPE_STRING2);
                            $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "Vérifier si le fichier contient une feuille nommée <<Note 33>>", DataType::TYPE_STRING2);
                            $countExcel++;
                        }

                        if($errorBilan==""){
                            $errorBilan="Bilan : ok \n";
                            $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                            $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                            $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                            $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "Bilan", DataType::TYPE_STRING2);
                            $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Succès", DataType::TYPE_STRING2);
                            $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "Le chargement a été effectué avec succès", DataType::TYPE_STRING2);
                            $countExcel++;
                        }
                        
                        
                        if($errorcompteDeResultat==""){
                            $errorcompteDeResultat="Compte de résultat : ok \n";
                            $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                            $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                            $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                            $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "Compte de résultat", DataType::TYPE_STRING2);
                            $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Succès", DataType::TYPE_STRING2);
                            $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "Le chargement a été effectué avec succès", DataType::TYPE_STRING2);
                            $countExcel++;
                        }
                        
                        
                        
                        if($errorflux==""){
                                $myfile="Etat de flux de trésorerie : ok \n";
                                $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                                $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                                $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                                $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "Etat de flux de trésorerie", DataType::TYPE_STRING2);
                                $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Succès", DataType::TYPE_STRING2);
                                $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "Le chargement a été effectué avec succès", DataType::TYPE_STRING2);
                                $countExcel++;
                            }
                        
                        
                        
                        if($errorimmobrut==""){
                            $errorimmobrut="Immo brut : ok \n";
                            $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                            $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                            $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                            $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "Immo brut", DataType::TYPE_STRING2);
                            $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Succès", DataType::TYPE_STRING2);
                            $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "Le chargement a été effectué avec succès", DataType::TYPE_STRING2);
                            $countExcel++;
                        }
                        
                        if($errorimmoplus==""){
                            $errorimmoplus="Immo plus ou moins : ok \n";
                            $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                            $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                            $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                            $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "Immo plus ou moins", DataType::TYPE_STRING2);
                            $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Succès", DataType::TYPE_STRING2);
                            $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "Le chargement a été effectué avec succès", DataType::TYPE_STRING2);
                            $countExcel++;
                        }
                        
                        
                        if($erroreffectif==""){
                            $erroreffectif="Effectif : ok \n";
                            $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                            $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                            $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                            $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "Effectifs, masse salariale et personnel exterieur", DataType::TYPE_STRING2);
                            $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Succès", DataType::TYPE_STRING2);
                            $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "Le chargement a été effectué avec succès", DataType::TYPE_STRING2);
                            $countExcel++;
                        }
            
                        if($erroreproduction==""){
                            $erroreproduction= "Production de l'exercice : ok \n";
                            $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                            $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                            $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                            $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "Production de l'exercice", DataType::TYPE_STRING2);
                            $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Succès", DataType::TYPE_STRING2);
                            $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "Le chargement a été effectué avec succès", DataType::TYPE_STRING2);
                            $countExcel++;
                        }
                        
                        if($erroreachat==""){
                            $erroreachat="Achats destinés à la production : ok \n";
                            $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                            $activeExcel->getCell('B'.$countExcel)->setValueExplicit( $repertoire->getCodeCuci(), DataType::TYPE_STRING2);
                            $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                            $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "Achats destinés à la production", DataType::TYPE_STRING2);
                            $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Succès", DataType::TYPE_STRING2);
                            $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "Le chargement a été effectué avec succès", DataType::TYPE_STRING2);
                            $countExcel++;
                        }
                        array_push($taberreur,["[".$repertoire->getCodeCuci()."]"."[".$ninea."]"."[".$annee."] \n"]);
                        array_push($taberreur,[$errorBilan,$errorcompteDeResultat,$errorimmobrut,$errorimmoplus,$erroreachat,$erroreffectif,$erroreproduction,$errorflux]);


                    }else{
                                    
                        array_push($taberreur,["[".$ninea."] ".'message',"Erreur: aucun CUCI pour ce NINEA: ".$ninea.". \n"]);
                        $activeExcel->getCell('A'.$countExcel)->setValueExplicit( $ninea, DataType::TYPE_STRING2 );
                        $activeExcel->getCell('B'.$countExcel)->setValueExplicit( "NEAN", DataType::TYPE_STRING2);
                        $activeExcel->getCell('C'.$countExcel)->setValueExplicit( $annee, DataType::TYPE_STRING2);
                        $activeExcel->getCell('D'.$countExcel)->setValueExplicit( "", DataType::TYPE_STRING2);
                        $activeExcel->getCell('E'.$countExcel)->setValueExplicit( "Erreur", DataType::TYPE_STRING2);
                        $activeExcel->getCell('F'.$countExcel)->setValueExplicit( "Aucun CUCI pour ce NINEA", DataType::TYPE_STRING2);
                        $countExcel++;

                    }
                
                    if( $error==1){
                        if(!file_exists($logetatfinanciers.DIRECTORY_SEPARATOR.$dossiertemp.DIRECTORY_SEPARATOR."nontraite"))
                        mkdir( $logetatfinanciers.DIRECTORY_SEPARATOR.$dossiertemp.DIRECTORY_SEPARATOR."nontraite", 0777, true);
                        //dd($logetatfinanciers.DIRECTORY_SEPARATOR.$dossiertemp.DIRECTORY_SEPARATOR."nontraite");
                        $moved = rename($etatfinanciers.DIRECTORY_SEPARATOR.$fichier,  $logetatfinanciers.DIRECTORY_SEPARATOR.$dossiertemp.DIRECTORY_SEPARATOR."nontraite".DIRECTORY_SEPARATOR.$fichier);
                    
                    }else{
                    // dd($logetatfinanciers.DIRECTORY_SEPARATOR.$dossiertemp.DIRECTORY_SEPARATOR."traite");
                    if(!file_exists($logetatfinanciers.DIRECTORY_SEPARATOR.$dossiertemp.DIRECTORY_SEPARATOR."traite"))
                        mkdir( $logetatfinanciers.DIRECTORY_SEPARATOR.$dossiertemp.DIRECTORY_SEPARATOR."traite", 0777, true);
                        $moved = rename($etatfinanciers.DIRECTORY_SEPARATOR.$fichier,  $logetatfinanciers.DIRECTORY_SEPARATOR.$dossiertemp.DIRECTORY_SEPARATOR."traite".DIRECTORY_SEPARATOR.$fichier);
                    
                    }
               } catch (Exception $e) {
    
              }
        }
    }
       // closedir($dossier);
        $filelog=$this->container->getParameter("path_absolu").DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."log".DIRECTORY_SEPARATOR;
        $filetxt="mig_log__".uniqid().".txt";
        $myfile = fopen( $filelog.$filetxt, "w") or die("Unable to open file!");
        foreach ($taberreur as $key ) {
           foreach ($key as $tag) {
              fwrite($myfile, $tag);
           }
        }


        $writer = new Xlsx($spreadsheet_log);
       // $writer->setPreCalculateFormulas(false);
        //$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $fileName = "mig_log".uniqid().".xlsx";
        
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        
        
        // Create the excel file in the tmp directory of the system
        $writer->save($temp_file);

      

        $moved = rename($temp_file, $filelog.$fileName);

        fclose($myfile);
        $filePathName= $fichier;                     
        $cuciMigLog=new CuciMigLog();
        $cuciMigLog->setLogFileName($fileName);
        $cuciMigLog->setLogFile($fileName);
       
        $this->entityManager->persist($cuciMigLog);
        $this->entityManager->flush();
      
       

    
    return Command::SUCCESS;
 }
}