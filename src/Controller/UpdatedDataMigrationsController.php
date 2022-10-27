<?php

namespace App\Controller;

use App\Entity\Bilan;
use App\Entity\CompteDeResultats;
use App\Entity\FluxDesTresoreries;
use App\Entity\Repertoire;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class UpdatedDataMigrationsController extends AbstractController
{


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
     * @Route("/updated/data/migrations", name="app_updated_data_migrations")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        ini_set("memory_limit", -1);

        ini_set('max_execution_time', -1);

        if ($request->get('submit-templ')) {

            $file = $request->files->get('_resume'); // get the file from the sent request

            $fileFolder = __DIR__ . '/../../public/uploads/';  
            
            $filePathName = uniqid() . $file->getClientOriginalName();
            // apply md5 function to generate an unique identifier for the file and concat it with the file extension  
            
            
            try {
                $file->move($fileFolder, $filePathName);
            } catch (FileException $e) {
                dd($e);
            }

            $spreadsheet = IOFactory::load($fileFolder . $filePathName); // Here we are able to read from the excel file 
            
            // récupère le nom des colonnes
            $mapColumns = UpdatedDataMigrationsController::mapExcelColumns($spreadsheet);
            
            $selTab = $request->get('table');

            $_success = 0;

            $conn = $this->getDoctrine()->getManager()->getConnection(); // initialiser une cnx 

            // on veut savoir qui et quant a est effectuee cette mise a jour
            $user = $this->getUser(); 
            $userID = $user->getId();

            $_today = new \DateTime('now');

            $_today = $_today->format("Y-m-d H:i:s") ;

            $_passif = "Passif";
            $_actif = "Actif";
            
            switch ($selTab) {
                
                case '1':
                    # ici on definit notre model bilan
                    $excelColonnes = [
                        'cuci', 'annee', 'ref_code', 'brut', 'amort_pr', 'net1', 'net2'
                    ];
                    
                    // on verifie physiquement l allignement des colonnes
                    $col = UpdatedDataMigrationsController::excelNotFoundColumnException($excelColonnes, $mapColumns);
                    
                    // affiche à l'utilisateur un mssage d'erreur si le template ne suit pas ce format
                    if (!empty($col)) {
                        $this->addFlash(
                            'success',
                            "La colonne <strong> {$col} </strong> n'est pas définie dans le fichier Excel. Merci de vous référer sur le template de base !"
                        );
                        return $this->redirectToRoute('app_updated_data_migrations'); // pour le moment on retourne la page new
                    }

                    
                    // Récupère les index ou la position de chaque colonne
                    $codeCuci_index = array_search("cuci", $mapColumns, true);
                    $annee_index = array_search("annee", $mapColumns, true);
                    $refCode_index = array_search("ref_code", $mapColumns, true);
                    $brut_index = array_search("brut", $mapColumns, true);
                    $amortPR_index = array_search("amort_pr", $mapColumns, true);
                    $net1_index = array_search("net1", $mapColumns, true);
                    $net2_index = array_search("net2", $mapColumns, true);
                    
                    
                    
                    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true); // here, the read data is turned into an array 
                    
                    $ind=1;

                    foreach ($sheetData as $Row) {
                        
                        if ($ind>1) {
                                # code...
                            $code_cuci = $Row[$codeCuci_index]; 
                            $_annee = $Row[$annee_index]; 
                            $ref_code = $Row[$refCode_index]; 
                            $_brut = $Row[$brut_index]; 
                            $_ammor = $Row[$amortPR_index]; 
                            $_net1 = $Row[$net1_index]; 
                            $_net2 = $Row[$net2_index];                             
                            
                            # $_repertoire = $entityManager->getRepository(Repertoire::class)->findOneBy(array('codeCuci' => $code_cuci)); // ceci est necessaire seulement sur l'entité User
                            
                            # $bilan_existant = $entityManager->getRepository(Bilan::class)->findOneBy(array('repertoire' => $_repertoire,'refCode' => $ref_code, 'anneeFinanciere' => $_annee)); 

                            $_sql = "UPDATE cuci_bilan SET cuci_bilan.brut='".$_brut."', cuci_bilan.amort_pr='".$_ammor."', cuci_bilan.net1='".$_net1."', cuci_bilan.net2='".$_net2."', cuci_bilan.modified_by_id='".$userID."', cuci_bilan.updated_at='".$_today."' FROM cuci_bilan INNER JOIN cuci_repertoire r on cuci_bilan.repertoire_id=r.id WHERE r.code_cuci='".$code_cuci."' AND cuci_bilan.annee_financiere='".$_annee."' AND cuci_bilan.ref_code='".$ref_code."' AND cuci_bilan.type='".$_actif."';";
                            
                            $_upBilans = $conn->prepare($_sql);
                            
                            $stmt = $_upBilans->executeQuery();
                            
                            // make sure that the bilan exist in the db
                            
                            /**
                             * if ($bilan_existant) {
                             * $bilan_existant->setBrut($_brut);
                             * $bilan_existant->setAmortPR($_ammor);
                             * $bilan_existant->setNet1($_net1);
                             * $bilan_existant->setNet2($_net2);
                             * $entityManager->flush(); 
                             * // here Doctrine checks all the fields of all fetched data and make a transaction to the database.
                             * $_success++;
                             * }
                             * */                          
                        }
                        
                        $_success++;                        
                        $ind++;                        
                        
                    }                    
                    
                    break;

                case '2':
                    # ici on definit notre model bilan passif
                    $excelColonnes = [
                        'cuci', 'annee', 'ref_code', 'net1', 'net2'
                    ];
                    
                    // on verifie physiquement l allignement des colonnes
                    $col = UpdatedDataMigrationsController::excelNotFoundColumnException($excelColonnes, $mapColumns);
                    
                    // affiche à l'utilisateur un mssage d'erreur si le template ne suit pas ce format
                    if (!empty($col)) {
                        $this->addFlash(
                            'success',
                            "La colonne <strong> {$col} </strong> n'est pas définie dans le fichier Excel. Merci de vous référer sur le template de base !"
                        );
                        return $this->redirectToRoute('app_updated_data_migrations'); // pour le moment on retourne la page new
                    }

                    
                    // Récupère les index ou la position de chaque colonne
                    $codeCuci_index = array_search("cuci", $mapColumns, true);
                    $annee_index = array_search("annee", $mapColumns, true);
                    $refCode_index = array_search("ref_code", $mapColumns, true);
                    $net1_index = array_search("net1", $mapColumns, true);
                    $net2_index = array_search("net2", $mapColumns, true);
                    
                    
                    
                    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true); // here, the read data is turned into an array 
                    
                    $ind=1;

                    foreach ($sheetData as $Row) {
                        
                        if ($ind>1) {
                                # code...
                            $code_cuci = $Row[$codeCuci_index]; 
                            $_annee = $Row[$annee_index];
                            if ("CJ"!=$Row[$refCode_index]) {
                                $ref_code = $Row[$refCode_index];
                            } else {
                                $ref_code = "CI";
                            }
                            
                            //$ref_code = "CJ"==$Row[$refCode_index] ? "CI" : $Row[$refCode_index] ; 
                            $_net1 = $Row[$net1_index]; 
                            $_net2 = $Row[$net2_index]; 

                            
                            
                            # $_repertoire = $entityManager->getRepository(Repertoire::class)->findOneBy(array('codeCuci' => $code_cuci)); // ceci est necessaire seulement sur l'entité User
                            
                            # $bilan_existant = $entityManager->getRepository(Bilan::class)->findOneBy(array('repertoire' => $_repertoire,'refCode' => $ref_code, 'anneeFinanciere' => $_annee)); 


                            // if ($code_cuci!=null && $_annee!= null && $ref_code!=null) {
                            // }
                                
                            $_sql = "UPDATE cuci_bilan SET cuci_bilan.net1='".$_net1."', cuci_bilan.net2='".$_net2."', cuci_bilan.modified_by_id='".$userID."', cuci_bilan.updated_at='".$_today."' FROM cuci_bilan INNER JOIN cuci_repertoire r on cuci_bilan.repertoire_id=r.id WHERE r.code_cuci='".$code_cuci."' AND cuci_bilan.annee_financiere='".$_annee."' AND cuci_bilan.ref_code='".$ref_code."' AND cuci_bilan.type='".$_passif."';";
                            $_upBilans = $conn->prepare($_sql);
                                
                            $stmt = $_upBilans->executeQuery();

                            
                            
                            // make sure that the bilan exist in the db
                            
                            /**
                             * if ($bilan_existant) {
                             * $bilan_existant->setBrut($_brut);
                             * $bilan_existant->setAmortPR($_ammor);
                             * $bilan_existant->setNet1($_net1);
                             * $bilan_existant->setNet2($_net2);
                             * $entityManager->flush(); 
                             * // here Doctrine checks all the fields of all fetched data and make a transaction to the database.
                             * $_success++;
                             * }
                             * */                          
                        }
                        
                        $_success++;                        
                        $ind++;                        
                        
                    }                    
                    
                    break;

                case '3':

                    # ici on definit notre model compte_de_resultats
                    $excelColonnes = [
                        'cuci', 'annee', 'ref_code', 'net1', 'net2'
                    ];
                    
                    // on verifie physiquement l allignement des colonnes
                    $col = UpdatedDataMigrationsController::excelNotFoundColumnException($excelColonnes, $mapColumns);
                    
                    // affiche à l'utilisateur un mssage d'erreur si le template ne suit pas ce format
                    if (!empty($col)) {
                        $this->addFlash(
                            'success',
                            "La colonne <strong> {$col} </strong> n'est pas définie dans le fichier Excel. Merci de vous référer sur le template de base !"
                        );
                        return $this->redirectToRoute('app_updated_data_migrations'); // pour le moment on retourne la page new
                    }

                    
                    // Récupère les index ou la position de chaque colonne
                    $codeCuci_index = array_search("cuci", $mapColumns, true);
                    $annee_index = array_search("annee", $mapColumns, true);
                    $refCode_index = array_search("ref_code", $mapColumns, true);
                    $net1_index = array_search("net1", $mapColumns, true);
                    $net2_index = array_search("net2", $mapColumns, true);
                    
                    
                    
                    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true); // here, the read data is turned into an array 
                    
                    $ind=1;

                    foreach ($sheetData as $Row) {
                        
                        if ($ind>1) {
                                # code...
                            $code_cuci = $Row[$codeCuci_index]; 
                            $_annee = $Row[$annee_index]; 
                            $ref_code = $Row[$refCode_index]; 
                            $_net1 = $Row[$net1_index]; 
                            $_net2 = $Row[$net2_index]; 

                                // impossible de mettre a jour ce qui n existe pas
                            $_sql = "UPDATE cuci_compte_de_resultats SET cuci_compte_de_resultats.net1='".$_net1."', cuci_compte_de_resultats.net2='".$_net2."', cuci_compte_de_resultats.modifierPar='".$userID."', cuci_compte_de_resultats.updated_at='".$_today."' FROM cuci_compte_de_resultats INNER JOIN cuci_repertoire r on cuci_compte_de_resultats.cuci_rep_code_id=r.id WHERE r.code_cuci='".$code_cuci."' AND cuci_compte_de_resultats.annee_financiere='".$_annee."' AND cuci_compte_de_resultats.ref_code='".$ref_code."';";

                            $_upComptes = $conn->prepare($_sql);

                            $stmt = $_upComptes->executeQuery();
                            
                            $_success++;                        
                        
                        }

                        $ind++;

                        
                    }                    

                    break;

                case '4':

                    # ici on definit notre model compte_de_resultats
                    $excelColonnes = [
                        'cuci', 'annee', 'ref_code', 'net1', 'net2'
                    ];
                    
                    // on verifie physiquement l allignement des colonnes
                    $col = UpdatedDataMigrationsController::excelNotFoundColumnException($excelColonnes, $mapColumns);
                    
                    // affiche à l'utilisateur un mssage d'erreur si le template ne suit pas ce format
                    if (!empty($col)) {
                        $this->addFlash(
                            'success',
                            "La colonne <strong> {$col} </strong> n'est pas définie dans le fichier Excel. Merci de vous référer sur le template de base !"
                        );
                        return $this->redirectToRoute('app_updated_data_migrations'); // pour le moment on retourne la page new
                    }

                    
                    // Récupère les index ou la position de chaque colonne
                    $codeCuci_index = array_search("cuci", $mapColumns, true);
                    $annee_index = array_search("annee", $mapColumns, true);
                    $refCode_index = array_search("ref_code", $mapColumns, true);
                    $net1_index = array_search("net1", $mapColumns, true);
                    $net2_index = array_search("net2", $mapColumns, true);
                    
                    
                    
                    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true); // here, the read data is turned into an array 
                    
                    $ind=1;

                    foreach ($sheetData as $Row) {
                        
                        if ($ind>1) {
                                # code...
                            $code_cuci = $Row[$codeCuci_index]; 
                            $_annee = $Row[$annee_index]; 
                            $ref_code = $Row[$refCode_index]; 
                            $_net1 = $Row[$net1_index]; 
                            $_net2 = $Row[$net2_index]; 

                                // impossible de mettre a jour ce qui n existe pas
                            $_sql = "UPDATE cuci_etats_des_tresoreries SET cuci_etats_des_tresoreries.net1='".$_net1."', cuci_etats_des_tresoreries.net2='".$_net2."', cuci_etats_des_tresoreries.modified_by_id='".$userID."', cuci_etats_des_tresoreries.updated_at='".$_today."' FROM cuci_etats_des_tresoreries INNER JOIN cuci_repertoire r on cuci_etats_des_tresoreries.cuci_rep_code_id=r.id WHERE r.code_cuci='".$code_cuci."' AND cuci_etats_des_tresoreries.annee_financiere='".$_annee."' AND cuci_etats_des_tresoreries.ref_code='".$ref_code."';";

                            $_upComptes = $conn->prepare($_sql);

                            $stmt = $_upComptes->executeQuery();
                            
                            $_success++;                        
                        
                        }

                        $ind++;

                        
                    } 
                    
                    break;
                
                default:
                    # nothink TODO 
                
                    $this->addFlash(
                        'success',
                        'Choisir un tableau puis téléverser le template correspondant !'
                     );
                     return $this->redirectToRoute('app_updated_data_migrations'); // pour le moment on retourne la page new
     

                    break;
            }
            
            if($_success != 0){
                
                $this->addFlash(
                   'success',
                   'Mise à jour effectuée avec succes. '.$_success.' opérations affectées !'
                );
                return $this->redirectToRoute('app_updated_data_migrations'); // pour le moment on retourne la page new
            }            
            
            
        }


        // traitement sur le btnsubmit-creation
        if ($request->get('submit-creation')) {
            
            $file = $request->files->get('_resume'); // get the file from the sent request

            $fileFolder = __DIR__ . '/../../public/uploads/';  
            
            $filePathName = uniqid() . $file->getClientOriginalName();
            // apply md5 function to generate an unique identifier for the file and concat it with the file extension  
            
            
            try {
                $file->move($fileFolder, $filePathName);
            } catch (FileException $e) {
                dd($e);
            }

            $spreadsheet = IOFactory::load($fileFolder . $filePathName); // Here we are able to read from the excel file 
            
            // récupère le nom des colonnes
            $mapColumns = UpdatedDataMigrationsController::mapExcelColumns($spreadsheet);
            
            $selTab = $request->get('table');

            $_success = 0;

            $conn = $this->getDoctrine()->getManager()->getConnection(); // initialiser une cnx 

            // on veut savoir qui et quant a est effectuee cette mise a jour
            $user = $this->getUser(); 
            $userID = $user->getId();

            $_today = new \DateTime('now');

            $_today = $_today->format("Y-m-d H:i:s") ;

            $_actif = "Actif";
            $_passif = "Passif";

            switch ($selTab) {
                case '1':
                    
                    # ici on definit notre model bilan
                    $excelColonnes = [
                        'cuci', 'annee', 'ref_code', 'brut', 'amort_pr', 'net1', 'net2'
                    ];
                    
                    // on verifie physiquement l allignement des colonnes
                    $col = UpdatedDataMigrationsController::excelNotFoundColumnException($excelColonnes, $mapColumns);
                    
                    // affiche à l'utilisateur un mssage d'erreur si le template ne suit pas ce format
                    if (!empty($col)) {
                        $this->addFlash(
                            'success',
                            "La colonne <strong> {$col} </strong> n'est pas définie dans le fichier Excel. Merci de vous référer sur le template de base !"
                        );
                        return $this->redirectToRoute('app_updated_data_migrations'); // pour le moment on retourne la page new
                    }

                    
                    // Récupère les index ou la position de chaque colonne
                    $codeCuci_index = array_search("cuci", $mapColumns, true);
                    $annee_index = array_search("annee", $mapColumns, true);
                    $refCode_index = array_search("ref_code", $mapColumns, true);
                    $brut_index = array_search("brut", $mapColumns, true);
                    $amortPR_index = array_search("amort_pr", $mapColumns, true);
                    $net1_index = array_search("net1", $mapColumns, true);
                    $net2_index = array_search("net2", $mapColumns, true);                    
                    
                    
                    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true); // here, the read data is turned into an array 
                    
                    $ind=1;

                    foreach ($sheetData as $key => $Rows) {
                        if ($ind>1) {
                            $code_cuci = $Rows[$codeCuci_index]; 
                            $_annee = $Rows[$annee_index]; 
                            $ref_code = $Rows[$refCode_index]; 
                            $_brut =  $Rows[$brut_index]; 
                            $_ammor = $Rows[$amortPR_index]; 
                            $_net1 = $Rows[$net1_index]; 
                            $_net2 = $Rows[$net2_index];

                            $_repertoire = $entityManager->getRepository(Repertoire::class)->findOneBy(array('codeCuci' => $code_cuci));
                            
                            $bilan_existant = $entityManager->getRepository(Bilan::class)->findOneBy(array('repertoire' => $_repertoire,'refCode' => $ref_code, 'anneeFinanciere' => $_annee, 'type'=>"Actif")); 

                            // make sure that the bilan does not exist in the db
                            
                            
                            if (!$bilan_existant) {

                                $bilan_existant = new Bilan();
                                $bilan_existant->setBrut($_brut);
                                $bilan_existant->setAmortPR($_ammor);
                                $bilan_existant->setNet1($_net1);
                                $bilan_existant->setNet2($_net2);
                                $bilan_existant->setType("Actif")
                                               ->setModifiedBy($user)
                                               ->setCreatedBy($user)
                                               ->setUpdatedAt(new \DateTime('now'))
                                               ->setRepertoire($_repertoire)
                                               ->setRefCode($ref_code)
                                               ->setAnneeFinanciere($_annee)
                                               ->setSubmit(1)
                                ;
                                
                                $entityManager->persist($bilan_existant);
                                $entityManager->flush(); 
                                // here Doctrine checks all the fields of all fetched data and make a transaction to the database.
                                $_success++;
                            }                                                     

                        }

                        $ind++;                        
                        
                    }

                    break;

                case '2':
                    
                    # ici on definit notre model bilan
                    $excelColonnes = [
                        'cuci', 'annee', 'ref_code', 'net1', 'net2'
                    ];
                    
                    // on verifie physiquement l allignement des colonnes
                    $col = UpdatedDataMigrationsController::excelNotFoundColumnException($excelColonnes, $mapColumns);
                    
                    // affiche à l'utilisateur un mssage d'erreur si le template ne suit pas ce format
                    if (!empty($col)) {
                        $this->addFlash(
                            'success',
                            "La colonne <strong> {$col} </strong> n'est pas définie dans le fichier Excel. Merci de vous référer sur le template de base !"
                        );
                        return $this->redirectToRoute('app_updated_data_migrations'); // pour le moment on retourne la page new
                    }

                    
                    // Récupère les index ou la position de chaque colonne
                    $codeCuci_index = array_search("cuci", $mapColumns, true);
                    $annee_index = array_search("annee", $mapColumns, true);
                    $refCode_index = array_search("ref_code", $mapColumns, true);
                    $net1_index = array_search("net1", $mapColumns, true);
                    $net2_index = array_search("net2", $mapColumns, true);                    
                    
                    
                    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true); // here, the read data is turned into an array 
                    
                    $ind=1;

                    foreach ($sheetData as $key => $Rows) {
                        if ($ind>1) {
                            $code_cuci = $Rows[$codeCuci_index]; 
                            $_annee = $Rows[$annee_index]; 
                            if ("CJ"!=$Rows[$refCode_index]) {
                                $ref_code = $Rows[$refCode_index];
                            } else {
                                $ref_code = "CI";
                            }
                            
                            // $ref_code = "CJ"==$Rows[$refCode_index] ? "CI" : $Rows[$refCode_index]; 
                            $_net1 = $Rows[$net1_index]; 
                            $_net2 = $Rows[$net2_index];

                            $_repertoire = $entityManager->getRepository(Repertoire::class)->findOneBy(array('codeCuci' => $code_cuci));
                            
                            $bilan_existant_passif = $entityManager->getRepository(Bilan::class)->findOneBy(array('repertoire' => $_repertoire,'refCode' => $ref_code, 'anneeFinanciere' => $_annee, 'type'=>"Passif")); 
                            
                            if (!$bilan_existant_passif) {

                                $bilan_existant_passif = new Bilan();
                                $bilan_existant_passif->setNet1($_net1);
                                $bilan_existant_passif->setNet2($_net2);
                                $bilan_existant_passif->setType("Passif");
                                $bilan_existant_passif->setModifiedBy($user);
                                $bilan_existant_passif->setCreatedBy($user);
                                $bilan_existant_passif->setUpdatedAt(new \DateTime('now'));
                                $bilan_existant_passif->setRepertoire($_repertoire);
                                $bilan_existant_passif->setRefCode($ref_code);
                                $bilan_existant_passif->setAnneeFinanciere($_annee);
                                $bilan_existant_passif->setSubmit(1);
                                
                                $entityManager->persist($bilan_existant_passif);
                                $entityManager->flush(); 
                                // here Doctrine checks all the fields of all fetched data and make a transaction to the database.
                                $_success++;
                            }
                                                     

                        }

                        $ind++;                        
                        
                    }

                    break;

                case "3":
                    
                    # ici on definit notre model compte_de_resultats
                    $excelColonnes = [
                        'cuci', 'annee', 'ref_code', 'net1', 'net2'
                    ];
                    
                    // on verifie physiquement l allignement des colonnes
                    $col = UpdatedDataMigrationsController::excelNotFoundColumnException($excelColonnes, $mapColumns);
                    
                    // affiche à l'utilisateur un mssage d'erreur si le template ne suit pas ce format
                    if (!empty($col)) {
                        $this->addFlash(
                            'success',
                            "La colonne <strong> {$col} </strong> n'est pas définie dans le fichier Excel. Merci de vous référer sur le template de base !"
                        );
                        return $this->redirectToRoute('app_updated_data_migrations'); // pour le moment on retourne la page new
                    }

                    
                    // Récupère les index ou la position de chaque colonne
                    $codeCuci_index = array_search("cuci", $mapColumns, true);
                    $annee_index = array_search("annee", $mapColumns, true);
                    $refCode_index = array_search("ref_code", $mapColumns, true);
                    $net1_index = array_search("net1", $mapColumns, true);
                    $net2_index = array_search("net2", $mapColumns, true);
                    
                    
                    
                    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true); // here, the read data is turned into an array 
                    
                    $ind=1;

                    foreach ($sheetData as $Row) {
                        
                        if ($ind>1) {
                                # code...
                            $code_cuci = $Row[$codeCuci_index]; 
                            $_annee = $Row[$annee_index]; 
                            $ref_code = $Row[$refCode_index]; 
                            $_net1 = $Row[$net1_index]; 
                            $_net2 = $Row[$net2_index]; 


                            $_repertoire = $entityManager->getRepository(Repertoire::class)->findOneBy(array('codeCuci' => $code_cuci));
                            
                            $isCrExist = $entityManager->getRepository(CompteDeResultats::class)->findOneBy(array('cuci_rep_code' => $_repertoire,'ref_code' => $ref_code, 'annee_financiere' => $_annee));

                            if (!$isCrExist) {
                                $isCrExist = new CompteDeResultats();

                                $isCrExist->setCuciRepCode($_repertoire)
                                          ->setAnneeFinanciere($_annee)
                                          ->setRefCode($ref_code)
                                          ->setNet1($_net1)
                                          ->setNet2($_net2)
                                          ->setSubmit(1)
                                          ->setCreatedBy($user)
                                          ->setModifiedBy($user)
                                ;

                                $entityManager->persist($isCrExist);
                                $entityManager->flush();
                            }
                            
                            
                            $_success++;                        
                        
                        }

                        $ind++;

                        
                    }

                    break;

                case "4":
                    
                    # ici on definit notre model compte_de_resultats
                    $excelColonnes = [
                        'cuci', 'annee', 'ref_code', 'net1', 'net2'
                    ];
                    
                    // on verifie physiquement l allignement des colonnes
                    $col = UpdatedDataMigrationsController::excelNotFoundColumnException($excelColonnes, $mapColumns);
                    
                    // affiche à l'utilisateur un mssage d'erreur si le template ne suit pas ce format
                    if (!empty($col)) {
                        $this->addFlash(
                            'success',
                            "La colonne <strong> {$col} </strong> n'est pas définie dans le fichier Excel. Merci de vous référer sur le template de base !"
                        );
                        return $this->redirectToRoute('app_updated_data_migrations'); // pour le moment on retourne la page new
                    }

                    
                    // Récupère les index ou la position de chaque colonne
                    $codeCuci_index = array_search("cuci", $mapColumns, true);
                    $annee_index = array_search("annee", $mapColumns, true);
                    $refCode_index = array_search("ref_code", $mapColumns, true);
                    $net1_index = array_search("net1", $mapColumns, true);
                    $net2_index = array_search("net2", $mapColumns, true);
                    
                    
                    
                    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true); // here, the read data is turned into an array 
                    
                    $ind=1;

                    foreach ($sheetData as $Row) {
                        
                        if ($ind>1) {
                                # code...
                            $code_cuci = $Row[$codeCuci_index]; 
                            $_annee = $Row[$annee_index]; 
                            $ref_code = $Row[$refCode_index]; 
                            $_net1 = $Row[$net1_index]; 
                            $_net2 = $Row[$net2_index]; 
                            // $_net1 = 0==$Row[$net1_index] ? "" : $Row[$net1_index]; 
                            // $_net2 = 0==$Row[$net2_index] ? "" : $Row[$net2_index]; 
                            
                            $_repertoire = $entityManager->getRepository(Repertoire::class)->findOneBy(array('codeCuci' => $code_cuci));
                            
                            $isFtExist = $entityManager->getRepository(FluxDesTresoreries::class)->findOneBy(array('cuci_rep_code' => $_repertoire,'ref_code' => $ref_code, 'annee_financiere' => $_annee));

                            if(!$isFtExist){

                                $isFtExist = new FluxDesTresoreries();

                                $isFtExist->setCuciRepCode($_repertoire)
                                          ->setAnneeFinanciere($_annee)
                                          ->setRefCode($ref_code)
                                          ->setNet1($_net1)
                                          ->setNet2($_net2)
                                          ->setSubmit(1)
                                          ->setEditedBy($user)
                                          ->setModifiedBy($user)
                                ;

                                $entityManager->persist($isFtExist);
                                $entityManager->flush();

                            }

                            
                            $_success++;                        
                        
                        }

                        $ind++;

                        
                    }
                    break;
                
                default:
                    # code...
                    break;
            }

            if($_success != 0){

                $this->addFlash(
                   'success',
                   'Création effectuée avec succes. '.$_success.'opérations affectées !'
                );
                return $this->redirectToRoute('app_updated_data_migrations'); // pour le moment on retourne la page new
            }

        }
        
        return $this->render('updated_data_migrations/index.html.twig', [
            'controller_name' => 'UpdatedDataMigrationsController',
        ]);
    }

    /**
     * @Route("/updated/data/migrations/errnoannee", name="app_updated_data_migrations_errnoannee")
     */
    public function updatingYear(Request $request, EntityManagerInterface $entityManager): Response
    {
        ini_set("memory_limit", -1);
        ini_set ( 'max_execution_time', -1);

        $name1 = str_replace (' ',"", strtolower("Company Inc"));
        $name2 = str_replace (' ',"", strtolower("company I nc"));

        $sim = similar_text($name1, $name2, $percent);

        //dd($sim ." " .$percent);

        if ($request->get('submit-templ')) {  
            
            // recuperer tous les inputs en val
            // $selTab = $request->get('tabl-input');
            // ici on change d'approche en utilisant les checkbox 

            $selTab1 = $request->get('customCheckcolor1'); 
            $selTab2 = $request->get('customCheckcolor2'); 
            $selTab3 = $request->get('customCheckcolor3'); 
            $selTab4 = $request->get('customCheckcolor4'); 
            $selTab5 = $request->get('customCheckcolor5'); 

            $selAnneeError = $request->get('_erreno');
            $selAnneeCorrect = $request->get('_anneecorrect');
            $selCuci = $request->get('_cuciconcerne');

            $_success = 0;

            $conn = $this->getDoctrine()->getManager()->getConnection(); // initialiser une cnx 

            // on veut savoir qui et quand a/est effectuee cette mise a jour
            $user = $this->getUser(); 
            $userID = $user->getId();

            $_today = new \DateTime('now');

            $_today = $_today->format("Y-m-d H:i:s") ;
            
            $_actif = "Actif";
            $_passif = "Passif";
            /**switch ($selTab) {

                
                case '1': // cas du bilan actif
                    // faut chercher les occurences dejà existantes pour ce cuci/annee

                    $_search_req = "SELECT * FROM cuci_bilan b inner join cuci_repertoire r on b.repertoire_id=r.id WHERE b.annee_financiere='".$selAnneeError."' AND r.code_cuci='".$selCuci."' AND b.type='".$_actif."';";

                    $_search_req = $conn->prepare($_search_req);
                    $_search_req=$_search_req->executeQuery()->fetchAllAssociative();
                    
                    if ($_search_req) {
                        
                        foreach ($_search_req as $key => $obj) {
                            
                            $_sql = "UPDATE cuci_bilan SET cuci_bilan.annee_financiere='".$selAnneeCorrect."' FROM cuci_bilan INNER JOIN cuci_repertoire r on cuci_bilan.repertoire_id=r.id WHERE r.code_cuci='".$selCuci."' AND cuci_bilan.annee_financiere='".$selAnneeError."' AND cuci_bilan.ref_code='".$obj['ref_code']."' AND cuci_bilan.type='".$_actif."';";
                            $_sql = $conn->prepare($_sql);
                            $_sql=$_sql->executeQuery();
                        }

                        $_success = 1;
                        
                    }else{

                        $this->addFlash(
                            'notice',
                            "Assurez vous de mettre les bonnes informations une table, année erronée, année de correction et le CUCI concerné !"
                        );
                        return $this->redirectToRoute('app_updated_data_migrations_errnoannee'); // pour le moment on retourne la page new

                    }                        
                    
                    break;

                case '2':
                    
                    $_search_req = "SELECT * FROM cuci_bilan b inner join cuci_repertoire r on b.repertoire_id=r.id WHERE b.annee_financiere='".$selAnneeError."' AND r.code_cuci='".$selCuci."' AND b.type='".$_passif."';";

                    $_search_req = $conn->prepare($_search_req);
                    $_search_req=$_search_req->executeQuery()->fetchAllAssociative();
                    
                    if ($_search_req) {
                        
                        foreach ($_search_req as $key => $obj) {
                            
                            $_sql = "UPDATE cuci_bilan SET cuci_bilan.annee_financiere='".$selAnneeCorrect."' FROM cuci_bilan INNER JOIN repertoire r on cuci_bilan.repertoire_id=r.id WHERE r.code_cuci='".$selCuci."' AND cuci_bilan.annee_financiere='".$selAnneeError."' AND cuci_bilan.ref_code='".$obj['ref_code']."' AND cuci_bilan.type='".$_passif."';";
                            $_sql = $conn->prepare($_sql);
                            $_sql=$_sql->executeQuery();
                        }

                        $_success = 1;
                        
                    }else{

                        $this->addFlash(
                            'notice',
                            "Assurez vous de mettre les bonnes informations une table, année erronée, année de correction et le CUCI concerné !"
                        );
                        return $this->redirectToRoute('app_updated_data_migrations_errnoannee'); // pour le moment on retourne la page new

                    }                        
                    
                    break;

                case '3':
                    
                    $_search_req = "SELECT * FROM cuci_compte_de_resultats cr inner join cuci_repertoire r on cr.cuci_rep_code_id=r.id WHERE cr.annee_financiere='".$selAnneeError."' AND r.code_cuci='".$selCuci."';";

                    $_search_req = $conn->prepare($_search_req);
                    $_search_req=$_search_req->executeQuery()->fetchAllAssociative();
                    
                    if ($_search_req) {
                        
                        foreach ($_search_req as $key => $obj) {
                            
                            $_sql = "UPDATE cuci_compte_de_resultats SET cuci_compte_de_resultats.annee_financiere='".$selAnneeCorrect."' FROM cuci_compte_de_resultats INNER JOIN cuci_repertoire r on cuci_compte_de_resultats.cuci_rep_code_id=r.id WHERE r.code_cuci='".$selCuci."' AND cuci_compte_de_resultats.annee_financiere='".$selAnneeError."' AND cuci_compte_de_resultats.ref_code='".$obj['ref_code']."';";
                            $_sql = $conn->prepare($_sql);
                            $_sql=$_sql->executeQuery();
                        }

                        $_success = 1;
                        
                    }else{

                        $this->addFlash(
                            'notice',
                            "Assurez vous de mettre les bonnes informations une table, année erronée, année de correction et le CUCI concerné !"
                        );
                        return $this->redirectToRoute('app_updated_data_migrations_errnoannee'); // pour le moment on retourne la page new

                    }                        
                    
                    break;

                case '4':
                    
                    $_search_req = "SELECT * FROM cuci_etats_des_tresoreries ft inner join cuci_repertoire r on ft.cuci_rep_code_id=r.id WHERE ft.annee_financiere='".$selAnneeError."' AND r.code_cuci='".$selCuci."';";

                    $_search_req = $conn->prepare($_search_req);
                    $_search_req=$_search_req->executeQuery()->fetchAllAssociative();
                    
                    if ($_search_req) {
                        
                        foreach ($_search_req as $key => $obj) {
                            
                            $_sql = "UPDATE cuci_etats_des_tresoreries SET cuci_etats_des_tresoreries.annee_financiere='".$selAnneeCorrect."' FORM cuci_etats_des_tresoreries INNER JOIN cuci_repertoire r on cuci_etats_des_tresoreries.cuci_rep_code_id=r.id WHERE r.code_cuci='".$selCuci."' AND cuci_etats_des_tresoreries.annee_financiere='".$selAnneeError."' AND cuci_etats_des_tresoreries.ref_code='".$obj['ref_code']."';";
                            $_sql = $conn->prepare($_sql);
                            $_sql=$_sql->executeQuery();
                        }

                        $_success = 1;
                        
                    }else{

                        $this->addFlash(
                            'notice',
                            "Assurez vous de mettre les bonnes informations une table, année erronée, année de correction et le CUCI concerné !"
                        );
                        return $this->redirectToRoute('app_updated_data_migrations_errnoannee'); // pour le moment on retourne la page new

                    }                        
                    
                    break;
                
                default:
                    # nothink TODO 
                
                    $this->addFlash(
                        'notice',
                        'Choisir un tableau, année erronée, année de correction et le CUCI concerné !'
                     );
                     return $this->redirectToRoute('app_updated_data_migrations_errnoannee'); // pour le moment on retourne la page new
     

                    break;
            }
            */


            if ($selTab1!="") {
                // TODO MAJ de la table bilan actif dd($selTab1);

                // faut chercher les occurences dejà existantes pour ce cuci/annee

                $_search_req = "SELECT * FROM cuci_bilan b inner join cuci_repertoire r on b.repertoire_id=r.id WHERE b.annee_financiere='".$selAnneeError."' AND r.code_cuci='".$selCuci."' AND b.type='".$_actif."';";

                $_search_req = $conn->prepare($_search_req);
                $_search_req=$_search_req->executeQuery()->fetchAllAssociative();
                
                if ($_search_req) {
                    
                    foreach ($_search_req as $key => $obj) {
                        
                        $_sql = "UPDATE cuci_bilan SET cuci_bilan.annee_financiere='".$selAnneeCorrect."' FROM cuci_bilan INNER JOIN cuci_repertoire r on cuci_bilan.repertoire_id=r.id WHERE r.code_cuci='".$selCuci."' AND cuci_bilan.annee_financiere='".$selAnneeError."' AND cuci_bilan.ref_code='".$obj['ref_code']."' AND cuci_bilan.type='".$_actif."';"; // sur sql server ceci marche 
                        //$_sql = "UPDATE cuci_bilan INNER JOIN cuci_repertoire AS r on cuci_bilan.repertoire_id=r.id SET cuci_bilan.annee_financiere='".$selAnneeCorrect."' WHERE r.code_cuci='".$selCuci."' AND cuci_bilan.annee_financiere='".$selAnneeError."' AND cuci_bilan.ref_code='".$obj['ref_code']."' AND cuci_bilan.type='".$_actif."';"; // sur sql server ceci qui marche 
                        
                        $_sql = $conn->prepare($_sql);
                        $_sql=$_sql->executeQuery();
                    }
                    
                    $_success = 1;
                        
                }else{

                    $this->addFlash(
                        'notice',
                        "Assurez vous de mettre les bonnes informations une table, année erronée, année de correction et le CUCI concerné !"
                    );
                    return $this->redirectToRoute('app_updated_data_migrations_errnoannee'); // pour le moment on retourne la page new

                }
            }

            if ($selTab2!="") {
                //TODO de la table bilan passif

                $_search_req = "SELECT * FROM cuci_bilan b inner join cuci_repertoire r on b.repertoire_id=r.id WHERE b.annee_financiere='".$selAnneeError."' AND r.code_cuci='".$selCuci."' AND b.type='".$_passif."';";

                $_search_req = $conn->prepare($_search_req);
                $_search_req=$_search_req->executeQuery()->fetchAllAssociative();
                
                if ($_search_req) {
                    
                    foreach ($_search_req as $key => $obj) {
                        
                        $_sql = "UPDATE cuci_bilan SET cuci_bilan.annee_financiere='".$selAnneeCorrect."' FROM cuci_bilan INNER JOIN cuci_repertoire r on cuci_bilan.repertoire_id=r.id WHERE r.code_cuci='".$selCuci."' AND cuci_bilan.annee_financiere='".$selAnneeError."' AND cuci_bilan.ref_code='".$obj['ref_code']."' AND cuci_bilan.type='".$_passif."';";
                        // $_sql = "UPDATE cuci_bilan INNER JOIN cuci_repertoire AS r on cuci_bilan.repertoire_id=r.id SET cuci_bilan.annee_financiere='".$selAnneeCorrect."' WHERE r.code_cuci='".$selCuci."' AND cuci_bilan.annee_financiere='".$selAnneeError."' AND cuci_bilan.ref_code='".$obj['ref_code']."' AND cuci_bilan.type='".$_passif."';";
                        $_sql = $conn->prepare($_sql);
                        $_sql=$_sql->executeQuery();
                    }

                    $_success = 1;
                    
                }else{

                    $this->addFlash(
                        'notice',
                        "Assurez vous de mettre les bonnes informations une table, année erronée, année de correction et le CUCI concerné !"
                    );
                    return $this->redirectToRoute('app_updated_data_migrations_errnoannee'); // pour le moment on retourne la page new

                }                        
                            
            }


            if ($selTab3!="") {

                $_search_req = "SELECT * FROM cuci_compte_de_resultats cr inner join cuci_repertoire r on cr.cuci_rep_code_id=r.id WHERE cr.annee_financiere='".$selAnneeError."' AND r.code_cuci='".$selCuci."';";

                $_search_req = $conn->prepare($_search_req);
                $_search_req=$_search_req->executeQuery()->fetchAllAssociative();
                
                if ($_search_req) {
                    
                    foreach ($_search_req as $key => $obj) {
                        
                        $_sql = "UPDATE cuci_compte_de_resultats SET cuci_compte_de_resultats.annee_financiere='".$selAnneeCorrect."' FROM cuci_compte_de_resultats INNER JOIN cuci_repertoire r on cuci_compte_de_resultats.cuci_rep_code_id=r.id WHERE r.code_cuci='".$selCuci."' AND cuci_compte_de_resultats.annee_financiere='".$selAnneeError."' AND cuci_compte_de_resultats.ref_code='".$obj['ref_code']."';"; // sur sql server
                        // $_sql = "UPDATE cuci_compte_de_resultats INNER JOIN cuci_repertoire AS r on cuci_compte_de_resultats.cuci_rep_code_id=r.id SET cuci_compte_de_resultats.annee_financiere='".$selAnneeCorrect."' WHERE r.code_cuci='".$selCuci."' AND cuci_compte_de_resultats.annee_financiere='".$selAnneeError."' AND cuci_compte_de_resultats.ref_code='".$obj['ref_code']."';";
                        $_sql = $conn->prepare($_sql);
                        $_sql=$_sql->executeQuery();
                    }

                    $_success = 1;
                    
                }else{

                    $this->addFlash(
                        'notice',
                        "Assurez vous de mettre les bonnes informations une table, année erronée, année de correction et le CUCI concerné !"
                    );
                    return $this->redirectToRoute('app_updated_data_migrations_errnoannee'); // pour le moment on retourne la page new

                }


            }
            if ($selTab4!="") {

                
                $_search_req = "SELECT * FROM cuci_etats_des_tresoreries ft inner join cuci_repertoire r on ft.cuci_rep_code_id=r.id WHERE ft.annee_financiere='".$selAnneeError."' AND r.code_cuci='".$selCuci."';";
                
                $_search_req = $conn->prepare($_search_req);
                $_search_req=$_search_req->executeQuery()->fetchAllAssociative();
                
                if ($_search_req) {
                    
                    foreach ($_search_req as $key => $obj) {
                        
                        $_sql = "UPDATE cuci_etats_des_tresoreries SET cuci_etats_des_tresoreries.annee_financiere='".$selAnneeCorrect."' FORM cuci_etats_des_tresoreries INNER JOIN cuci_repertoire r on cuci_etats_des_tresoreries.cuci_rep_code_id=r.id WHERE r.code_cuci='".$selCuci."' AND cuci_etats_des_tresoreries.annee_financiere='".$selAnneeError."' AND cuci_etats_des_tresoreries.ref_code='".$obj['ref_code']."';";
                        // $_sql = "UPDATE cuci_etats_des_tresoreries INNER JOIN cuci_repertoire AS r on cuci_etats_des_tresoreries.cuci_rep_code_id=r.id SET cuci_etats_des_tresoreries.annee_financiere='".$selAnneeCorrect."' WHERE r.code_cuci='".$selCuci."' AND cuci_etats_des_tresoreries.annee_financiere='".$selAnneeError."' AND cuci_etats_des_tresoreries.ref_code='".$obj['ref_code']."';";
                        $_sql = $conn->prepare($_sql);
                        $_sql=$_sql->executeQuery();
                    }

                    $_success = 1;
                    
                }else{

                    $this->addFlash(
                        'notice',
                        "Assurez vous de mettre les bonnes informations une table, année erronée, année de correction et le CUCI concerné !"
                    );
                    return $this->redirectToRoute('app_updated_data_migrations_errnoannee'); // pour le moment on retourne la page new

                }


            }
            if ($selTab5!="") {
                // TODO mise à jour de toutes les tables dd($selTab1);
            }
            
            if($_success != 0){
                
                $this->addFlash(
                   'success',
                   'Mise à jour effectuée avec succes. '.$_success.'opérations affectées !'
                );
                return $this->redirectToRoute('app_updated_data_migrations_errnoannee'); // pour le moment on retourne la page new
            }            
            
            
        }
        
        return $this->render('updated_data_migrations/_errnoannee.html.twig', [
            'controller_name' => 'UpdatedDataMigrationsController',
        ]);
    }

    /**
     * @Route("/update/dmatrepertoire", name="app_update_dmatrepertoire")
     */
    public function updateDmatRepertoire(): Response
    {
        // methode de test importation d'une repertoire 
        
        return $this->render('updated_data_migrations/$0.html.twig', [
            "dmatrep"=>"import dmat rep",
        ]);
    }


    /**
     * @Route("/update/telecharger", name="app_telecharger_template_etat_financier")
     * @return mixed
     */
    public function telechargerTemplates( ): Response
    {
        $fileFolder=$this->getParameter("path_absolu").DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR;

        //load a file from filesystem
        $f = new File($fileFolder.'template_bilan_actif.xlsx');

        // rename the downloaded file
        return $this->file($f, 'custom_bilan_actif.xlsx');

    }

    /**
     * @Route("/update/telecharger1", name="app_telecharger_template_etat_financier1")
     * @return mixed
     */
    public function telechargerTemplates1( ): Response
    {
        $fileFolder=$this->getParameter("path_absolu").DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR;

        //load a file from filesystem
        $f = new File($fileFolder.'template_bilan_passif.xlsx');

        // rename the downloaded file
        return $this->file($f, 'custom_bilan_passif.xlsx');

    }


    /**
     * @Route("/update/telecharger2", name="app_telecharger_template_etat_financier2")
     * @return mixed
     */
    public function telechargerTemplates2( ): Response
    {
        $fileFolder=$this->getParameter("path_absolu").DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR;

        //load a file from filesystem
        $file2 = new File($fileFolder.'template_compteR.xlsx');

        // rename the downloaded file
        return $this->file($file2, 'custom_template_compteR.xlsx');

    }


    /**
     * @Route("/update/telecharger3", name="app_telecharger_template_etat_financier3")
     * @return mixed
     */
    public function telechargerTemplates3( ): Response
    {
        $fileFolder=$this->getParameter("path_absolu").DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR;


        //load a file from filesystem
        $file3 = new File($fileFolder.'template_fluxTR.xlsx');

        // rename the downloaded file
        return $this->file($file3, 'custom_template_fluxTR.xlsx');

    }
}
