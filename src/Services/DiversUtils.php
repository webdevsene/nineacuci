<?php

namespace App\Services;

use App\Entity\CompteurDemandeNINEA;
use App\Entity\CompteurNINEA;
use App\Entity\CompteurNINET;
use App\Entity\NINinea;

use Doctrine\ORM\EntityManagerInterface;

class DiversUtils
{
	/**
	* Retourne le numéro de demande suivant
	*/
	public function numDemandeSuivant(EntityManagerInterface $entityManager) {
	    $numCompteur=0;

        $last_numCompteur=$entityManager->getRepository(CompteurDemandeNINEA::class)->findBy(array(),array('id'=>'desc'),1,0);

        if(count($last_numCompteur)>0){
            $numCompteur= $last_numCompteur[0]->getId();
        }

        $numCompteur++;

        $sNumCompteur=strval($numCompteur);
        $zeros="0000000000";
        $zeros=substr($zeros,0,10-strlen($sNumCompteur));
        $numeroDemandeSuivant=$zeros.$sNumCompteur;

        return $numeroDemandeSuivant;
	}


    /**
	* Retourne le numéro de demande suivant
	*/
	public function genereNumNINEA(EntityManagerInterface $entityManager) {
	    $numCompteur=0;

        //Génération de la sequence de 8 chiffres
        $last_numCompteur=$entityManager->getRepository(CompteurNINEA::class)->findBy(array(),array('id'=>'desc'),1,0);

        if(count($last_numCompteur)>0){
            $numCompteur= $last_numCompteur[0]->getId();
        }
        $numCompteur++;

        $sNumCompteur=strval($numCompteur);
        $zeros="00000000";
        $zeros=substr($zeros,0,8-strlen($sNumCompteur));
        $numeroNINEA=$zeros.$sNumCompteur;

        //Calcul de la clé
        $sommePaire= 0; $sommeImPaire=0;
        for($indice=0; $indice<strlen($numeroNINEA);$indice++){
            $val=substr($numeroNINEA,$indice,1);

            if((($indice+1)%2)==0){
                $sommePaire+= (int)($val);
            }
            else{
                $sommeImPaire+= (int)($val);
            }
        }

        $cle=(10-(($sommeImPaire+2*$sommePaire)%10))%10;
        //$cle=fmod(10-fmod(($sommeImPaire-2*$sommePaire),10),10);
        $numeroNINEA=$numeroNINEA.$cle;
        return $numeroNINEA;
	}


    /**
	* Retourne le NINET
	*/
	public function genereNumNINET(EntityManagerInterface $entityManager, String $nineaMere) {
	    $numCompteur=0;

        //Génération de la sequence de 4 chiffres
        $ninets=$entityManager->getRepository(NINinea::class)->findBy(array("ninNineamere"=>$nineaMere));
        $nbNINET=count($ninets);

        $numCompteur= $nbNINET+1;

        $sNumCompteur=strval($numCompteur);
        $zeros="000";
        $zeros=substr($zeros,0,3-strlen($sNumCompteur));
        $numeroNINET=$nineaMere.$zeros.$sNumCompteur;
        $baseCalculCle=substr($numeroNINET,8,4);

        //Calcul de la clé
        $sommePaire= 0; $sommeImPaire=0;
        for($indice=0; $indice<strlen($baseCalculCle);$indice++){
            $val=substr($baseCalculCle,$indice,1);

            if((($indice+1)%2)==0){
                $sommePaire+= (int)($val);
            }
            else{
                $sommeImPaire+= (int)($val);
            }
        }

        $cle=(10-(($sommeImPaire+2*$sommePaire)%10))%10;
        //$cle=fmod(10-fmod(($sommeImPaire-2*$sommePaire),10),10);
        $numeroNINET=$numeroNINET.$cle;
        return $numeroNINET;
	}

}
