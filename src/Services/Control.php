<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\NINinea;
use App\Entity\NiFormejuridique;





class Control
{

    /**
	* Retourne le numéro de demande suivant
	*/
	public function controlRCCM( $rc,$datereg,EntityManagerInterface $entityManager,NiFormejuridique $fj,$etat) {
	    
        $rccm =  str_replace(" ","",$rc) ;
        $rccmNormal = str_replace("_","",$rccm);
       
        //$pays = substr($rccm, 0, 2);
        //$juridiction = substr($rccm, 2, 3);
        $annee = substr($rccm, 5, 4);
        //$lettrecle = substr($rccm, 9, 1);
        //$sequence = substr($rccm, 10, 5);
        $annee_cours = date("Y");
        $controleRccm = $entityManager->getRepository(NINinea::class)->findninRegcom($rccmNormal);
       
        $datereg_annee =  date('Y', strtotime($datereg));
        //dd($controleRccm)
        if($etat == 2)
           $pattern_rccm = "/^(SN)(DKR|STL|KLK|TBC|THS|DBL|KLD|ZGR|LGA|FTK|MTM|SDH|KDG|MBR)(\d{4})(E)(\d{1,5})$/"; 
          
        
        else if($fj->getId() == 10)
          $pattern_rccm = "/^(SN)(DKR|STL|KLK|TBC|THS|DBL|KLD|ZGR|LGA|FTK|MTM|SDH|KDG|MBR)(\d{4})(A)(\d{1,5})$/"; 
        else if($fj->getId() == 11 or $fj->getId() == 12 or $fj->getId() == 13 or $fj->getId() == 14 
                or $fj->getId() == 20 or $fj->getId() == 22 or $fj->getId() == 21 or $fj->getId() == 23 
                or $fj->getId() == 24 or $fj->getId() == 25 or $fj->getId() == 31 or $fj->getId() == 29  or $fj->getId() == 28 
                or $fj->getId() == 91 or $fj->getId() == 92)
        {
          $pattern_rccm = "/^(SN)(DKR|STL|KLK|TBC|THS|DBL|KLD|ZGR|LGA|FTK|MTM|SDH|KDG|MBR)(\d{4})(B)(\d{1,5})$/"; 
        }
        else if ($fj->getId() == 49) 
        {
            $pattern_rccm = "/^(SN)(DKR|STL|KLK|TBC|THS|DBL|KLD|ZGR|LGA|FTK|MTM|SDH|KDG|MBR)(\d{4})(B|C)(\d{1,5})$/"; 
        }
        else if ($fj->getId() == 93) 
        {
            $pattern_rccm = "/^(SN)(DKR|STL|KLK|TBC|THS|DBL|KLD|ZGR|LGA|FTK|MTM|SDH|KDG|MBR)(\d{4})(E)(\d{1,5})$/"; 
        }
        else{
            $pattern_rccm = "/^(SN)(DKR|STL|KLK|TBC|THS|DBL|KLD|ZGR|LGA|FTK|MTM|SDH|KDG|MBR)(\d{4})(C)(\d{1,5})$/"; 
        }

        $dateJour = date('Y-m-d');
        // $pattern = "/(SN)(DKR|STL|KLK|TBC|THS|DBL|KLD|ZGR|LGA|FTK|MTM|SDH|KDG|MBR|[A-Z]{3})(\d{4})(A|B|C|E|[A-Z]{1})(\d{1,5})$/"; 
       

        if (count($controleRccm) > 0)
        {
            return 1;
        }
        else if(preg_match($pattern_rccm, $rccmNormal) == 0)
        {
            return 2;
        }
        else if ($annee > $datereg_annee )
        {
            return 3;
        }
        elseif($annee > $annee_cours)
        {
          return 4;
        }
        else if ($annee < "1900" )
        {
            return 5;
        }
        elseif ($datereg > $dateJour)
        {
           return 6;
        }
        
        else
        {
            return 0;
        }
    } 
    
    
     /**
	* Retourne le numéro de demande suivant
	*/
	public function controlDocument( $document) 
    {
	        $pattern = "/(SN)(DKR|STL|KLK|TBC|THS|DBL|KLD|ZGR|LGA|FTK|MTM|SDH|KDG|MBR|[A-Z]{3})(\d{4})(A|B|C|E|[A-Z]{1})(\d{1,5})$/"; 

            $bordereau = trim($document);

            if (preg_match($pattern, $bordereau) == 1)
            {
                return 1;
            }
            else 
            {
                return 0;
            }
       
    } 

}