<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Repertoire;
use App\Entity\Bilan;
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



/**
 * @IsGranted("ROLE_USER")
 */
class ImportEtatFinancierController extends AbstractController
{
     /**
     * @Route("/telecharger/etat/financier/{id}", name="telecharger_etat_financier")
     */
    public function telecharger( CuciMigLog $cuciMigLog): Response
    {

        $fileFolder=$this->getParameter("path_absolu").DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."log".DIRECTORY_SEPARATOR;
        return $this->file($fileFolder.$cuciMigLog->getLogFile());
      
    }

    function validateDate($date)
    {
        $dateTime=new \DateTime();
        $d = $dateTime->createFromFormat("m/d/Y",$date);
        return $d && $d->format("m/d/Y") == $date;
    }

     /**
     * @Route("/donnee/import", name="donnee_import")
     */
    public function donnee(Request $request, EntityManagerInterface $entityManager): Response
    {

    }
    /**
     * @Route("/import/etat/financier", name="import_etat_financier")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        ini_set("memory_limit", -1);
        ini_set ( 'max_execution_time', -1);  
        ini_set ( 'upload_max_filesize', -1);  


         

        if($request->files->get('_file')){
            $file = $request->files->get('_file');
            // $filePathName = md5(uniqid()) . $file->getClientOriginalName();
            $filePathName = uniqid()."_".$file->getClientOriginalName() ;
            $fileFolder=$this->getParameter("path_absolu").DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."migration".DIRECTORY_SEPARATOR;
            
        if($file->getClientOriginalExtension()=="xlsx" || $file->getClientOriginalExtension()=="zip"){
          
            try {
                $file->move($fileFolder, $filePathName);
            } catch (FileExists $e) {
                dd($e);
            }

            if($file->getClientOriginalExtension()=="zip"){

                $zip = new \ZipArchive();
                $nom_dossier = uniqid().DIRECTORY_SEPARATOR;
                $res = $zip->open($fileFolder. $filePathName);
                if ($res === TRUE) {
                    // extract it to the path we determined above
                    $zip->extractTo($fileFolder.$nom_dossier);
                    $zip->close();
                    $dossier = opendir($fileFolder.$nom_dossier);
                    $nombreFichier=0;
                    $taberreur=[];
                    while($dos = readdir($dossier)){
                        if($dos != '.' && $dos != '..'){
                        $dossier1=opendir($fileFolder.$nom_dossier.$dos);
                        while($fichier = readdir($dossier1)){
                        if($fichier != '.' && $fichier != '..'){
                        ///// Importation dossier etat financier
                        $nombreFichier++;
                        $spreadsheet = IOFactory::load($fileFolder.$nom_dossier.$dos.DIRECTORY_SEPARATOR.$fichier);
                        $ws=$spreadsheet->getSheet(1);
                        $rows = $ws->toArray();
                        $ninea=str_replace(" ","",$rows[8][9]);
                        $annee=str_replace(" ","",$rows[8][21]);
                        $verifiedAnnee=0;
                        $errorBilan="";
                        $errorcompteDeResultat="";
                        $errorflux="";
                        $errorimmobrut="";
                        $errorimmoplus="";
                        $erroreffectif="";
                        $erroreproduction="";
                        $erroreachat="";
                        
                      
                        if(!$this->validateDate($annee)){
                            $verifiedAnnee=1; 
                        }else{
                            $dateTime=new \DateTime();
                            $annee = $dateTime->createFromFormat("m/d/Y",$annee);
                        }

                        if($ninea!="" && $annee!="" &&  $verifiedAnnee==0){

                            $annee=$annee->format("Y");
                            $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["ninea"=>$ninea]);
                        if($repertoire){
                                $bilan=$spreadsheet->getSheetByName("BILAN PAYSAGE");
                            
                            
                                
                            if($bilan){
                                $rowsBilan=$bilan->toArray();
                                $bn=$this->getDoctrine()->getRepository(Bilan::class)->findByCodeCuci($repertoire->getCodeCuci(),$annee,"Actif");
                                if(count($bn)>1)
                                $errorBilan="Info : l'etat financier pour le  bilan  est déjà chargé pour l'année ".$annee."\n" ;
                                else{
                                     if(count($rowsBilan)>=31){
                                        for ($i=2; $i <=30 ; $i++) { 
                                            if(count($rowsBilan[$i])>=11){
                                            $bilan = new Bilan();
                                            $bilanPassif = new Bilan();
                                            $bilan->setAnneeFinanciere($annee);
                                            $bilan->setRepertoire($repertoire);
                                            
                                            
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
                                            $entityManager->persist($bilan);
                                            $entityManager->flush();
                                            

                                            ///  Bilan passif
                                            $bn=$this->getDoctrine()->getRepository(Bilan::class)->findByCodeCuci($repertoire->getCodeCuci(),$annee,"Passif");
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
                                            $bilanPassif->$bilan->setUploadedFileName(1);;
                                            $bilanPassif->setSubmit(false);
                                            $entityManager->persist($bilanPassif);
                                            $entityManager->flush();
                                        }
                                      }
                                    }else{
                                        $errorBilan="Erreur de format : Vérifier le format du fichier pour bilan [".$ninea."]   \n" ;  
                                    }
                                }
                            }else{
                                $errorBilan="Erreur : Vérifier si le fichier contient une feuille nommée <<BILAN PAYSAGE>>"."\n" ;
                            }

                            $compteResultat=$spreadsheet->getSheetByName("COMPTE DE RESULTAT");
                                
                            if($compteResultat){
                                $cr = $this->getDoctrine()->getRepository(CompteDeResultats::class)->findByCodeCuci($repertoire->getCodeCuci(),$annee); 
                                if(count($cr)>1)
                                $errorcompteDeResultat="Info : l'etat financier pour le compte de resultat est déjà chargé pour l'année ".$annee."\n" ;
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
                                                ->setModifiedBy($this->getUser())
                                                ->setCreatedBy($this->getUser())
                                                ->setSubmit(false) ;
                                            $entityManager->persist($compteDeResultats);
                                            $entityManager->flush();
                                        }
                                    }
                                }else{
                                    $errorcompteDeResultat="Erreur de format: Vérifier le format du fichier pour le Compte de resultat  [".$ninea."] \n" ; 
                                }
                            }

                            }else{
                                $errorcompteDeResultat="Erreur : Vérifier si le fichier contient une feuille nommée <<COMPTE DE RESULTAT>>"."\n" ;
                            }

                                $flux=$spreadsheet->getSheetByName("FLUX DE TRESORERIE");
                            
                            if($flux){
                                $ef = $this->getDoctrine()->getRepository(FluxDesTresoreries::class)->findByCodeCuciAnneeAndCategory($repertoire->getCodeCuci(),$annee); 
                                if(count($ef)>1)
                                $errorflux="Info : l'etat financier pour l'etats des flux des trésorerie est déjà chargé pour l'année ".$annee."\n" ;
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
                                            ->setSubmit(false) ;
                                            if(strtoupper(str_replace(" ","",$rowscompteflux[$i][0]))=="XI")
                                               $flux->setRefCode("ZH");
                                            else
                                               $flux->setRefCode(strtoupper(str_replace(" ","",$rowscompteflux[$i][0])));

                                           
                                            $entityManager->persist($flux);
                                            $entityManager->flush();
                                        }
                                        }

                                    }
                                }else{
                                    $errorflux="Erreur de format :Vérifier le format du fichier pour FLUX DE TRESORERIE [".$ninea."] "."\n" ;
                                }
                            }
                            }else{
                                $errorflux="Erreur : Vérifier si le fichier contient une feuille nommée <<FLUX DE TRESORERIE>>"."\n" ;
                            }
                                $immoBrut=$spreadsheet->getSheetByName("Note 3A");
                            if($immoBrut) {
                                $ib = $this->getDoctrine()->getRepository(ImmoBrut::class)->findByCodeCuci($repertoire->getCodeCuci(),$annee); 
                                if(count($ib)>1)
                                $errorimmobrut="Info : l'etat financier pour immo brut  est déjà chargé pour l'année ".$annee."\n" ;
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

                                $immobrut->setCreatedby($this->getUser());
                                $immobrut->setModifiedby($this->getUser());
                                $entityManager->persist($immobrut);
                                $entityManager->flush();
                                
                                }
                                
                                }
                               }else{
                                $errorimmobrut="Erreur de format : Vérifier le format du fichier pour  Immobilisations brutes [".$ninea."] "."\n" ;  
                               } 
                                }
                                }else{
                                $errorimmobrut="Erreur : Vérifier si le fichier contient une feuille nommée <<Note 3A>>"."\n" ;
                            }

                            $immoPlusMoins=$spreadsheet->getSheetByName("Note 3D");
                            if($immoPlusMoins) {
                                $ip = $this->getDoctrine()->getRepository(CuciImmoPlus::class)->findByCodeCuci($repertoire->getCodeCuci(),$annee); 
                                if(count($ip)>1)
                                $errorimmoplus="Info : l'etat financier pour immobilisations: Plus-value et moins-value de cession est déjà chargé pour l'année ".$annee."\n" ;
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

                                $immo->setCreatedBy($this->getUser());
                                $immo->setModifiedby($this->getUser());
                                $entityManager->persist($immo);
                                $entityManager->flush();
                                }
                                }
                                }
                            }else{
                                $errorimmoplus="Error de format : Vérifier le format du fichier pour  immobilisations: Plus-value et moins-value [".$ninea."]\n" ;
                            }
                            }

                                }else{
                                $errorimmoplus="Erreur : Vérifier si le fichier contient une feuille nommée <<Note 3D>>"."\n" ;
                                }
                                


                            $effectifs=$spreadsheet->getSheetByName("Note 27B");
                            if($effectifs) {
                                $ef = $this->getDoctrine()->getRepository(Effectifs::class)->findBy(["repertoire"=>$repertoire,"anneeFinanciere"=>$annee]); 
                                if(count($ef)>1)
                                $erroreffectif="Info : l'etat financier pour effectif est déjà chargé pour l'année ".$annee."\n" ;
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
                                
                                    $effectif->setUpdatedBy($this->getUser());
                                    $effectif->setCreatedBy($this->getUser());  

                                    $entityManager->persist($effectif);
                                    $entityManager->flush();
                                 }
                                }
                                }
                                }else{
                                $erroreffectif="Erreur de format : Vérifier  le format pour effectif [".$ninea."] \n" ;
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
                                    $new_effectif->setCreatedBy($this->getUser());
                                    $new_effectif->setUpdatedBy($this->getUser());
                                    $entityManager->persist($new_effectif);
                                    $entityManager->flush();
                                 }
                                }
                               }
                            }else{
                                $erroreffectif="Erreur de format : Vérifier  le format  du fichier  pour Effectifs, masse salariale et personnel exterieur  [".$ninea."].\n" ;

                            }
                            }
                            }else{
                                $erroreffectif="Erreur : Vérifier si le fichier contient une feuille nommée <<Note 27B>>"."\n" ;
                                }

                            $production=$spreadsheet->getSheetByName("Note 32");
                            if($production) {
                                $prod = $this->getDoctrine()->getRepository(ProductionDeExercice::class)->findBy(["repertoire"=>$repertoire,"anneeFinanciere"=>$annee]); 
                                if(count($prod)>1)
                                $erroreproduction="Info : l'etat financier pour production de l'exercice est déjà chargé pour l'année ".$annee."\n" ;
                                else{
                                $rowsimmoproduction=$production->toArray();
                                if(count($rowsimmoproduction)>=17){
                                    $prod_de_exer_util = new ProductionDeExerciceUtil();
                                    $entityManager->persist($prod_de_exer_util);

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
                                    
                                    
                                
                                    $prodExer->setCreatedBy($this->getUser());
                                    $prodExer->setUpdatedBy($this->getUser());
                                                    
                                    //TODO setter les autres champs
                                    
                                    $entityManager->persist($prodExer);
                                    $entityManager->flush();
                                }
                                }
                                }
                                }else{
                                $erroreproduction="Erreur de format : Vérifier  le format du fichier production de l'exercice [".$ninea."]\n" ;
                                }
                                }
                                }else{
                                $erroreproduction="Erreur : Vérifier si le fichier contient une feuille nommée <<Note 32>>"."\n" ;
                                }

                                $achat=$spreadsheet->getSheetByName("Note 33");

                            if($achat) {

                                $ach= $this->getDoctrine()->getRepository(AchatProduction::class)->findBy(["repertoire"=>$repertoire,"anneeFinanciere"=>$annee]); 
                                if(count($ach)>1)
                                $erroreachat="Info : l'etat financier pour achats destinés à la production est déjà chargé pour l'année ".$annee."\n" ;
                                else{
                                $rowsachat=$achat->toArray();
                                if(count($rowsachat)>=27){
                                    $achatProductionUtil = new AchatProductionUtil();
                                    $entityManager->persist($achatProductionUtil);
                                    
                                    
                                   
                                for ($i=10; $i <27 ; $i++) {
                                if(count($rowsachat[$i])>=8){
                                if(str_replace(" ","",$rowsachat[$i][0])!=""){
                                    $achatProd = new AchatProduction();
                                    $achatProd->setAchatProductionUtil($achatProductionUtil);
                                    $achatProd->setRepertoire($repertoire);
                                    $achatProd->setAnneeFinanciere($annee)
                                            ->setSubmit(false);
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

                                    $entityManager->persist($achatProd);
                                    $entityManager->flush();
                                }
                                }
                                }
                               
                                
                            }else{
                                $erroreachat="Erreur de format : Vérifier le format du fichier Achats destinés à la production [".$ninea."]\n" ;
                            }
                            }
                            }
                            else
                                {
                                $erroreachat="Erreur : Vérifier si le fichier contient une feuille nommée <<Note 33>>"."\n" ;
                                }
                                
                              
                    
                                if($errorBilan=="")
                                  $errorBilan="Bilan : ok \n";
                                
                                
                                if($errorcompteDeResultat=="")
                                    $errorcompteDeResultat="Compte de résultat : ok \n";
                               
                                
                                
                                if($errorflux=="")
                                      $myfile="Etat de flux de trésorerie : ok \n";
                               
                               
                                
                                if($errorimmobrut=="")
                                   $errorimmobrut="Immo brut : ok \n";
                                
                                if($errorimmoplus=="")
                                  $errorimmoplus="Immo plus ou moins : ok \n";
                               
                              
                                if($erroreffectif=="")
                                    $erroreffectif="Effectif : ok \n";
                    
                                if($erroreproduction=="")
                                  $erroreproduction= "Production de l'exercice : ok \n";
                                
                                if($erroreachat=="")
                                   $erroreachat="Achats destinés à la production : ok \n";
                                array_push($taberreur,["[".$repertoire->getCodeCuci()."]"."[".$ninea."]"."[".$annee."] \n"]);
                                array_push($taberreur,[$errorBilan,$errorcompteDeResultat,$erroreachat,$erroreffectif,$erroreproduction,$errorflux,$erroreproduction]);
                               
                               
                                    
                                


                            }else{
                                
                                array_push($taberreur,["[".$ninea."] ".'message',"Erreur: aucun CUCI pour ce NINEA: ".$ninea.". \n"]);

                            }
                        
                        }else
                        {
                            if($ninea==""){
                                array_push($taberreur,["Erreur:veuillez vérifier si le ninea est bien renseigné sur la feuille <<Fiche de renseignement R1 >> à la ligne 8 colonne 9. "]);
                            }else
                               
                                array_push($taberreur,["Erreur: veuillez vérifier si la date de clos est bien renseignée et est dans le format m/d/Y sur la feuille <<Fiche de renseignement R1>> à la ligne 8 colonne 21. "]);
                        }
                                    
                                   
           ////// Fin    Importation dossier etat financier                     
                                }
                            }
                            closedir($dossier1);

                        }
                    }
                    closedir($dossier);
                  

                } else {
                   
                }

                $filelog=$this->getParameter("path_absolu").DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."log".DIRECTORY_SEPARATOR;
                $filetxt="mig_log_".$ninea."_".uniqid().".txt";
                $myfile = fopen( $filelog.$filetxt, "w") or die("Unable to open file!");

               
                
                foreach ($taberreur as $key ) {
                   foreach ($key as $tag) {
                      fwrite($myfile, $tag);
                   }
                }


                fclose($myfile);
                                
                $cuciMigLog=new CuciMigLog();
                $cuciMigLog->setLogFileName($filePathName);
                $cuciMigLog->setLogFile($filetxt);
                $cuciMigLog->setModifiedBy($this->getUser());
                $cuciMigLog->setCreatedBy($this->getUser());  
                $entityManager->persist($cuciMigLog);
                $entityManager->flush();
                $request->getSession()->getFlashBag()->add('messageSuccess', $nombreFichier." etats financiers ont été importés avec succès.");
                $cuciMigLog=$entityManager->getRepository(CuciMigLog::class)->findBy(array(),array('createdDate'=>'desc'));
                return $this->render('import_etat_financier/index.html.twig', [
                   "cuciMigLog"=>$cuciMigLog
                ]);
            }

            $spreadsheet = IOFactory::load($fileFolder . $filePathName);
           
            $ws=$spreadsheet->getSheet(1);
            $rows = $ws->toArray();
            $ninea=str_replace(" ","",$rows[8][9]);
            $annee=str_replace(" ","",$rows[8][21]);
            $verifiedAnnee=0;
            $errorBilan="";
            $errorcompteDeResultat="";
            $errorflux="";
            $errorimmobrut="";
            $errorimmoplus="";
            $erroreffectif="";
            $erroreproduction="";
            $erroreachat="";

          

          
               
            try{
                $dateTime=new \DateTime();
                $annee = $dateTime->createFromFormat("m/d/Y",$annee);
             }catch(Exception $e){
                $verifiedAnnee=1;
             }

            

            if($ninea!="" && $annee!="" &&  $verifiedAnnee==0){

                $annee=$annee->format("Y");
                $repertoire=$this->getDoctrine()->getRepository(Repertoire::class)->findOneBy(["ninea"=>$ninea]);
               if($repertoire){
                    $bilan=$spreadsheet->getSheetByName("BILAN PAYSAGE");
                    
                  if($bilan){
                    $rowsBilan=$bilan->toArray();

                  
                    
                    $bn=$this->getDoctrine()->getRepository(Bilan::class)->findByCodeCuci($repertoire->getCodeCuci(),$annee,"Actif");
                    if(count($bn)>1)
                      $errorBilan="Info : l'etat financier pour le  bilan  est déjà chargé pour l'année ".$annee ;
                    else{
                    if(count($rowsBilan)>=31){
                    for ($i=2; $i <=30 ; $i++) { 
                      if(count($rowsBilan[$i])>=11){
                        $bilan = new Bilan();
                        $bilanPassif = new Bilan();
                        $bilan->setAnneeFinanciere($annee);
                        $bilan->setRepertoire($repertoire);
                        
                        
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
                        $bilan->setCreatedBy($this->getUser());
                        $bilan->setModifiedBy($this->getUser());
                        $entityManager->persist($bilan);
                        $entityManager->flush();
                        

                        ///  Bilan passif
                        $bn=$this->getDoctrine()->getRepository(Bilan::class)->findByCodeCuci($repertoire->getCodeCuci(),$annee,"Passif");
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
                        $bilanPassif->setCreatedBy($this->getUser());
                        $bilanPassif->setModifiedBy($this->getUser());
                        $bilanPassif->setSubmit(false);
                        $entityManager->persist($bilanPassif);
                        $entityManager->flush();
                        }
                      }
                    }else{
                        $errorBilan="Erreur de format : Vérifier le format du fichier pour bilan [".$ninea."]   \n" ;  
                    }
                }
                }else{
                    $errorBilan="Erreur : Vérifier si le fichier contient une feuille nommée <<BILAN PAYSAGE>>" ;
                }

                 $compteResultat=$spreadsheet->getSheetByName("COMPTE DE RESULTAT");
                    
                 if($compteResultat){
                    $cr = $this->getDoctrine()->getRepository(CompteDeResultats::class)->findByCodeCuci($repertoire->getCodeCuci(),$annee); 
                    if(count($cr)>1)
                       $errorcompteDeResultat="Info : l'etat financier pour le compte de resultat est déjà chargé pour l'année ".$annee ;
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
                            
                              ->setSubmit(false) ;
                        $entityManager->persist($compteDeResultats);
                        $entityManager->flush();
                    }
                   }
                }else{
                    $errorcompteDeResultat="Erreur de format: Vérifier le format du fichier pour le Compte de resultat  [".$ninea."] \n" ; 
                }
            }

                  }else{
                    $errorcompteDeResultat="Erreur : Vérifier si le fichier contient une feuille nommée <<COMPTE DE RESULTAT>>" ;
                  }

                    $flux=$spreadsheet->getSheetByName("FLUX DE TRESORERIE");
                   
                   if($flux){
                    $ef = $this->getDoctrine()->getRepository(FluxDesTresoreries::class)->findByCodeCuciAnneeAndCategory($repertoire->getCodeCuci(),$annee); 
                    if(count($ef)>1)
                       $errorflux="Info : l'etat financier pour l'etats des flux des trésorerie est déjà chargé pour l'année ".$annee ;
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
                            ->setSubmit(false) ;
                            if(strtoupper(str_replace(" ","",$rowscompteflux[$i][0]))=="XI")
                            $flux->setRefCode("ZH");
                            else
                            $flux->setRefCode(strtoupper(str_replace(" ","",$rowscompteflux[$i][0])));
                            $entityManager->persist($flux);
                            $entityManager->flush();
                        }

                    }
                  }
                }else{
                    $errorflux="Erreur de format : Vérifier le format du fichier pour FLUX DE TRESORERIE [".$ninea."] "."\n" ;
                }
            }
                  }else{
                    $errorflux="Erreur : Vérifier si le fichier contient une feuille nommée <<FLUX DE TRESORERIE>>" ;
                  }
                  
                    

                    $immoBrut=$spreadsheet->getSheetByName("Note 3A");
                   if($immoBrut) {
                    $ib = $this->getDoctrine()->getRepository(ImmoBrut::class)->findByCodeCuci($repertoire->getCodeCuci(),$annee); 
                    if(count($ib)>1)
                       $errorimmobrut="Info : l'etat financier pour immo brut  est déjà chargé pour l'année ".$annee ;
                    else{
                    $rowscompteimmoBrut=$immoBrut->toArray();
                    $code=[9=>"GA",10=>"GB",11=>"GC",12=>"GD",13=>"GE",14=>"GF",15=>"GGA",16=>"GGB",17=>"GHA",18=>'GHB',19=>"GI",20=>"GJ",21=>"GK",22=>"GL",23=>"GM",24=>"GN",25=>"GO",26=>"GP",27=>"GQ"];
                    if(count($rowscompteimmoBrut)>=29){
                    for ($i=9; $i <28 ; $i++) {
                        if(count($rowscompteimmoBrut[$i])>=8){
                      $immobrut = new ImmoBrut();
                     if(strtoupper(str_replace(" ","",$rowscompteimmoBrut[$i][0]))!=""){
                      $immobrut->setAnneeFinanciere($annee);
                      $immobrut->setRefCode($code[$i]);
                      $immobrut->setSubmit(false);
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

                      $immobrut->setCreatedby($this->getUser());
                      $immobrut->setModifiedby($this->getUser());
                      $entityManager->persist($immobrut);
                      $entityManager->flush();
                     }
                    
                     }
                    }
                }else{
                    $errorimmobrut="Erreur de format : Vérifier le format du fichier pour  Immobilisations brutes [".$ninea."] "."\n" ;  
                   } 
                }
                     }else{
                     $errorimmobrut="Erreur : Vérifier si le fichier contient une feuille nommée <<Note 3A>>" ;
                   }

                  $immoPlusMoins=$spreadsheet->getSheetByName("Note 3D");
                  if($immoPlusMoins) {
                    $ip = $this->getDoctrine()->getRepository(CuciImmoPlus::class)->findByCodeCuci($repertoire->getCodeCuci(),$annee); 
                    if(count($ip)>1)
                       $errorimmoplus="Info : l'etat financier pour immobilisations: Plus-value et moins-value de cession est déjà chargé pour l'année ".$annee ;
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

                    $immo->setCreatedBy($this->getUser());
                    $immo->setModifiedby($this->getUser());
                    $entityManager->persist($immo);
                    $entityManager->flush();
                    }
                    }
                   }
                }else{
                    $errorimmoplus="Error de format : Vérifier le format du fichier pour  immobilisations: Plus-value et moins-value [".$ninea."]\n" ;
                }
                }

                    }else{
                    $errorimmoplus="Erreur : Vérifier si le fichier contient une feuille nommée <<Note 3D>>" ;
                    }
                    


                  $effectifs=$spreadsheet->getSheetByName("Note 27B");
                 if($effectifs) {
                    $ef = $this->getDoctrine()->getRepository(Effectifs::class)->findBy(["repertoire"=>$repertoire,"anneeFinanciere"=>$annee]); 
                    if(count($ef)>1)
                       $erroreffectif="Info : l'etat financier pour effectif est déjà chargé pour l'année ".$annee ;
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
                    
                        $effectif->setUpdatedBy($this->getUser());
                        $effectif->setCreatedBy($this->getUser());  

                        $entityManager->persist($effectif);
                        $entityManager->flush();
                     }
                    }
                }
            }else{
            $erroreffectif="Erreur de format : Vérifier  le format pour effectif [".$ninea."] \n" ;
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
                        $new_effectif->setCreatedBy($this->getUser());
                        $new_effectif->setUpdatedBy($this->getUser());
                        $entityManager->persist($new_effectif);
                        $entityManager->flush();
                    }
                    }
                  }
                  }else{
                    $erroreffectif="Erreur de format : Vérifier  le format  du fichier  pour Effectifs, masse salariale et personnel exterieur  [".$ninea."].\n" ;

                }
                }
                   }else{
                    $erroreffectif="Erreur : Vérifier si le fichier contient une feuille nommée <<Note 27B>>" ;
                    }

                    $production=$spreadsheet->getSheetByName("Note 32");
                   if($production) {
                    $prod = $this->getDoctrine()->getRepository(ProductionDeExercice::class)->findBy(["repertoire"=>$repertoire,"anneeFinanciere"=>$annee]); 
                    if(count($prod)>1)
                       $erroreproduction="Info : l'etat financier pour production de l'exercice est déjà chargé pour l'année ".$annee ;
                    else{
                    $rowsimmoproduction=$production->toArray();
                    if(count($rowsimmoproduction)>=17){
                        $prod_de_exer_util = new ProductionDeExerciceUtil();
                        $entityManager->persist($prod_de_exer_util);
                    for ($i=8; $i <17 ; $i++) {
                        if(count($rowsimmoproduction[$i])>=13){
                      if(str_replace(" ","",$rowsimmoproduction[$i][0])!=""){
                        // #pour chaque objet production util, on cree un objet produtionExer
                        $prodExer = new ProductionDeExercice();
                        $prodExer->setProductionDeExerciceUtil($prod_de_exer_util);
                        // # setter les valeur saisie 
                        $prodExer->setRepertoire($repertoire);
                        
                        $prodExer->setAnneeFinanciere($annee)
                                ->setSubmit(false);
                        
                        
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
                        
                        
                      
                        $prodExer->setCreatedBy($this->getUser());
                        $prodExer->setUpdatedBy($this->getUser());
                                        
                        //TODO setter les autres champs
                        
                        $entityManager->persist($prodExer);
                        $entityManager->flush();
                      }
                     }
                    }
                }else{
                    $erroreproduction="Erreur de format : Vérifier  le format du fichier production de l'exercice [".$ninea."]\n" ;
                    }
                    }
                    }else{
                    $erroreproduction="Erreur : Vérifier si le fichier contient une feuille nommée <<Note 32>>" ;
                    }

                    $achat=$spreadsheet->getSheetByName("Note 33");

                   if($achat) {

                    $ach= $this->getDoctrine()->getRepository(AchatProduction::class)->findBy(["repertoire"=>$repertoire,"anneeFinanciere"=>$annee]); 
                    if(count($ach)>1)
                       $erroreachat="Info : l'etat financier pour achats destinés à la production est déjà chargé pour l'année ".$annee ;
                    else{
                    $rowsachat=$achat->toArray();
                    if(count($rowsachat)>=27){
                        $achatProductionUtil = new AchatProductionUtil();
                        $entityManager->persist($achatProductionUtil);
                       
                    for ($i=10; $i <27 ; $i++) {
                        if(count($rowsachat[$i])>=8){
                    if(str_replace(" ","",$rowsachat[$i][0])!=""){
                        $achatProd = new AchatProduction();
                        $achatProd->setAchatProductionUtil($achatProductionUtil);
                        $achatProd->setRepertoire($repertoire);
                        $achatProd->setAnneeFinanciere($annee)
                                ->setSubmit(false);
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

                        $entityManager->persist($achatProd);
                        $entityManager->flush();
                    }
                    }
                  }
                }else{
                    $erroreachat="Erreur de format : Vérifier le format du fichier Achats destinés à la production [".$ninea."]\n" ;
                }
                }
                  }
                   else
                    {
                      $erroreachat="Erreur : Vérifier si le fichier contient une feuille nommée <<Note 33>>" ;
                    }
                    
                    $fileFolder=$this->getParameter("path_absolu").DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."log".DIRECTORY_SEPARATOR;
                    $filetxt="mig_log_".$ninea."_".uniqid().".txt";
                    $myfile = fopen( $fileFolder.$filetxt, "w") or die("Unable to open file!");
                   
                    fwrite($myfile,  "[".$repertoire->getCodeCuci()."]"."[".$ninea."]"."[".$annee."] \n");
                    if($errorBilan=="")
                       fwrite($myfile, "Bilan : ok ");
                    else 
                      fwrite($myfile, "Bilan : ".$errorBilan);

                      fwrite($myfile, "\n");
                      
                    if($errorcompteDeResultat=="")
                      fwrite($myfile, "Compte de résultat : ok");
                    else 
                      fwrite($myfile, "Compte de résultat : ".$errorcompteDeResultat);

                      fwrite($myfile, "\n");
                    
                    if($errorflux=="")
                      fwrite($myfile, "Etat de flux de trésorerie : ok");
                    else 
                      fwrite($myfile, "Etat de flux de trésorerie : ".$errorflux);

                      fwrite($myfile, "\n");
                    
                    if($errorimmobrut=="")
                      fwrite($myfile, "Immo brut : ok");
                    else 
                      fwrite($myfile, "Immo brut : ".$errorimmobrut);

                      fwrite($myfile, "\n");
                    
                    if($errorimmoplus=="")
                      fwrite($myfile, "Immo plus ou moins : ok");
                    else 
                      fwrite($myfile, "Immo plus ou moins : ".$errorimmoplus);

                      fwrite($myfile, "\n");
                    
                    if($erroreffectif=="")
                      fwrite($myfile, "Effectif : ok");
                    else 
                      fwrite($myfile, "Effectif : ".$erroreffectif);

                      fwrite($myfile, "\n");
        
                    if($erroreproduction=="")
                    fwrite($myfile, "Production de l'exercice : ok");
                    else 
                      fwrite($myfile, "Production de l'exercice : ".$erroreproduction);

                      fwrite($myfile, "\n");
                    
                    if($erroreachat=="")
                      fwrite($myfile, "Achats destinés à la production : ok");
                    else 
                        fwrite($myfile, "Achats destinés à la production : ".$erroreachat);
                
                    fclose($myfile);
                    
                    $cuciMigLog=new CuciMigLog();
                    $cuciMigLog->setLogFileName($filePathName);
                    $cuciMigLog->setLogFile($filetxt);
                    $cuciMigLog->setModifiedBy($this->getUser());
                    $cuciMigLog->setCreatedBy($this->getUser());  
                    $entityManager->persist($cuciMigLog);
                    $entityManager->flush();
                        
                    $request->getSession()->getFlashBag()->add('messageSuccess',"l'etat financier importé avec success.");


                }else{
                    $request->getSession()->getFlashBag()->add('message',"Erreur: aucun CUCI pour ce NINEA: ".$ninea."."); 
                }
               
            }else
            {
                if($ninea==""){
                    $request->getSession()->getFlashBag()->add('message',"Erreur:veuillez vérifier si le ninea est bien renseigné sur la feuille <<Fiche de renseignement R1 >> à la ligne 8 colonne 9. ");
                }else
                    $request->getSession()->getFlashBag()->add('message',"Erreur: veuillez vérifier si la date de clos est bien renseignée et est dans le format m/d/Y sur la feuille <<Fiche de renseignement R1>> à la ligne 8 colonne 21. ");
            }
       
    }else{

        $request->getSession()->getFlashBag()->add('message',"Erreur: l'extension du fichier doit être xlsx ou zip. ");
        $cuciMigLog=$entityManager->getRepository(CuciMigLog::class)->findBy(array(),array('createdDate'=>'desc'));
        return $this->render('import_etat_financier/index.html.twig', [
           "cuciMigLog"=>$cuciMigLog
        ]); 
    } 
}

        $cuciMigLog=$entityManager->getRepository(CuciMigLog::class)->findBy(array(),array('createdDate'=>'desc'));
        return $this->render('import_etat_financier/index.html.twig', [
           "cuciMigLog"=>$cuciMigLog
        ]);
    }
}
