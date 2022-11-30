<?php

namespace App\Repository;

use App\Entity\NINinea;
use DateTime;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NINinea|null find($id, $lockMode = null, $lockVersion = null)
 * @method NINinea|null findOneBy(array $criteria, array $orderBy = null)
 * @method NINinea[]    findAll()
 * @method NINinea[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NINineaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NINinea::class);
    }


    public function findPersonneEteRaison($raison)
    {
        $query = $this->createQueryBuilder('n')
        ->innerJoin('n.niPersonne', 'p')
        ->addSelect('p')
        ->andWhere('p.ninRaison = :raison')
        ->setParameter('raison', $raison)
        ->getQuery()
        ->getResult();

        return $query;
    }


    public function findNINEAsup($ninea)
    {

        return $this->createQueryBuilder('n')
        ->andWhere('n.ninNinea > :ninea')
        ->innerJoin('n.ninStatut', 's')
        ->addSelect('s')
        ->andWhere('s.id = 1')
        ->setParameter('ninea', $ninea)
        ->getQuery()
        ->getResult() ;   
    }

    public function findNINETsup($ninet)
    {
        
        return $this->createQueryBuilder('n')
        ->andWhere('n.ninNinea > :ninet')
        ->innerJoin('n.ninStatut', 's')
        ->addSelect('s')
        ->andWhere('s.id = 2')
        ->setParameter('ninet', $ninet)
        ->getQuery()
        ->getResult() ;   
    }

    public function findDirigeantByNinea($cni,$ind, $idDemande)
    {
        $query = $this->createQueryBuilder('n')
        ->innerJoin('n.ninDirigeant', 'p')
        ->addSelect('p')
        ->innerJoin('p.ninNationalite', 'na')
        ->addSelect('na')
        ->innerJoin('p.ninNineaProposition', 'ninp')
        ->addSelect('ninp')
        ->andWhere('p.ninCni LIKE :cni')
        ->setParameter('cni', $cni)
        ->andWhere('na.id = :ind')
        ->setParameter('ind', $ind)
        ->andWhere('ninp.id = :idDemande')
        ->setParameter('idDemande', $idDemande)
        ->getQuery()
        ->getResult();

        return $query;
    }


    public function findPersonneEteSigle($sigle)
    {
        $query = $this->createQueryBuilder('n')
        ->innerJoin('n.niPersonne', 'p')
        ->addSelect('p')
        ->andWhere('p.ninSigle = :sigle')
        ->setParameter('sigle', $sigle)
        ->getQuery()
        ->getResult();

        return $query;
    }


    public function findNineaPersonnephysique($numNinea,$nineaMere, $raison,$datenais, $enseigne)
    {
        $query= $this->createQueryBuilder('n')
        ->innerJoin('n.formeJuridique', 'f')
        ->addSelect('f')
        ->innerJoin('f.niFormeunite', 'fo')
        ->addSelect('fo')       
        ->andWhere('fo.id = :var1 or fo.id = :var2 ')
        ->setParameter('var1', 11)
        ->setParameter('var2', 12)
        ->andWhere(' LENGTH(n.ninNinea ) < 13')
        ->innerJoin('n.niPersonne', 'p')
        ->innerJoin('n.niCoordonnees', 'c')
        ->addSelect('p')
        ->addSelect('c');

        if($numNinea){
        $query = $query
        ->andWhere('n.ninNinea  LIKE :numero')
        ->setParameter('numero', $numNinea.'%');
        }

        if($nineaMere){
        $query = $query
        ->andWhere('n.ninNineamere = :nineamere')
        ->setParameter('nineamere', $nineaMere);
        }

        if($raison){
        $query = $query
        ->andWhere('UPPER(                 
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(            
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(          
        REPLACE(         
        REPLACE(         
        REPLACE(         
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(       
        REPLACE(p.ninRaison  
        , \'é\' , \'e\')
        , \'è\' , \'e\') 
        , \'ê\', \'e\')
        , \'ë\', \'e\')
        , \'ÿ\', \'y\')
        , \'ç\' , \'c\')  
        , \'à\' , \'a\')
        , \'ä\' , \'a\') 
        , \'á\' , \'a\')
        , \'ã\', \'a\')
        , \'å\', \'a\')
        , \'â\' , \'a\')   
        , \'ù\' , \'u\')    
        , \'â\' , \'a\')     
        , \'ê\' , \'e\')      
        , \'î\' , \'i\') 
        , \'î\', \'i\')
        , \'ï\', \'i\')
        , \'ì\', \'i\')      
        , \'ô\' , \'o\')
        , \'ö\', \'o\')
        , \'ò\', \'o\')
        , \'ó\', \'o\')
        , \'û\' , \'u\')
        , \'ù\', \'u\')
        , \'ü\', \'u\')
        , \'ú\', \'u\')
        , \'ñ\', \'n\') 
        , \'À\', \'A\')
        , \'Â\', \'A\')
        , \'Ä\', \'A\')
        , \'Á\', \'A\')
        , \'Î\', \'I\')
        , \'Ï\', \'I\')
        , \'Ì\', \'I\')
        , \'Í\', \'I\')
        , \'É\', \'E\')
        , \'È\', \'E\')
        , \'Ê\', \'E\')
        , \'Ë\', \'E\')


        ) LIKE :raison or UPPER(                 
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(            
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(          
        REPLACE(         
        REPLACE(         
        REPLACE(         
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(       
        REPLACE(p.ninPrenom  
        , \'é\' , \'e\')
        , \'è\' , \'e\') 
        , \'ê\', \'e\')
        , \'ë\', \'e\')
        , \'ÿ\', \'y\')
        , \'ç\' , \'c\')  
        , \'à\' , \'a\')
        , \'ä\' , \'a\') 
        , \'á\' , \'a\')
        , \'ã\', \'a\')
        , \'å\', \'a\')
        , \'â\' , \'a\')   
        , \'ù\' , \'u\')    
        , \'â\' , \'a\')     
        , \'ê\' , \'e\')      
        , \'î\' , \'i\') 
        , \'î\', \'i\')
        , \'ï\', \'i\')
        , \'ì\', \'i\')      
        , \'ô\' , \'o\')
        , \'ö\', \'o\')
        , \'ò\', \'o\')
        , \'ó\', \'o\')
        , \'û\' , \'u\')
        , \'ù\', \'u\')
        , \'ü\', \'u\')
        , \'ú\', \'u\')
        , \'ñ\', \'n\') 
        , \'À\', \'A\')
        , \'Â\', \'A\')
        , \'Ä\', \'A\')
        , \'Á\', \'A\')
        , \'Î\', \'I\')
        , \'Ï\', \'I\')
        , \'Ì\', \'I\')
        , \'Í\', \'I\')
        , \'É\', \'E\')
        , \'È\', \'E\')
        , \'Ê\', \'E\')
        , \'Ë\', \'E\')        
        )  LIKE :raison or UPPER(                 
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(            
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(          
        REPLACE(         
        REPLACE(         
        REPLACE(         
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(       
        REPLACE(p.ninNom  
        , \'é\' , \'e\')
        , \'è\' , \'e\') 
        , \'ê\', \'e\')
        , \'ë\', \'e\')
        , \'ÿ\', \'y\')
        , \'ç\' , \'c\')  
        , \'à\' , \'a\')
        , \'ä\' , \'a\') 
        , \'á\' , \'a\')
        , \'ã\', \'a\')
        , \'å\', \'a\')
        , \'â\' , \'a\')   
        , \'ù\' , \'u\')    
        , \'â\' , \'a\')     
        , \'ê\' , \'e\')      
        , \'î\' , \'i\') 
        , \'î\', \'i\')
        , \'ï\', \'i\')
        , \'ì\', \'i\')      
        , \'ô\' , \'o\')
        , \'ö\', \'o\')
        , \'ò\', \'o\')
        , \'ó\', \'o\')
        , \'û\' , \'u\')
        , \'ù\', \'u\')
        , \'ü\', \'u\')
        , \'ú\', \'u\')
        , \'ñ\', \'n\') 
        , \'À\', \'A\')
        , \'Â\', \'A\')
        , \'Ä\', \'A\')
        , \'Á\', \'A\')
        , \'Î\', \'I\')
        , \'Ï\', \'I\')
        , \'Ì\', \'I\')
        , \'Í\', \'I\')
        , \'É\', \'E\')
        , \'È\', \'E\')
        , \'Ê\', \'E\')
        , \'Ë\', \'E\')        
        )  LIKE :raison or CONCAT(UPPER(                 
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(            
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(          
        REPLACE(         
        REPLACE(         
        REPLACE(         
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(       
        REPLACE(p.ninPrenom  
        , \'é\' , \'e\')
        , \'è\' , \'e\') 
        , \'ê\', \'e\')
        , \'ë\', \'e\')
        , \'ÿ\', \'y\')
        , \'ç\' , \'c\')  
        , \'à\' , \'a\')
        , \'ä\' , \'a\') 
        , \'á\' , \'a\')
        , \'ã\', \'a\')
        , \'å\', \'a\')
        , \'â\' , \'a\')   
        , \'ù\' , \'u\')    
        , \'â\' , \'a\')     
        , \'ê\' , \'e\')      
        , \'î\' , \'i\') 
        , \'î\', \'i\')
        , \'ï\', \'i\')
        , \'ì\', \'i\')      
        , \'ô\' , \'o\')
        , \'ö\', \'o\')
        , \'ò\', \'o\')
        , \'ó\', \'o\')
        , \'û\' , \'u\')
        , \'ù\', \'u\')
        , \'ü\', \'u\')
        , \'ú\', \'u\')
        , \'ñ\', \'n\') 
        , \'À\', \'A\')
        , \'Â\', \'A\')
        , \'Ä\', \'A\')
        , \'Á\', \'A\')
        , \'Î\', \'I\')
        , \'Ï\', \'I\')
        , \'Ì\', \'I\')
        , \'Í\', \'I\')
        , \'É\', \'E\')
        , \'È\', \'E\')
        , \'Ê\', \'E\')
        , \'Ë\', \'E\')        
        )  ,\' \',UPPER(                 
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(            
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(          
        REPLACE(         
        REPLACE(         
        REPLACE(         
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(       
        REPLACE(p.ninNom  
        , \'é\' , \'e\')
        , \'è\' , \'e\') 
        , \'ê\', \'e\')
        , \'ë\', \'e\')
        , \'ÿ\', \'y\')
        , \'ç\' , \'c\')  
        , \'à\' , \'a\')
        , \'ä\' , \'a\') 
        , \'á\' , \'a\')
        , \'ã\', \'a\')
        , \'å\', \'a\')
        , \'â\' , \'a\')   
        , \'ù\' , \'u\')    
        , \'â\' , \'a\')     
        , \'ê\' , \'e\')      
        , \'î\' , \'i\') 
        , \'î\', \'i\')
        , \'ï\', \'i\')
        , \'ì\', \'i\')      
        , \'ô\' , \'o\')
        , \'ö\', \'o\')
        , \'ò\', \'o\')
        , \'ó\', \'o\')
        , \'û\' , \'u\')
        , \'ù\', \'u\')
        , \'ü\', \'u\')
        , \'ú\', \'u\')
        , \'ñ\', \'n\') 
        , \'À\', \'A\')
        , \'Â\', \'A\')
        , \'Ä\', \'A\')
        , \'Á\', \'A\')
        , \'Î\', \'I\')
        , \'Ï\', \'I\')
        , \'Ì\', \'I\')
        , \'Í\', \'I\')
        , \'É\', \'E\')
        , \'È\', \'E\')
        , \'Ê\', \'E\')
        , \'Ë\', \'E\')        
        )  ) LIKE :raison or CONCAT(UPPER(                 
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(            
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(          
        REPLACE(         
        REPLACE(         
        REPLACE(         
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(       
        REPLACE(p.ninNom  
        , \'é\' , \'e\')
        , \'è\' , \'e\') 
        , \'ê\', \'e\')
        , \'ë\', \'e\')
        , \'ÿ\', \'y\')
        , \'ç\' , \'c\')  
        , \'à\' , \'a\')
        , \'ä\' , \'a\') 
        , \'á\' , \'a\')
        , \'ã\', \'a\')
        , \'å\', \'a\')
        , \'â\' , \'a\')   
        , \'ù\' , \'u\')    
        , \'â\' , \'a\')     
        , \'ê\' , \'e\')      
        , \'î\' , \'i\') 
        , \'î\', \'i\')
        , \'ï\', \'i\')
        , \'ì\', \'i\')      
        , \'ô\' , \'o\')
        , \'ö\', \'o\')
        , \'ò\', \'o\')
        , \'ó\', \'o\')
        , \'û\' , \'u\')
        , \'ù\', \'u\')
        , \'ü\', \'u\')
        , \'ú\', \'u\')
        , \'ñ\', \'n\') 
        , \'À\', \'A\')
        , \'Â\', \'A\')
        , \'Ä\', \'A\')
        , \'Á\', \'A\')
        , \'Î\', \'I\')
        , \'Ï\', \'I\')
        , \'Ì\', \'I\')
        , \'Í\', \'I\')
        , \'É\', \'E\')
        , \'È\', \'E\')
        , \'Ê\', \'E\')
        , \'Ë\', \'E\')        
        )  ,\' \',UPPER(                 
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(            
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(          
        REPLACE(         
        REPLACE(         
        REPLACE(         
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(       
        REPLACE(p.ninNom  
        , \'é\' , \'e\')
        , \'è\' , \'e\') 
        , \'ê\', \'e\')
        , \'ë\', \'e\')
        , \'ÿ\', \'y\')
        , \'ç\' , \'c\')  
        , \'à\' , \'a\')
        , \'ä\' , \'a\') 
        , \'á\' , \'a\')
        , \'ã\', \'a\')
        , \'å\', \'a\')
        , \'â\' , \'a\')   
        , \'ù\' , \'u\')    
        , \'â\' , \'a\')     
        , \'ê\' , \'e\')      
        , \'î\' , \'i\') 
        , \'î\', \'i\')
        , \'ï\', \'i\')
        , \'ì\', \'i\')      
        , \'ô\' , \'o\')
        , \'ö\', \'o\')
        , \'ò\', \'o\')
        , \'ó\', \'o\')
        , \'û\' , \'u\')
        , \'ù\', \'u\')
        , \'ü\', \'u\')
        , \'ú\', \'u\')
        , \'ñ\', \'n\') 
        , \'À\', \'A\')
        , \'Â\', \'A\')
        , \'Ä\', \'A\')
        , \'Á\', \'A\')
        , \'Î\', \'I\')
        , \'Ï\', \'I\')
        , \'Ì\', \'I\')
        , \'Í\', \'I\')
        , \'É\', \'E\')
        , \'È\', \'E\')
        , \'Ê\', \'E\')
        , \'Ë\', \'E\')        
        ) ) LIKE :raison ')
        ->setParameter('raison',  '%'.$this->enleveacc($raison).'%');

        }  

        if($datenais){
        $query = $query
        ->andWhere('p.ninDateNaissance = :date')
        ->setParameter('date', $datenais);
        }  

        if($enseigne){
        $query = $query
        ->andWhere('UPPER(                 
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(            
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(          
        REPLACE(         
        REPLACE(         
        REPLACE(         
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(       
        REPLACE(p.ninEnseigne  
        , \'é\' , \'e\')
        , \'è\' , \'e\') 
        , \'ê\', \'e\')
        , \'ë\', \'e\')
        , \'ÿ\', \'y\')
        , \'ç\' , \'c\')  
        , \'à\' , \'a\')
        , \'ä\' , \'a\') 
        , \'á\' , \'a\')
        , \'ã\', \'a\')
        , \'å\', \'a\')
        , \'â\' , \'a\')   
        , \'ù\' , \'u\')    
        , \'â\' , \'a\')     
        , \'ê\' , \'e\')      
        , \'î\' , \'i\') 
        , \'î\', \'i\')
        , \'ï\', \'i\')
        , \'ì\', \'i\')      
        , \'ô\' , \'o\')
        , \'ö\', \'o\')
        , \'ò\', \'o\')
        , \'ó\', \'o\')
        , \'û\' , \'u\')
        , \'ù\', \'u\')
        , \'ü\', \'u\')
        , \'ú\', \'u\')
        , \'ñ\', \'n\') 
        , \'À\', \'A\')
        , \'Â\', \'A\')
        , \'Ä\', \'A\')
        , \'Á\', \'A\')
        , \'Î\', \'I\')
        , \'Ï\', \'I\')
        , \'Ì\', \'I\')
        , \'Í\', \'I\')
        , \'É\', \'E\')
        , \'È\', \'E\')
        , \'Ê\', \'E\')
        , \'Ë\', \'E\')        
        )  LIKE  :enseigne')
        ->setParameter('enseigne', '%'.$this->enleveacc($enseigne).'%');
        }  


        $query = $query  
        ->orderBy('n.ninNinea', 'DESC')
        ->setMaxResults(80)
        ->getQuery()
        ->getResult();

        return $query;

    }

    
    public function findNineaPersonnemorale($numNinea,$nineaMere, $raison,$datenais, $enseigne)
    {
        $query= $this->createQueryBuilder('n')
        ->innerJoin('n.formeJuridique', 'f')
        ->addSelect('f')
        ->innerJoin('f.niFormeunite', 'fo')
        ->addSelect('fo')       
        ->andWhere('fo.id != :var1 and fo.id != :var2 ')
        ->setParameter('var1', 11)
        ->setParameter('var2', 12)
        ->andWhere(' LENGTH(n.ninNinea ) < 13')
        ->innerJoin('n.niPersonne', 'p')
        ->innerJoin('n.niCoordonnees', 'c')
        ->addSelect('p')
        ->addSelect('c');

        if($numNinea){
        $query = $query
        ->andWhere('n.ninNinea  LIKE :numero')
        ->setParameter('numero', $numNinea.'%');
        }

        if($nineaMere){
        $query = $query
        ->andWhere('n.ninNineamere = :nineamere')
        ->setParameter('nineamere', $nineaMere);
        }

        if($raison){
        $query = $query
        ->andWhere('UPPER(                 
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(            
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(          
        REPLACE(         
        REPLACE(         
        REPLACE(         
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(       
        REPLACE(p.ninRaison  
        , \'é\' , \'e\')
        , \'è\' , \'e\') 
        , \'ê\', \'e\')
        , \'ë\', \'e\')
        , \'ÿ\', \'y\')
        , \'ç\' , \'c\')  
        , \'à\' , \'a\')
        , \'ä\' , \'a\') 
        , \'á\' , \'a\')
        , \'ã\', \'a\')
        , \'å\', \'a\')
        , \'â\' , \'a\')   
        , \'ù\' , \'u\')    
        , \'â\' , \'a\')     
        , \'ê\' , \'e\')      
        , \'î\' , \'i\') 
        , \'î\', \'i\')
        , \'ï\', \'i\')
        , \'ì\', \'i\')      
        , \'ô\' , \'o\')
        , \'ö\', \'o\')
        , \'ò\', \'o\')
        , \'ó\', \'o\')
        , \'û\' , \'u\')
        , \'ù\', \'u\')
        , \'ü\', \'u\')
        , \'ú\', \'u\')
        , \'ñ\', \'n\') 
        , \'À\', \'A\')
        , \'Â\', \'A\')
        , \'Ä\', \'A\')
        , \'Á\', \'A\')
        , \'Î\', \'I\')
        , \'Ï\', \'I\')
        , \'Ì\', \'I\')
        , \'Í\', \'I\')
        , \'É\', \'E\')
        , \'È\', \'E\')
        , \'Ê\', \'E\')
        , \'Ë\', \'E\')


        ) LIKE :raison or UPPER(                 
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(            
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(          
        REPLACE(         
        REPLACE(         
        REPLACE(         
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(       
        REPLACE(p.ninPrenom  
        , \'é\' , \'e\')
        , \'è\' , \'e\') 
        , \'ê\', \'e\')
        , \'ë\', \'e\')
        , \'ÿ\', \'y\')
        , \'ç\' , \'c\')  
        , \'à\' , \'a\')
        , \'ä\' , \'a\') 
        , \'á\' , \'a\')
        , \'ã\', \'a\')
        , \'å\', \'a\')
        , \'â\' , \'a\')   
        , \'ù\' , \'u\')    
        , \'â\' , \'a\')     
        , \'ê\' , \'e\')      
        , \'î\' , \'i\') 
        , \'î\', \'i\')
        , \'ï\', \'i\')
        , \'ì\', \'i\')      
        , \'ô\' , \'o\')
        , \'ö\', \'o\')
        , \'ò\', \'o\')
        , \'ó\', \'o\')
        , \'û\' , \'u\')
        , \'ù\', \'u\')
        , \'ü\', \'u\')
        , \'ú\', \'u\')
        , \'ñ\', \'n\') 
        , \'À\', \'A\')
        , \'Â\', \'A\')
        , \'Ä\', \'A\')
        , \'Á\', \'A\')
        , \'Î\', \'I\')
        , \'Ï\', \'I\')
        , \'Ì\', \'I\')
        , \'Í\', \'I\')
        , \'É\', \'E\')
        , \'È\', \'E\')
        , \'Ê\', \'E\')
        , \'Ë\', \'E\')        
        )  LIKE :raison or UPPER(                 
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(            
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(          
        REPLACE(         
        REPLACE(         
        REPLACE(         
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(       
        REPLACE(p.ninNom  
        , \'é\' , \'e\')
        , \'è\' , \'e\') 
        , \'ê\', \'e\')
        , \'ë\', \'e\')
        , \'ÿ\', \'y\')
        , \'ç\' , \'c\')  
        , \'à\' , \'a\')
        , \'ä\' , \'a\') 
        , \'á\' , \'a\')
        , \'ã\', \'a\')
        , \'å\', \'a\')
        , \'â\' , \'a\')   
        , \'ù\' , \'u\')    
        , \'â\' , \'a\')     
        , \'ê\' , \'e\')      
        , \'î\' , \'i\') 
        , \'î\', \'i\')
        , \'ï\', \'i\')
        , \'ì\', \'i\')      
        , \'ô\' , \'o\')
        , \'ö\', \'o\')
        , \'ò\', \'o\')
        , \'ó\', \'o\')
        , \'û\' , \'u\')
        , \'ù\', \'u\')
        , \'ü\', \'u\')
        , \'ú\', \'u\')
        , \'ñ\', \'n\') 
        , \'À\', \'A\')
        , \'Â\', \'A\')
        , \'Ä\', \'A\')
        , \'Á\', \'A\')
        , \'Î\', \'I\')
        , \'Ï\', \'I\')
        , \'Ì\', \'I\')
        , \'Í\', \'I\')
        , \'É\', \'E\')
        , \'È\', \'E\')
        , \'Ê\', \'E\')
        , \'Ë\', \'E\')        
        )  LIKE :raison or CONCAT(UPPER(                 
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(            
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(          
        REPLACE(         
        REPLACE(         
        REPLACE(         
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(       
        REPLACE(p.ninPrenom  
        , \'é\' , \'e\')
        , \'è\' , \'e\') 
        , \'ê\', \'e\')
        , \'ë\', \'e\')
        , \'ÿ\', \'y\')
        , \'ç\' , \'c\')  
        , \'à\' , \'a\')
        , \'ä\' , \'a\') 
        , \'á\' , \'a\')
        , \'ã\', \'a\')
        , \'å\', \'a\')
        , \'â\' , \'a\')   
        , \'ù\' , \'u\')    
        , \'â\' , \'a\')     
        , \'ê\' , \'e\')      
        , \'î\' , \'i\') 
        , \'î\', \'i\')
        , \'ï\', \'i\')
        , \'ì\', \'i\')      
        , \'ô\' , \'o\')
        , \'ö\', \'o\')
        , \'ò\', \'o\')
        , \'ó\', \'o\')
        , \'û\' , \'u\')
        , \'ù\', \'u\')
        , \'ü\', \'u\')
        , \'ú\', \'u\')
        , \'ñ\', \'n\') 
        , \'À\', \'A\')
        , \'Â\', \'A\')
        , \'Ä\', \'A\')
        , \'Á\', \'A\')
        , \'Î\', \'I\')
        , \'Ï\', \'I\')
        , \'Ì\', \'I\')
        , \'Í\', \'I\')
        , \'É\', \'E\')
        , \'È\', \'E\')
        , \'Ê\', \'E\')
        , \'Ë\', \'E\')        
        )  ,\' \',UPPER(                 
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(            
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(          
        REPLACE(         
        REPLACE(         
        REPLACE(         
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(       
        REPLACE(p.ninNom  
        , \'é\' , \'e\')
        , \'è\' , \'e\') 
        , \'ê\', \'e\')
        , \'ë\', \'e\')
        , \'ÿ\', \'y\')
        , \'ç\' , \'c\')  
        , \'à\' , \'a\')
        , \'ä\' , \'a\') 
        , \'á\' , \'a\')
        , \'ã\', \'a\')
        , \'å\', \'a\')
        , \'â\' , \'a\')   
        , \'ù\' , \'u\')    
        , \'â\' , \'a\')     
        , \'ê\' , \'e\')      
        , \'î\' , \'i\') 
        , \'î\', \'i\')
        , \'ï\', \'i\')
        , \'ì\', \'i\')      
        , \'ô\' , \'o\')
        , \'ö\', \'o\')
        , \'ò\', \'o\')
        , \'ó\', \'o\')
        , \'û\' , \'u\')
        , \'ù\', \'u\')
        , \'ü\', \'u\')
        , \'ú\', \'u\')
        , \'ñ\', \'n\') 
        , \'À\', \'A\')
        , \'Â\', \'A\')
        , \'Ä\', \'A\')
        , \'Á\', \'A\')
        , \'Î\', \'I\')
        , \'Ï\', \'I\')
        , \'Ì\', \'I\')
        , \'Í\', \'I\')
        , \'É\', \'E\')
        , \'È\', \'E\')
        , \'Ê\', \'E\')
        , \'Ë\', \'E\')        
        )  ) LIKE :raison or CONCAT(UPPER(                 
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(            
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(          
        REPLACE(         
        REPLACE(         
        REPLACE(         
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(       
        REPLACE(p.ninNom  
        , \'é\' , \'e\')
        , \'è\' , \'e\') 
        , \'ê\', \'e\')
        , \'ë\', \'e\')
        , \'ÿ\', \'y\')
        , \'ç\' , \'c\')  
        , \'à\' , \'a\')
        , \'ä\' , \'a\') 
        , \'á\' , \'a\')
        , \'ã\', \'a\')
        , \'å\', \'a\')
        , \'â\' , \'a\')   
        , \'ù\' , \'u\')    
        , \'â\' , \'a\')     
        , \'ê\' , \'e\')      
        , \'î\' , \'i\') 
        , \'î\', \'i\')
        , \'ï\', \'i\')
        , \'ì\', \'i\')      
        , \'ô\' , \'o\')
        , \'ö\', \'o\')
        , \'ò\', \'o\')
        , \'ó\', \'o\')
        , \'û\' , \'u\')
        , \'ù\', \'u\')
        , \'ü\', \'u\')
        , \'ú\', \'u\')
        , \'ñ\', \'n\') 
        , \'À\', \'A\')
        , \'Â\', \'A\')
        , \'Ä\', \'A\')
        , \'Á\', \'A\')
        , \'Î\', \'I\')
        , \'Ï\', \'I\')
        , \'Ì\', \'I\')
        , \'Í\', \'I\')
        , \'É\', \'E\')
        , \'È\', \'E\')
        , \'Ê\', \'E\')
        , \'Ë\', \'E\')        
        )  ,\' \',UPPER(                 
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(            
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(          
        REPLACE(         
        REPLACE(         
        REPLACE(         
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(       
        REPLACE(p.ninNom  
        , \'é\' , \'e\')
        , \'è\' , \'e\') 
        , \'ê\', \'e\')
        , \'ë\', \'e\')
        , \'ÿ\', \'y\')
        , \'ç\' , \'c\')  
        , \'à\' , \'a\')
        , \'ä\' , \'a\') 
        , \'á\' , \'a\')
        , \'ã\', \'a\')
        , \'å\', \'a\')
        , \'â\' , \'a\')   
        , \'ù\' , \'u\')    
        , \'â\' , \'a\')     
        , \'ê\' , \'e\')      
        , \'î\' , \'i\') 
        , \'î\', \'i\')
        , \'ï\', \'i\')
        , \'ì\', \'i\')      
        , \'ô\' , \'o\')
        , \'ö\', \'o\')
        , \'ò\', \'o\')
        , \'ó\', \'o\')
        , \'û\' , \'u\')
        , \'ù\', \'u\')
        , \'ü\', \'u\')
        , \'ú\', \'u\')
        , \'ñ\', \'n\') 
        , \'À\', \'A\')
        , \'Â\', \'A\')
        , \'Ä\', \'A\')
        , \'Á\', \'A\')
        , \'Î\', \'I\')
        , \'Ï\', \'I\')
        , \'Ì\', \'I\')
        , \'Í\', \'I\')
        , \'É\', \'E\')
        , \'È\', \'E\')
        , \'Ê\', \'E\')
        , \'Ë\', \'E\')        
        ) ) LIKE :raison ')
        ->setParameter('raison',  '%'.$this->enleveacc($raison).'%');

        }  

        if($datenais){
        $query = $query
        ->andWhere('p.ninDateNaissance = :date')
        ->setParameter('date', $datenais);
        }  

        if($enseigne){
        $query = $query
        ->andWhere('UPPER(                 
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(              
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(             
        REPLACE(            
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(           
        REPLACE(          
        REPLACE(         
        REPLACE(         
        REPLACE(         
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(        
        REPLACE(       
        REPLACE(p.ninEnseigne  
        , \'é\' , \'e\')
        , \'è\' , \'e\') 
        , \'ê\', \'e\')
        , \'ë\', \'e\')
        , \'ÿ\', \'y\')
        , \'ç\' , \'c\')  
        , \'à\' , \'a\')
        , \'ä\' , \'a\') 
        , \'á\' , \'a\')
        , \'ã\', \'a\')
        , \'å\', \'a\')
        , \'â\' , \'a\')   
        , \'ù\' , \'u\')    
        , \'â\' , \'a\')     
        , \'ê\' , \'e\')      
        , \'î\' , \'i\') 
        , \'î\', \'i\')
        , \'ï\', \'i\')
        , \'ì\', \'i\')      
        , \'ô\' , \'o\')
        , \'ö\', \'o\')
        , \'ò\', \'o\')
        , \'ó\', \'o\')
        , \'û\' , \'u\')
        , \'ù\', \'u\')
        , \'ü\', \'u\')
        , \'ú\', \'u\')
        , \'ñ\', \'n\') 
        , \'À\', \'A\')
        , \'Â\', \'A\')
        , \'Ä\', \'A\')
        , \'Á\', \'A\')
        , \'Î\', \'I\')
        , \'Ï\', \'I\')
        , \'Ì\', \'I\')
        , \'Í\', \'I\')
        , \'É\', \'E\')
        , \'È\', \'E\')
        , \'Ê\', \'E\')
        , \'Ë\', \'E\')        
        )  LIKE  :enseigne')
        ->setParameter('enseigne', '%'.$this->enleveacc($enseigne).'%');
        }  


        $query = $query  
        ->orderBy('n.ninNinea', 'DESC')
        ->setMaxResults(80)
        ->getQuery()
        ->getResult();

        return $query;

    }

  



    function enleveacc($mot) {
        return str_replace(
            array(
                'à', 'â', 'ä', 'á', 'ã', 'å',
                'î', 'ï', 'ì', 'í',
                'ô', 'ö', 'ò', 'ó', 'õ', 'ø',
                'ù', 'û', 'ü', 'ú',
                'é', 'è', 'ê', 'ë',
                'ç', 'ÿ', 'ñ',
                'À', 'Â', 'Ä', 'Á', 'Ã', 'Å',
                'Î', 'Ï', 'Ì', 'Í',
                'Ô', 'Ö', 'Ò', 'Ó', 'Õ', 'Ø',
                'Ù', 'Û', 'Ü', 'Ú',
                'É', 'È', 'Ê', 'Ë',
                'Ç', 'Ÿ', 'Ñ'
            ),
            array(
                'a', 'a', 'a', 'a', 'a', 'a',
                'i', 'i', 'i', 'i',
                'o', 'o', 'o', 'o', 'o', 'o',
                'u', 'u', 'u', 'u',
                'e', 'e', 'e', 'e',
                'c', 'y', 'n',
                'A', 'A', 'A', 'A', 'A', 'A',
                'I', 'I', 'I', 'I',
                'O', 'O', 'O', 'O', 'O', 'O',
                'U', 'U', 'U', 'U',
                'E', 'E', 'E', 'E',
                'C', 'Y', 'N'
            ),strtoupper($mot));
    }


    // /**
    //  * @return NINinea[] Returns an array of NINinea objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function eleverlesaccent($chaine){
                     
        return  REPLACE(              
             REPLACE(             
              REPLACE(            
               REPLACE(           
                REPLACE(          
                 REPLACE(         
                  REPLACE(        
                   REPLACE(       
                    REPLACE(      
                     REPLACE($chaine  
                     , "é" , "e" )
                    , "è" , "e" ) 
                   , "ç" , "c" )  
                  , "à" , "a" )   
                 , "ù" , "u" )    
                , "â" , "a" )     
               , "ê" , "e" )      
              , "î" , "i" )       
             , "ô" , "o" )        
            , "û" , "u" )         
           ; 
    }

    public function findNinea($ninea)
    {
        {
            $query = $this->createQueryBuilder('n')
                ->andWhere('n.ninNinea LIKE :ninea')
                ->setParameter('ninea', $ninea.'%')
                ->getQuery()
                ->getResult();

            return $query;
        }
    }


    public function findPersonneEtrangerByNinea($cni,$ind)
    {
        $query = $this->createQueryBuilder('n')
        ->innerJoin('n.niPersonne', 'p')
        ->addSelect('p')
        ->innerJoin('p.nationalite', 'na')
        ->addSelect('na')
        ->andWhere('p.ninCNI LIKE :cni')
        ->setParameter('cni', $cni)
        ->andWhere('na.id = :ind')
        ->setParameter('ind', $ind)
        ->getQuery()
        ->getResult();

        return $query;
    }


    public function findDirigeantEtrangerByNinea($cni,$ind)
    {
        $query = $this->createQueryBuilder('n')
        ->innerJoin('n.ninDirigeant', 'p')
        ->addSelect('p')
        ->innerJoin('p.ninNationalite', 'na')
        ->addSelect('na')
        ->andWhere('p.ninCni LIKE :cni')
        ->setParameter('cni', $cni)
        ->andWhere('na.id = :ind')
        ->setParameter('ind', $ind)
        ->getQuery()
        ->getResult();

        return $query;
    }

    public function findPersonneByNinea($cni)
    {
        $query = $this->createQueryBuilder('n')
        ->innerJoin('n.niPersonne', 'p')
        ->addSelect('p')
        ->andWhere('p.ninCNI LIKE :cni')
        ->setParameter('cni', $cni)
        ->getQuery()
        ->getResult();

        return $query;
    }

    public function findninRegcom($ninRegcom)
    {
        $query = $this->createQueryBuilder('n')
        
        ->andWhere('UPPER(REPLACE(REPLACE(n.ninNumeroDocument,\' \',\'\'),\'_\',\' \')) = :ninRegcom')
        ->setParameter('ninRegcom',str_replace("_","",str_replace(" ","",$ninRegcom)))
        ->getQuery()
        ->getResult();

        return $query;
    }


    public function findETSByNineamere($ninea)
    {
        {
            $query = $this->createQueryBuilder('n')
                ->andWhere('n.ninNinea LIKE :ninea')
                ->andWhere('n.ninNinea  <> :ninea1')
                ->setParameter('ninea', $ninea.'%')
                ->setParameter('ninea1', $ninea)
                ->getQuery()
                ->getResult();

            return $query;
        }
    }

    public function findByField($numNinea,$nineaMere, $raison,$datenais, $enseigne, $cni,
                                $numReg, $dateReg,$sigle, $telephone, $email,$adresse)
    {
        $query= $this->createQueryBuilder('n')
               ->innerJoin('n.niPersonne', 'p')
               ->leftJoin('n.niCoordonnees', 'c')
               ->addSelect('p')
               ->addSelect('c');

       if($numNinea){
        $query = $query
            ->andWhere('n.ninNinea  LIKE :numero')
            ->setParameter('numero', $numNinea.'%');
       }

       if($nineaMere){
            $query = $query
            ->andWhere('n.ninNineamere = :nineamere')
            ->setParameter('nineamere', $nineaMere);
       }


       

       if($raison){
        $query = $query
        ->andWhere('UPPER(                 
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(            
            REPLACE(           
            REPLACE(           
            REPLACE(           
            REPLACE(           
            REPLACE(          
            REPLACE(         
            REPLACE(         
            REPLACE(         
            REPLACE(        
            REPLACE(        
            REPLACE(        
            REPLACE(        
            REPLACE(       
            REPLACE(p.ninRaison  
            , \'é\' , \'e\')
            , \'è\' , \'e\') 
            , \'ê\', \'e\')
            , \'ë\', \'e\')
            , \'ÿ\', \'y\')
            , \'ç\' , \'c\')  
            , \'à\' , \'a\')
            , \'ä\' , \'a\') 
            , \'á\' , \'a\')
            , \'ã\', \'a\')
            , \'å\', \'a\')
            , \'â\' , \'a\')   
            , \'ù\' , \'u\')    
            , \'â\' , \'a\')     
            , \'ê\' , \'e\')      
            , \'î\' , \'i\') 
            , \'î\', \'i\')
            , \'ï\', \'i\')
            , \'ì\', \'i\')      
            , \'ô\' , \'o\')
            , \'ö\', \'o\')
            , \'ò\', \'o\')
            , \'ó\', \'o\')
            , \'û\' , \'u\')
            , \'ù\', \'u\')
            , \'ü\', \'u\')
            , \'ú\', \'u\')
            , \'ñ\', \'n\') 
            , \'À\', \'A\')
            , \'Â\', \'A\')
            , \'Ä\', \'A\')
            , \'Á\', \'A\')
            , \'Î\', \'I\')
            , \'Ï\', \'I\')
            , \'Ì\', \'I\')
            , \'Í\', \'I\')
            , \'É\', \'E\')
            , \'È\', \'E\')
            , \'Ê\', \'E\')
            , \'Ë\', \'E\')
            
                    
           ) LIKE :raison or UPPER(                 
            REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(             
                REPLACE(             
                REPLACE(             
                REPLACE(             
                REPLACE(             
                REPLACE(             
                REPLACE(             
                REPLACE(            
                REPLACE(           
                REPLACE(           
                REPLACE(           
                REPLACE(           
                REPLACE(          
                REPLACE(         
                REPLACE(         
                REPLACE(         
                REPLACE(        
                REPLACE(        
                REPLACE(        
                REPLACE(        
                REPLACE(       
                REPLACE(p.ninPrenom  
                , \'é\' , \'e\')
                , \'è\' , \'e\') 
                , \'ê\', \'e\')
                , \'ë\', \'e\')
                , \'ÿ\', \'y\')
                , \'ç\' , \'c\')  
                , \'à\' , \'a\')
                , \'ä\' , \'a\') 
                , \'á\' , \'a\')
                , \'ã\', \'a\')
                , \'å\', \'a\')
                , \'â\' , \'a\')   
                , \'ù\' , \'u\')    
                , \'â\' , \'a\')     
                , \'ê\' , \'e\')      
                , \'î\' , \'i\') 
                , \'î\', \'i\')
                , \'ï\', \'i\')
                , \'ì\', \'i\')      
                , \'ô\' , \'o\')
                , \'ö\', \'o\')
                , \'ò\', \'o\')
                , \'ó\', \'o\')
                , \'û\' , \'u\')
                , \'ù\', \'u\')
                , \'ü\', \'u\')
                , \'ú\', \'u\')
                , \'ñ\', \'n\') 
                , \'À\', \'A\')
                , \'Â\', \'A\')
                , \'Ä\', \'A\')
                , \'Á\', \'A\')
                , \'Î\', \'I\')
                , \'Ï\', \'I\')
                , \'Ì\', \'I\')
                , \'Í\', \'I\')
                , \'É\', \'E\')
                , \'È\', \'E\')
                , \'Ê\', \'E\')
                , \'Ë\', \'E\')        
           )  LIKE :raison or UPPER(                 
               REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(             
                REPLACE(             
                REPLACE(             
                REPLACE(             
                REPLACE(             
                REPLACE(             
                REPLACE(             
                REPLACE(            
                REPLACE(           
                REPLACE(           
                REPLACE(           
                REPLACE(           
                REPLACE(          
                REPLACE(         
                REPLACE(         
                REPLACE(         
                REPLACE(        
                REPLACE(        
                REPLACE(        
                REPLACE(        
                REPLACE(       
                REPLACE(p.ninNom  
                , \'é\' , \'e\')
                , \'è\' , \'e\') 
                , \'ê\', \'e\')
                , \'ë\', \'e\')
                , \'ÿ\', \'y\')
                , \'ç\' , \'c\')  
                , \'à\' , \'a\')
                , \'ä\' , \'a\') 
                , \'á\' , \'a\')
                , \'ã\', \'a\')
                , \'å\', \'a\')
                , \'â\' , \'a\')   
                , \'ù\' , \'u\')    
                , \'â\' , \'a\')     
                , \'ê\' , \'e\')      
                , \'î\' , \'i\') 
                , \'î\', \'i\')
                , \'ï\', \'i\')
                , \'ì\', \'i\')      
                , \'ô\' , \'o\')
                , \'ö\', \'o\')
                , \'ò\', \'o\')
                , \'ó\', \'o\')
                , \'û\' , \'u\')
                , \'ù\', \'u\')
                , \'ü\', \'u\')
                , \'ú\', \'u\')
                , \'ñ\', \'n\') 
                , \'À\', \'A\')
                , \'Â\', \'A\')
                , \'Ä\', \'A\')
                , \'Á\', \'A\')
                , \'Î\', \'I\')
                , \'Ï\', \'I\')
                , \'Ì\', \'I\')
                , \'Í\', \'I\')
                , \'É\', \'E\')
                , \'È\', \'E\')
                , \'Ê\', \'E\')
                , \'Ë\', \'E\')        
           )  LIKE :raison or CONCAT(UPPER(                 
            REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(             
                REPLACE(             
                REPLACE(             
                REPLACE(             
                REPLACE(             
                REPLACE(             
                REPLACE(             
                REPLACE(            
                REPLACE(           
                REPLACE(           
                REPLACE(           
                REPLACE(           
                REPLACE(          
                REPLACE(         
                REPLACE(         
                REPLACE(         
                REPLACE(        
                REPLACE(        
                REPLACE(        
                REPLACE(        
                REPLACE(       
                REPLACE(p.ninPrenom  
                , \'é\' , \'e\')
                , \'è\' , \'e\') 
                , \'ê\', \'e\')
                , \'ë\', \'e\')
                , \'ÿ\', \'y\')
                , \'ç\' , \'c\')  
                , \'à\' , \'a\')
                , \'ä\' , \'a\') 
                , \'á\' , \'a\')
                , \'ã\', \'a\')
                , \'å\', \'a\')
                , \'â\' , \'a\')   
                , \'ù\' , \'u\')    
                , \'â\' , \'a\')     
                , \'ê\' , \'e\')      
                , \'î\' , \'i\') 
                , \'î\', \'i\')
                , \'ï\', \'i\')
                , \'ì\', \'i\')      
                , \'ô\' , \'o\')
                , \'ö\', \'o\')
                , \'ò\', \'o\')
                , \'ó\', \'o\')
                , \'û\' , \'u\')
                , \'ù\', \'u\')
                , \'ü\', \'u\')
                , \'ú\', \'u\')
                , \'ñ\', \'n\') 
                , \'À\', \'A\')
                , \'Â\', \'A\')
                , \'Ä\', \'A\')
                , \'Á\', \'A\')
                , \'Î\', \'I\')
                , \'Ï\', \'I\')
                , \'Ì\', \'I\')
                , \'Í\', \'I\')
                , \'É\', \'E\')
                , \'È\', \'E\')
                , \'Ê\', \'E\')
                , \'Ë\', \'E\')        
           )  ,\' \',UPPER(                 
            REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(             
                REPLACE(             
                REPLACE(             
                REPLACE(             
                REPLACE(             
                REPLACE(             
                REPLACE(             
                REPLACE(            
                REPLACE(           
                REPLACE(           
                REPLACE(           
                REPLACE(           
                REPLACE(          
                REPLACE(         
                REPLACE(         
                REPLACE(         
                REPLACE(        
                REPLACE(        
                REPLACE(        
                REPLACE(        
                REPLACE(       
                REPLACE(p.ninNom  
                , \'é\' , \'e\')
                , \'è\' , \'e\') 
                , \'ê\', \'e\')
                , \'ë\', \'e\')
                , \'ÿ\', \'y\')
                , \'ç\' , \'c\')  
                , \'à\' , \'a\')
                , \'ä\' , \'a\') 
                , \'á\' , \'a\')
                , \'ã\', \'a\')
                , \'å\', \'a\')
                , \'â\' , \'a\')   
                , \'ù\' , \'u\')    
                , \'â\' , \'a\')     
                , \'ê\' , \'e\')      
                , \'î\' , \'i\') 
                , \'î\', \'i\')
                , \'ï\', \'i\')
                , \'ì\', \'i\')      
                , \'ô\' , \'o\')
                , \'ö\', \'o\')
                , \'ò\', \'o\')
                , \'ó\', \'o\')
                , \'û\' , \'u\')
                , \'ù\', \'u\')
                , \'ü\', \'u\')
                , \'ú\', \'u\')
                , \'ñ\', \'n\') 
                , \'À\', \'A\')
                , \'Â\', \'A\')
                , \'Ä\', \'A\')
                , \'Á\', \'A\')
                , \'Î\', \'I\')
                , \'Ï\', \'I\')
                , \'Ì\', \'I\')
                , \'Í\', \'I\')
                , \'É\', \'E\')
                , \'È\', \'E\')
                , \'Ê\', \'E\')
                , \'Ë\', \'E\')        
           )  ) LIKE :raison or CONCAT(UPPER(                 
            REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(             
                REPLACE(             
                REPLACE(             
                REPLACE(             
                REPLACE(             
                REPLACE(             
                REPLACE(             
                REPLACE(            
                REPLACE(           
                REPLACE(           
                REPLACE(           
                REPLACE(           
                REPLACE(          
                REPLACE(         
                REPLACE(         
                REPLACE(         
                REPLACE(        
                REPLACE(        
                REPLACE(        
                REPLACE(        
                REPLACE(       
                REPLACE(p.ninNom  
                , \'é\' , \'e\')
                , \'è\' , \'e\') 
                , \'ê\', \'e\')
                , \'ë\', \'e\')
                , \'ÿ\', \'y\')
                , \'ç\' , \'c\')  
                , \'à\' , \'a\')
                , \'ä\' , \'a\') 
                , \'á\' , \'a\')
                , \'ã\', \'a\')
                , \'å\', \'a\')
                , \'â\' , \'a\')   
                , \'ù\' , \'u\')    
                , \'â\' , \'a\')     
                , \'ê\' , \'e\')      
                , \'î\' , \'i\') 
                , \'î\', \'i\')
                , \'ï\', \'i\')
                , \'ì\', \'i\')      
                , \'ô\' , \'o\')
                , \'ö\', \'o\')
                , \'ò\', \'o\')
                , \'ó\', \'o\')
                , \'û\' , \'u\')
                , \'ù\', \'u\')
                , \'ü\', \'u\')
                , \'ú\', \'u\')
                , \'ñ\', \'n\') 
                , \'À\', \'A\')
                , \'Â\', \'A\')
                , \'Ä\', \'A\')
                , \'Á\', \'A\')
                , \'Î\', \'I\')
                , \'Ï\', \'I\')
                , \'Ì\', \'I\')
                , \'Í\', \'I\')
                , \'É\', \'E\')
                , \'È\', \'E\')
                , \'Ê\', \'E\')
                , \'Ë\', \'E\')        
           )  ,\' \',UPPER(                 
            REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(              
                REPLACE(             
                REPLACE(             
                REPLACE(             
                REPLACE(             
                REPLACE(             
                REPLACE(             
                REPLACE(             
                REPLACE(            
                REPLACE(           
                REPLACE(           
                REPLACE(           
                REPLACE(           
                REPLACE(          
                REPLACE(         
                REPLACE(         
                REPLACE(         
                REPLACE(        
                REPLACE(        
                REPLACE(        
                REPLACE(        
                REPLACE(       
                REPLACE(p.ninNom  
                , \'é\' , \'e\')
                , \'è\' , \'e\') 
                , \'ê\', \'e\')
                , \'ë\', \'e\')
                , \'ÿ\', \'y\')
                , \'ç\' , \'c\')  
                , \'à\' , \'a\')
                , \'ä\' , \'a\') 
                , \'á\' , \'a\')
                , \'ã\', \'a\')
                , \'å\', \'a\')
                , \'â\' , \'a\')   
                , \'ù\' , \'u\')    
                , \'â\' , \'a\')     
                , \'ê\' , \'e\')      
                , \'î\' , \'i\') 
                , \'î\', \'i\')
                , \'ï\', \'i\')
                , \'ì\', \'i\')      
                , \'ô\' , \'o\')
                , \'ö\', \'o\')
                , \'ò\', \'o\')
                , \'ó\', \'o\')
                , \'û\' , \'u\')
                , \'ù\', \'u\')
                , \'ü\', \'u\')
                , \'ú\', \'u\')
                , \'ñ\', \'n\') 
                , \'À\', \'A\')
                , \'Â\', \'A\')
                , \'Ä\', \'A\')
                , \'Á\', \'A\')
                , \'Î\', \'I\')
                , \'Ï\', \'I\')
                , \'Ì\', \'I\')
                , \'Í\', \'I\')
                , \'É\', \'E\')
                , \'È\', \'E\')
                , \'Ê\', \'E\')
                , \'Ë\', \'E\')        
           ) ) LIKE :raison ')
        ->setParameter('raison',  '%'.$this->enleveacc($raison).'%');

        }  

        if($datenais){
            $query = $query
            ->andWhere('p.ninDateNaissance = :date')
            ->setParameter('date', $datenais);
        } 
        
        if($adresse){
            $query = $query
            ->andWhere('UPPER(                 
                REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(             
                    REPLACE(             
                    REPLACE(             
                    REPLACE(             
                    REPLACE(             
                    REPLACE(             
                    REPLACE(             
                    REPLACE(            
                    REPLACE(           
                    REPLACE(           
                    REPLACE(           
                    REPLACE(           
                    REPLACE(          
                    REPLACE(         
                    REPLACE(         
                    REPLACE(         
                    REPLACE(        
                    REPLACE(        
                    REPLACE(        
                    REPLACE(        
                    REPLACE(       
                    REPLACE(c.ninadresse1  
                    , \'é\' , \'e\')
                    , \'è\' , \'e\') 
                    , \'ê\', \'e\')
                    , \'ë\', \'e\')
                    , \'ÿ\', \'y\')
                    , \'ç\' , \'c\')  
                    , \'à\' , \'a\')
                    , \'ä\' , \'a\') 
                    , \'á\' , \'a\')
                    , \'ã\', \'a\')
                    , \'å\', \'a\')
                    , \'â\' , \'a\')   
                    , \'ù\' , \'u\')    
                    , \'â\' , \'a\')     
                    , \'ê\' , \'e\')      
                    , \'î\' , \'i\') 
                    , \'î\', \'i\')
                    , \'ï\', \'i\')
                    , \'ì\', \'i\')      
                    , \'ô\' , \'o\')
                    , \'ö\', \'o\')
                    , \'ò\', \'o\')
                    , \'ó\', \'o\')
                    , \'û\' , \'u\')
                    , \'ù\', \'u\')
                    , \'ü\', \'u\')
                    , \'ú\', \'u\')
                    , \'ñ\', \'n\') 
                    , \'À\', \'A\')
                    , \'Â\', \'A\')
                    , \'Ä\', \'A\')
                    , \'Á\', \'A\')
                    , \'Î\', \'I\')
                    , \'Ï\', \'I\')
                    , \'Ì\', \'I\')
                    , \'Í\', \'I\')
                    , \'É\', \'E\')
                    , \'È\', \'E\')
                    , \'Ê\', \'E\')
                    , \'Ë\', \'E\')        
               )  LIKE  :adresse')
            ->setParameter('adresse', '%'.$this->enleveacc($adresse).'%');
        } 
        
        if($enseigne){
            $query = $query
            ->andWhere('UPPER(                 
                REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(              
                    REPLACE(             
                    REPLACE(             
                    REPLACE(             
                    REPLACE(             
                    REPLACE(             
                    REPLACE(             
                    REPLACE(             
                    REPLACE(            
                    REPLACE(           
                    REPLACE(           
                    REPLACE(           
                    REPLACE(           
                    REPLACE(          
                    REPLACE(         
                    REPLACE(         
                    REPLACE(         
                    REPLACE(        
                    REPLACE(        
                    REPLACE(        
                    REPLACE(        
                    REPLACE(       
                    REPLACE(n.ninEnseigne  
                    , \'é\' , \'e\')
                    , \'è\' , \'e\') 
                    , \'ê\', \'e\')
                    , \'ë\', \'e\')
                    , \'ÿ\', \'y\')
                    , \'ç\' , \'c\')  
                    , \'à\' , \'a\')
                    , \'ä\' , \'a\') 
                    , \'á\' , \'a\')
                    , \'ã\', \'a\')
                    , \'å\', \'a\')
                    , \'â\' , \'a\')   
                    , \'ù\' , \'u\')    
                    , \'â\' , \'a\')     
                    , \'ê\' , \'e\')      
                    , \'î\' , \'i\') 
                    , \'î\', \'i\')
                    , \'ï\', \'i\')
                    , \'ì\', \'i\')      
                    , \'ô\' , \'o\')
                    , \'ö\', \'o\')
                    , \'ò\', \'o\')
                    , \'ó\', \'o\')
                    , \'û\' , \'u\')
                    , \'ù\', \'u\')
                    , \'ü\', \'u\')
                    , \'ú\', \'u\')
                    , \'ñ\', \'n\') 
                    , \'À\', \'A\')
                    , \'Â\', \'A\')
                    , \'Ä\', \'A\')
                    , \'Á\', \'A\')
                    , \'Î\', \'I\')
                    , \'Ï\', \'I\')
                    , \'Ì\', \'I\')
                    , \'Í\', \'I\')
                    , \'É\', \'E\')
                    , \'È\', \'E\')
                    , \'Ê\', \'E\')
                    , \'Ë\', \'E\')        
               )  LIKE  :enseigne')
            ->setParameter('enseigne', '%'.$this->enleveacc($enseigne).'%');
        }  
        
        if($cni){
            if (strlen($cni) >= 13 )
            {
                $cni11 = substr($cni, 0, 4).substr($cni,6, 7);
                $query = $query
                ->andWhere('p.ninCNI LIKE :cni or p.ninCNI LIKE :cni11')
                ->setParameter('cni', '%'.$cni.'%')
                ->setParameter('cni11', '%'.$cni11.'%');
    
            }
            else
            {
             
                $query = $query
                ->andWhere('p.ninCNI LIKE :cni ')
                ->setParameter('cni', '%'.$cni.'%')
                ;

            }
           
        }

        if($numReg){
            if(is_numeric($numReg) ){
                $query = $query
                ->andWhere('SUBSTRING(REPLACE(REPLACE(n.ninNumeroDocument,\' \',\'\'),\'_\',\' \'),11, 5) LIKE :numreg ')
                ->setParameter('numreg', '%'.$numReg.'%');
            }
            else{
                $query = $query
                ->andWhere('REPLACE(REPLACE(n.ninNumeroDocument,\' \',\'\'),\'_\',\' \') LIKE :numreg ')
                ->setParameter('numreg', '%'.$numReg.'%');
            }
           
        }

        if($dateReg){
            $query = $query
            ->andWhere('n.ninDateDocument = :datereg')
            ->setParameter('datereg', $dateReg);
        }

        if($sigle){
            $query = $query
            ->andWhere('UPPER(                 
                REPLACE(              
                 REPLACE(             
                  REPLACE(            
                   REPLACE(           
                    REPLACE(          
                     REPLACE(         
                      REPLACE(        
                       REPLACE(       
                        REPLACE(      
                         REPLACE(p.ninSigle  
                         , \'é\' , \'e\' )
                        , \'è\' , \'e\' ) 
                       , \'ç\' , \'c\' )  
                      , \'à\' , \'a\' )   
                     , \'ù\' , \'u\' )    
                    , \'â\' , \'a\' )     
                   , \'ê\' , \'e\' )      
                  , \'î\' , \'i\' )       
                 , \'ô\' , \'o\' )        
                , \'û\' , \'u\' )         
               ) LIKE :sigle')
            ->setParameter('sigle', "%".$this->enleveacc($sigle)."%");
        }

        if($telephone){
            $query = $query
            ->andWhere('p.ninTelephone LIKE :telephone or c.ninTelephon1 LIKE :telephone or c.nintelephon2 LIKE :telephone')
            ->setParameter('telephone', '%'.$telephone.'%');
        }

        if($email){
            $query = $query
            ->andWhere('p.ninEmailPersonnel LIKE :email or c.ninEmail LIKE :email1')
            ->setParameter('email', '%'.$email."%")
            ->setParameter('email1', '%'.$email."%");
        }
     
       $query = $query  
       ->orderBy('n.ninNinea', 'DESC')
       ->setMaxResults(100)
       ->getQuery()
       ->getResult();

       return $query;
          
    }


    public function findByFieldRechercheNINEAMorale($numNinea,$nineaMere, $raison,$datenais, $enseigne,$fj)
    {
        if($fj==21){
            
                $query= $this->createQueryBuilder('n')
                ->andWhere(' LENGTH(n.ninNinea ) < 13')
                ->innerJoin('n.niPersonne', 'p')
                ->innerJoin('n.formeJuridique', 'fj')
                ->addSelect('fj')
                ->innerJoin('fj.niFormeunite', 'fo')
                ->addSelect('fo') 
                ->innerJoin('n.niCoordonnees', 'c')
                ->addSelect('p')
                ->addSelect('c')
                ->andWhere('fo.id  = 22')
              
                ;
                

                if($numNinea){
                $query = $query
                ->andWhere('n.ninNinea  LIKE :numero')
                ->setParameter('numero', $numNinea.'%');
                }

                if($nineaMere){
                $query = $query
                ->andWhere('n.ninNineamere = :nineamere')
                ->setParameter('nineamere', $nineaMere);
                }

                if($raison){
                $query = $query
                ->andWhere('UPPER(                 
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(            
                                REPLACE(           
                                REPLACE(           
                                REPLACE(           
                                REPLACE(           
                                REPLACE(          
                                REPLACE(         
                                REPLACE(         
                                REPLACE(         
                                REPLACE(        
                                REPLACE(        
                                REPLACE(        
                                REPLACE(        
                                REPLACE(       
                                REPLACE(p.ninRaison  
                                , \'é\' , \'e\')
                                , \'è\' , \'e\') 
                                , \'ê\', \'e\')
                                , \'ë\', \'e\')
                                , \'ÿ\', \'y\')
                                , \'ç\' , \'c\')  
                                , \'à\' , \'a\')
                                , \'ä\' , \'a\') 
                                , \'á\' , \'a\')
                                , \'ã\', \'a\')
                                , \'å\', \'a\')
                                , \'â\' , \'a\')   
                                , \'ù\' , \'u\')    
                                , \'â\' , \'a\')     
                                , \'ê\' , \'e\')      
                                , \'î\' , \'i\') 
                                , \'î\', \'i\')
                                , \'ï\', \'i\')
                                , \'ì\', \'i\')      
                                , \'ô\' , \'o\')
                                , \'ö\', \'o\')
                                , \'ò\', \'o\')
                                , \'ó\', \'o\')
                                , \'û\' , \'u\')
                                , \'ù\', \'u\')
                                , \'ü\', \'u\')
                                , \'ú\', \'u\')
                                , \'ñ\', \'n\') 
                                , \'À\', \'A\')
                                , \'Â\', \'A\')
                                , \'Ä\', \'A\')
                                , \'Á\', \'A\')
                                , \'Î\', \'I\')
                                , \'Ï\', \'I\')
                                , \'Ì\', \'I\')
                                , \'Í\', \'I\')
                                , \'É\', \'E\')
                                , \'È\', \'E\')
                                , \'Ê\', \'E\')
                                , \'Ë\', \'E\')


                                ) LIKE :raison or UPPER(                 
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(            
                                REPLACE(           
                                REPLACE(           
                                REPLACE(           
                                REPLACE(           
                                REPLACE(          
                                REPLACE(         
                                REPLACE(         
                                REPLACE(         
                                REPLACE(        
                                REPLACE(        
                                REPLACE(        
                                REPLACE(        
                                REPLACE(       
                                REPLACE(p.ninPrenom  
                                , \'é\' , \'e\')
                                , \'è\' , \'e\') 
                                , \'ê\', \'e\')
                                , \'ë\', \'e\')
                                , \'ÿ\', \'y\')
                                , \'ç\' , \'c\')  
                                , \'à\' , \'a\')
                                , \'ä\' , \'a\') 
                                , \'á\' , \'a\')
                                , \'ã\', \'a\')
                                , \'å\', \'a\')
                                , \'â\' , \'a\')   
                                , \'ù\' , \'u\')    
                                , \'â\' , \'a\')     
                                , \'ê\' , \'e\')      
                                , \'î\' , \'i\') 
                                , \'î\', \'i\')
                                , \'ï\', \'i\')
                                , \'ì\', \'i\')      
                                , \'ô\' , \'o\')
                                , \'ö\', \'o\')
                                , \'ò\', \'o\')
                                , \'ó\', \'o\')
                                , \'û\' , \'u\')
                                , \'ù\', \'u\')
                                , \'ü\', \'u\')
                                , \'ú\', \'u\')
                                , \'ñ\', \'n\') 
                                , \'À\', \'A\')
                                , \'Â\', \'A\')
                                , \'Ä\', \'A\')
                                , \'Á\', \'A\')
                                , \'Î\', \'I\')
                                , \'Ï\', \'I\')
                                , \'Ì\', \'I\')
                                , \'Í\', \'I\')
                                , \'É\', \'E\')
                                , \'È\', \'E\')
                                , \'Ê\', \'E\')
                                , \'Ë\', \'E\')        
                                )  LIKE :raison or UPPER(                 
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(            
                                REPLACE(           
                                REPLACE(           
                                REPLACE(           
                                REPLACE(           
                                REPLACE(          
                                REPLACE(         
                                REPLACE(         
                                REPLACE(         
                                REPLACE(        
                                REPLACE(        
                                REPLACE(        
                                REPLACE(        
                                REPLACE(       
                                REPLACE(p.ninNom  
                                , \'é\' , \'e\')
                                , \'è\' , \'e\') 
                                , \'ê\', \'e\')
                                , \'ë\', \'e\')
                                , \'ÿ\', \'y\')
                                , \'ç\' , \'c\')  
                                , \'à\' , \'a\')
                                , \'ä\' , \'a\') 
                                , \'á\' , \'a\')
                                , \'ã\', \'a\')
                                , \'å\', \'a\')
                                , \'â\' , \'a\')   
                                , \'ù\' , \'u\')    
                                , \'â\' , \'a\')     
                                , \'ê\' , \'e\')      
                                , \'î\' , \'i\') 
                                , \'î\', \'i\')
                                , \'ï\', \'i\')
                                , \'ì\', \'i\')      
                                , \'ô\' , \'o\')
                                , \'ö\', \'o\')
                                , \'ò\', \'o\')
                                , \'ó\', \'o\')
                                , \'û\' , \'u\')
                                , \'ù\', \'u\')
                                , \'ü\', \'u\')
                                , \'ú\', \'u\')
                                , \'ñ\', \'n\') 
                                , \'À\', \'A\')
                                , \'Â\', \'A\')
                                , \'Ä\', \'A\')
                                , \'Á\', \'A\')
                                , \'Î\', \'I\')
                                , \'Ï\', \'I\')
                                , \'Ì\', \'I\')
                                , \'Í\', \'I\')
                                , \'É\', \'E\')
                                , \'È\', \'E\')
                                , \'Ê\', \'E\')
                                , \'Ë\', \'E\')        
                                )  LIKE :raison or CONCAT(UPPER(                 
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(            
                                REPLACE(           
                                REPLACE(           
                                REPLACE(           
                                REPLACE(           
                                REPLACE(          
                                REPLACE(         
                                REPLACE(         
                                REPLACE(         
                                REPLACE(        
                                REPLACE(        
                                REPLACE(        
                                REPLACE(        
                                REPLACE(       
                                REPLACE(p.ninPrenom  
                                , \'é\' , \'e\')
                                , \'è\' , \'e\') 
                                , \'ê\', \'e\')
                                , \'ë\', \'e\')
                                , \'ÿ\', \'y\')
                                , \'ç\' , \'c\')  
                                , \'à\' , \'a\')
                                , \'ä\' , \'a\') 
                                , \'á\' , \'a\')
                                , \'ã\', \'a\')
                                , \'å\', \'a\')
                                , \'â\' , \'a\')   
                                , \'ù\' , \'u\')    
                                , \'â\' , \'a\')     
                                , \'ê\' , \'e\')      
                                , \'î\' , \'i\') 
                                , \'î\', \'i\')
                                , \'ï\', \'i\')
                                , \'ì\', \'i\')      
                                , \'ô\' , \'o\')
                                , \'ö\', \'o\')
                                , \'ò\', \'o\')
                                , \'ó\', \'o\')
                                , \'û\' , \'u\')
                                , \'ù\', \'u\')
                                , \'ü\', \'u\')
                                , \'ú\', \'u\')
                                , \'ñ\', \'n\') 
                                , \'À\', \'A\')
                                , \'Â\', \'A\')
                                , \'Ä\', \'A\')
                                , \'Á\', \'A\')
                                , \'Î\', \'I\')
                                , \'Ï\', \'I\')
                                , \'Ì\', \'I\')
                                , \'Í\', \'I\')
                                , \'É\', \'E\')
                                , \'È\', \'E\')
                                , \'Ê\', \'E\')
                                , \'Ë\', \'E\')        
                                )  ,\' \',UPPER(                 
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(            
                                REPLACE(           
                                REPLACE(           
                                REPLACE(           
                                REPLACE(           
                                REPLACE(          
                                REPLACE(         
                                REPLACE(         
                                REPLACE(         
                                REPLACE(        
                                REPLACE(        
                                REPLACE(        
                                REPLACE(        
                                REPLACE(       
                                REPLACE(p.ninNom  
                                , \'é\' , \'e\')
                                , \'è\' , \'e\') 
                                , \'ê\', \'e\')
                                , \'ë\', \'e\')
                                , \'ÿ\', \'y\')
                                , \'ç\' , \'c\')  
                                , \'à\' , \'a\')
                                , \'ä\' , \'a\') 
                                , \'á\' , \'a\')
                                , \'ã\', \'a\')
                                , \'å\', \'a\')
                                , \'â\' , \'a\')   
                                , \'ù\' , \'u\')    
                                , \'â\' , \'a\')     
                                , \'ê\' , \'e\')      
                                , \'î\' , \'i\') 
                                , \'î\', \'i\')
                                , \'ï\', \'i\')
                                , \'ì\', \'i\')      
                                , \'ô\' , \'o\')
                                , \'ö\', \'o\')
                                , \'ò\', \'o\')
                                , \'ó\', \'o\')
                                , \'û\' , \'u\')
                                , \'ù\', \'u\')
                                , \'ü\', \'u\')
                                , \'ú\', \'u\')
                                , \'ñ\', \'n\') 
                                , \'À\', \'A\')
                                , \'Â\', \'A\')
                                , \'Ä\', \'A\')
                                , \'Á\', \'A\')
                                , \'Î\', \'I\')
                                , \'Ï\', \'I\')
                                , \'Ì\', \'I\')
                                , \'Í\', \'I\')
                                , \'É\', \'E\')
                                , \'È\', \'E\')
                                , \'Ê\', \'E\')
                                , \'Ë\', \'E\')        
                                )  ) LIKE :raison or CONCAT(UPPER(                 
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(            
                                REPLACE(           
                                REPLACE(           
                                REPLACE(           
                                REPLACE(           
                                REPLACE(          
                                REPLACE(         
                                REPLACE(         
                                REPLACE(         
                                REPLACE(        
                                REPLACE(        
                                REPLACE(        
                                REPLACE(        
                                REPLACE(       
                                REPLACE(p.ninNom  
                                , \'é\' , \'e\')
                                , \'è\' , \'e\') 
                                , \'ê\', \'e\')
                                , \'ë\', \'e\')
                                , \'ÿ\', \'y\')
                                , \'ç\' , \'c\')  
                                , \'à\' , \'a\')
                                , \'ä\' , \'a\') 
                                , \'á\' , \'a\')
                                , \'ã\', \'a\')
                                , \'å\', \'a\')
                                , \'â\' , \'a\')   
                                , \'ù\' , \'u\')    
                                , \'â\' , \'a\')     
                                , \'ê\' , \'e\')      
                                , \'î\' , \'i\') 
                                , \'î\', \'i\')
                                , \'ï\', \'i\')
                                , \'ì\', \'i\')      
                                , \'ô\' , \'o\')
                                , \'ö\', \'o\')
                                , \'ò\', \'o\')
                                , \'ó\', \'o\')
                                , \'û\' , \'u\')
                                , \'ù\', \'u\')
                                , \'ü\', \'u\')
                                , \'ú\', \'u\')
                                , \'ñ\', \'n\') 
                                , \'À\', \'A\')
                                , \'Â\', \'A\')
                                , \'Ä\', \'A\')
                                , \'Á\', \'A\')
                                , \'Î\', \'I\')
                                , \'Ï\', \'I\')
                                , \'Ì\', \'I\')
                                , \'Í\', \'I\')
                                , \'É\', \'E\')
                                , \'È\', \'E\')
                                , \'Ê\', \'E\')
                                , \'Ë\', \'E\')        
                                )  ,\' \',UPPER(                 
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(            
                                REPLACE(           
                                REPLACE(           
                                REPLACE(           
                                REPLACE(           
                                REPLACE(          
                                REPLACE(         
                                REPLACE(         
                                REPLACE(         
                                REPLACE(        
                                REPLACE(        
                                REPLACE(        
                                REPLACE(        
                                REPLACE(       
                                REPLACE(p.ninNom  
                                , \'é\' , \'e\')
                                , \'è\' , \'e\') 
                                , \'ê\', \'e\')
                                , \'ë\', \'e\')
                                , \'ÿ\', \'y\')
                                , \'ç\' , \'c\')  
                                , \'à\' , \'a\')
                                , \'ä\' , \'a\') 
                                , \'á\' , \'a\')
                                , \'ã\', \'a\')
                                , \'å\', \'a\')
                                , \'â\' , \'a\')   
                                , \'ù\' , \'u\')    
                                , \'â\' , \'a\')     
                                , \'ê\' , \'e\')      
                                , \'î\' , \'i\') 
                                , \'î\', \'i\')
                                , \'ï\', \'i\')
                                , \'ì\', \'i\')      
                                , \'ô\' , \'o\')
                                , \'ö\', \'o\')
                                , \'ò\', \'o\')
                                , \'ó\', \'o\')
                                , \'û\' , \'u\')
                                , \'ù\', \'u\')
                                , \'ü\', \'u\')
                                , \'ú\', \'u\')
                                , \'ñ\', \'n\') 
                                , \'À\', \'A\')
                                , \'Â\', \'A\')
                                , \'Ä\', \'A\')
                                , \'Á\', \'A\')
                                , \'Î\', \'I\')
                                , \'Ï\', \'I\')
                                , \'Ì\', \'I\')
                                , \'Í\', \'I\')
                                , \'É\', \'E\')
                                , \'È\', \'E\')
                                , \'Ê\', \'E\')
                                , \'Ë\', \'E\')        
                                ) ) LIKE :raison ')
                                ->setParameter('raison',  '%'.$this->enleveacc($raison).'%');

                                }  

                                if($datenais){
                                $query = $query
                                ->andWhere('p.ninDateNaissance = :date')
                                ->setParameter('date', $datenais);
                                }  

                                if($enseigne){
                                $query = $query
                                ->andWhere('UPPER(                 
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(              
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(             
                                REPLACE(            
                                REPLACE(           
                                REPLACE(           
                                REPLACE(           
                                REPLACE(           
                                REPLACE(          
                                REPLACE(         
                                REPLACE(         
                                REPLACE(         
                                REPLACE(        
                                REPLACE(        
                                REPLACE(        
                                REPLACE(        
                                REPLACE(       
                                REPLACE(p.ninEnseigne  
                                , \'é\' , \'e\')
                                , \'è\' , \'e\') 
                                , \'ê\', \'e\')
                                , \'ë\', \'e\')
                                , \'ÿ\', \'y\')
                                , \'ç\' , \'c\')  
                                , \'à\' , \'a\')
                                , \'ä\' , \'a\') 
                                , \'á\' , \'a\')
                                , \'ã\', \'a\')
                                , \'å\', \'a\')
                                , \'â\' , \'a\')   
                                , \'ù\' , \'u\')    
                                , \'â\' , \'a\')     
                                , \'ê\' , \'e\')      
                                , \'î\' , \'i\') 
                                , \'î\', \'i\')
                                , \'ï\', \'i\')
                                , \'ì\', \'i\')      
                                , \'ô\' , \'o\')
                                , \'ö\', \'o\')
                                , \'ò\', \'o\')
                                , \'ó\', \'o\')
                                , \'û\' , \'u\')
                                , \'ù\', \'u\')
                                , \'ü\', \'u\')
                                , \'ú\', \'u\')
                                , \'ñ\', \'n\') 
                                , \'À\', \'A\')
                                , \'Â\', \'A\')
                                , \'Ä\', \'A\')
                                , \'Á\', \'A\')
                                , \'Î\', \'I\')
                                , \'Ï\', \'I\')
                                , \'Ì\', \'I\')
                                , \'Í\', \'I\')
                                , \'É\', \'E\')
                                , \'È\', \'E\')
                                , \'Ê\', \'E\')
                                , \'Ë\', \'E\')        
                                )  LIKE  :enseigne')
                                ->setParameter('enseigne', '%'.$this->enleveacc($enseigne).'%');
                                }  


                $query = $query  
                ->orderBy('n.ninNinea', 'DESC')
                ->setMaxResults(80)
                ->getQuery()
                ->getResult();

                return $query;

        
        }else {
               
            $query= $this->createQueryBuilder('n')
            ->andWhere(' LENGTH(n.ninNinea ) < 13')
            ->innerJoin('n.niPersonne', 'p')
            ->innerJoin('n.formeJuridique', 'fj')
            ->addSelect('fj')
            ->innerJoin('fj.niFormeunite', 'fo')
            ->addSelect('fo') 
            ->innerJoin('n.niCoordonnees', 'c')
            ->addSelect('p')
            ->addSelect('c')
            ->andWhere('fo.id  = 22')
          
            ;
            

            if($numNinea){
            $query = $query
            ->andWhere('n.ninNinea  LIKE :numero')
            ->setParameter('numero', $numNinea.'%');
            }

            if($nineaMere){
            $query = $query
            ->andWhere('n.ninNineamere = :nineamere')
            ->setParameter('nineamere', $nineaMere);
            }

            if($raison){
            $query = $query
            ->andWhere('UPPER(                 
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(            
                            REPLACE(           
                            REPLACE(           
                            REPLACE(           
                            REPLACE(           
                            REPLACE(          
                            REPLACE(         
                            REPLACE(         
                            REPLACE(         
                            REPLACE(        
                            REPLACE(        
                            REPLACE(        
                            REPLACE(        
                            REPLACE(       
                            REPLACE(p.ninRaison  
                            , \'é\' , \'e\')
                            , \'è\' , \'e\') 
                            , \'ê\', \'e\')
                            , \'ë\', \'e\')
                            , \'ÿ\', \'y\')
                            , \'ç\' , \'c\')  
                            , \'à\' , \'a\')
                            , \'ä\' , \'a\') 
                            , \'á\' , \'a\')
                            , \'ã\', \'a\')
                            , \'å\', \'a\')
                            , \'â\' , \'a\')   
                            , \'ù\' , \'u\')    
                            , \'â\' , \'a\')     
                            , \'ê\' , \'e\')      
                            , \'î\' , \'i\') 
                            , \'î\', \'i\')
                            , \'ï\', \'i\')
                            , \'ì\', \'i\')      
                            , \'ô\' , \'o\')
                            , \'ö\', \'o\')
                            , \'ò\', \'o\')
                            , \'ó\', \'o\')
                            , \'û\' , \'u\')
                            , \'ù\', \'u\')
                            , \'ü\', \'u\')
                            , \'ú\', \'u\')
                            , \'ñ\', \'n\') 
                            , \'À\', \'A\')
                            , \'Â\', \'A\')
                            , \'Ä\', \'A\')
                            , \'Á\', \'A\')
                            , \'Î\', \'I\')
                            , \'Ï\', \'I\')
                            , \'Ì\', \'I\')
                            , \'Í\', \'I\')
                            , \'É\', \'E\')
                            , \'È\', \'E\')
                            , \'Ê\', \'E\')
                            , \'Ë\', \'E\')


                            ) LIKE :raison or UPPER(                 
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(            
                            REPLACE(           
                            REPLACE(           
                            REPLACE(           
                            REPLACE(           
                            REPLACE(          
                            REPLACE(         
                            REPLACE(         
                            REPLACE(         
                            REPLACE(        
                            REPLACE(        
                            REPLACE(        
                            REPLACE(        
                            REPLACE(       
                            REPLACE(p.ninPrenom  
                            , \'é\' , \'e\')
                            , \'è\' , \'e\') 
                            , \'ê\', \'e\')
                            , \'ë\', \'e\')
                            , \'ÿ\', \'y\')
                            , \'ç\' , \'c\')  
                            , \'à\' , \'a\')
                            , \'ä\' , \'a\') 
                            , \'á\' , \'a\')
                            , \'ã\', \'a\')
                            , \'å\', \'a\')
                            , \'â\' , \'a\')   
                            , \'ù\' , \'u\')    
                            , \'â\' , \'a\')     
                            , \'ê\' , \'e\')      
                            , \'î\' , \'i\') 
                            , \'î\', \'i\')
                            , \'ï\', \'i\')
                            , \'ì\', \'i\')      
                            , \'ô\' , \'o\')
                            , \'ö\', \'o\')
                            , \'ò\', \'o\')
                            , \'ó\', \'o\')
                            , \'û\' , \'u\')
                            , \'ù\', \'u\')
                            , \'ü\', \'u\')
                            , \'ú\', \'u\')
                            , \'ñ\', \'n\') 
                            , \'À\', \'A\')
                            , \'Â\', \'A\')
                            , \'Ä\', \'A\')
                            , \'Á\', \'A\')
                            , \'Î\', \'I\')
                            , \'Ï\', \'I\')
                            , \'Ì\', \'I\')
                            , \'Í\', \'I\')
                            , \'É\', \'E\')
                            , \'È\', \'E\')
                            , \'Ê\', \'E\')
                            , \'Ë\', \'E\')        
                            )  LIKE :raison or UPPER(                 
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(            
                            REPLACE(           
                            REPLACE(           
                            REPLACE(           
                            REPLACE(           
                            REPLACE(          
                            REPLACE(         
                            REPLACE(         
                            REPLACE(         
                            REPLACE(        
                            REPLACE(        
                            REPLACE(        
                            REPLACE(        
                            REPLACE(       
                            REPLACE(p.ninNom  
                            , \'é\' , \'e\')
                            , \'è\' , \'e\') 
                            , \'ê\', \'e\')
                            , \'ë\', \'e\')
                            , \'ÿ\', \'y\')
                            , \'ç\' , \'c\')  
                            , \'à\' , \'a\')
                            , \'ä\' , \'a\') 
                            , \'á\' , \'a\')
                            , \'ã\', \'a\')
                            , \'å\', \'a\')
                            , \'â\' , \'a\')   
                            , \'ù\' , \'u\')    
                            , \'â\' , \'a\')     
                            , \'ê\' , \'e\')      
                            , \'î\' , \'i\') 
                            , \'î\', \'i\')
                            , \'ï\', \'i\')
                            , \'ì\', \'i\')      
                            , \'ô\' , \'o\')
                            , \'ö\', \'o\')
                            , \'ò\', \'o\')
                            , \'ó\', \'o\')
                            , \'û\' , \'u\')
                            , \'ù\', \'u\')
                            , \'ü\', \'u\')
                            , \'ú\', \'u\')
                            , \'ñ\', \'n\') 
                            , \'À\', \'A\')
                            , \'Â\', \'A\')
                            , \'Ä\', \'A\')
                            , \'Á\', \'A\')
                            , \'Î\', \'I\')
                            , \'Ï\', \'I\')
                            , \'Ì\', \'I\')
                            , \'Í\', \'I\')
                            , \'É\', \'E\')
                            , \'È\', \'E\')
                            , \'Ê\', \'E\')
                            , \'Ë\', \'E\')        
                            )  LIKE :raison or CONCAT(UPPER(                 
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(            
                            REPLACE(           
                            REPLACE(           
                            REPLACE(           
                            REPLACE(           
                            REPLACE(          
                            REPLACE(         
                            REPLACE(         
                            REPLACE(         
                            REPLACE(        
                            REPLACE(        
                            REPLACE(        
                            REPLACE(        
                            REPLACE(       
                            REPLACE(p.ninPrenom  
                            , \'é\' , \'e\')
                            , \'è\' , \'e\') 
                            , \'ê\', \'e\')
                            , \'ë\', \'e\')
                            , \'ÿ\', \'y\')
                            , \'ç\' , \'c\')  
                            , \'à\' , \'a\')
                            , \'ä\' , \'a\') 
                            , \'á\' , \'a\')
                            , \'ã\', \'a\')
                            , \'å\', \'a\')
                            , \'â\' , \'a\')   
                            , \'ù\' , \'u\')    
                            , \'â\' , \'a\')     
                            , \'ê\' , \'e\')      
                            , \'î\' , \'i\') 
                            , \'î\', \'i\')
                            , \'ï\', \'i\')
                            , \'ì\', \'i\')      
                            , \'ô\' , \'o\')
                            , \'ö\', \'o\')
                            , \'ò\', \'o\')
                            , \'ó\', \'o\')
                            , \'û\' , \'u\')
                            , \'ù\', \'u\')
                            , \'ü\', \'u\')
                            , \'ú\', \'u\')
                            , \'ñ\', \'n\') 
                            , \'À\', \'A\')
                            , \'Â\', \'A\')
                            , \'Ä\', \'A\')
                            , \'Á\', \'A\')
                            , \'Î\', \'I\')
                            , \'Ï\', \'I\')
                            , \'Ì\', \'I\')
                            , \'Í\', \'I\')
                            , \'É\', \'E\')
                            , \'È\', \'E\')
                            , \'Ê\', \'E\')
                            , \'Ë\', \'E\')        
                            )  ,\' \',UPPER(                 
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(            
                            REPLACE(           
                            REPLACE(           
                            REPLACE(           
                            REPLACE(           
                            REPLACE(          
                            REPLACE(         
                            REPLACE(         
                            REPLACE(         
                            REPLACE(        
                            REPLACE(        
                            REPLACE(        
                            REPLACE(        
                            REPLACE(       
                            REPLACE(p.ninNom  
                            , \'é\' , \'e\')
                            , \'è\' , \'e\') 
                            , \'ê\', \'e\')
                            , \'ë\', \'e\')
                            , \'ÿ\', \'y\')
                            , \'ç\' , \'c\')  
                            , \'à\' , \'a\')
                            , \'ä\' , \'a\') 
                            , \'á\' , \'a\')
                            , \'ã\', \'a\')
                            , \'å\', \'a\')
                            , \'â\' , \'a\')   
                            , \'ù\' , \'u\')    
                            , \'â\' , \'a\')     
                            , \'ê\' , \'e\')      
                            , \'î\' , \'i\') 
                            , \'î\', \'i\')
                            , \'ï\', \'i\')
                            , \'ì\', \'i\')      
                            , \'ô\' , \'o\')
                            , \'ö\', \'o\')
                            , \'ò\', \'o\')
                            , \'ó\', \'o\')
                            , \'û\' , \'u\')
                            , \'ù\', \'u\')
                            , \'ü\', \'u\')
                            , \'ú\', \'u\')
                            , \'ñ\', \'n\') 
                            , \'À\', \'A\')
                            , \'Â\', \'A\')
                            , \'Ä\', \'A\')
                            , \'Á\', \'A\')
                            , \'Î\', \'I\')
                            , \'Ï\', \'I\')
                            , \'Ì\', \'I\')
                            , \'Í\', \'I\')
                            , \'É\', \'E\')
                            , \'È\', \'E\')
                            , \'Ê\', \'E\')
                            , \'Ë\', \'E\')        
                            )  ) LIKE :raison or CONCAT(UPPER(                 
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(            
                            REPLACE(           
                            REPLACE(           
                            REPLACE(           
                            REPLACE(           
                            REPLACE(          
                            REPLACE(         
                            REPLACE(         
                            REPLACE(         
                            REPLACE(        
                            REPLACE(        
                            REPLACE(        
                            REPLACE(        
                            REPLACE(       
                            REPLACE(p.ninNom  
                            , \'é\' , \'e\')
                            , \'è\' , \'e\') 
                            , \'ê\', \'e\')
                            , \'ë\', \'e\')
                            , \'ÿ\', \'y\')
                            , \'ç\' , \'c\')  
                            , \'à\' , \'a\')
                            , \'ä\' , \'a\') 
                            , \'á\' , \'a\')
                            , \'ã\', \'a\')
                            , \'å\', \'a\')
                            , \'â\' , \'a\')   
                            , \'ù\' , \'u\')    
                            , \'â\' , \'a\')     
                            , \'ê\' , \'e\')      
                            , \'î\' , \'i\') 
                            , \'î\', \'i\')
                            , \'ï\', \'i\')
                            , \'ì\', \'i\')      
                            , \'ô\' , \'o\')
                            , \'ö\', \'o\')
                            , \'ò\', \'o\')
                            , \'ó\', \'o\')
                            , \'û\' , \'u\')
                            , \'ù\', \'u\')
                            , \'ü\', \'u\')
                            , \'ú\', \'u\')
                            , \'ñ\', \'n\') 
                            , \'À\', \'A\')
                            , \'Â\', \'A\')
                            , \'Ä\', \'A\')
                            , \'Á\', \'A\')
                            , \'Î\', \'I\')
                            , \'Ï\', \'I\')
                            , \'Ì\', \'I\')
                            , \'Í\', \'I\')
                            , \'É\', \'E\')
                            , \'È\', \'E\')
                            , \'Ê\', \'E\')
                            , \'Ë\', \'E\')        
                            )  ,\' \',UPPER(                 
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(            
                            REPLACE(           
                            REPLACE(           
                            REPLACE(           
                            REPLACE(           
                            REPLACE(          
                            REPLACE(         
                            REPLACE(         
                            REPLACE(         
                            REPLACE(        
                            REPLACE(        
                            REPLACE(        
                            REPLACE(        
                            REPLACE(       
                            REPLACE(p.ninNom  
                            , \'é\' , \'e\')
                            , \'è\' , \'e\') 
                            , \'ê\', \'e\')
                            , \'ë\', \'e\')
                            , \'ÿ\', \'y\')
                            , \'ç\' , \'c\')  
                            , \'à\' , \'a\')
                            , \'ä\' , \'a\') 
                            , \'á\' , \'a\')
                            , \'ã\', \'a\')
                            , \'å\', \'a\')
                            , \'â\' , \'a\')   
                            , \'ù\' , \'u\')    
                            , \'â\' , \'a\')     
                            , \'ê\' , \'e\')      
                            , \'î\' , \'i\') 
                            , \'î\', \'i\')
                            , \'ï\', \'i\')
                            , \'ì\', \'i\')      
                            , \'ô\' , \'o\')
                            , \'ö\', \'o\')
                            , \'ò\', \'o\')
                            , \'ó\', \'o\')
                            , \'û\' , \'u\')
                            , \'ù\', \'u\')
                            , \'ü\', \'u\')
                            , \'ú\', \'u\')
                            , \'ñ\', \'n\') 
                            , \'À\', \'A\')
                            , \'Â\', \'A\')
                            , \'Ä\', \'A\')
                            , \'Á\', \'A\')
                            , \'Î\', \'I\')
                            , \'Ï\', \'I\')
                            , \'Ì\', \'I\')
                            , \'Í\', \'I\')
                            , \'É\', \'E\')
                            , \'È\', \'E\')
                            , \'Ê\', \'E\')
                            , \'Ë\', \'E\')        
                            ) ) LIKE :raison ')
                            ->setParameter('raison',  '%'.$this->enleveacc($raison).'%');

                            }  

                            if($datenais){
                            $query = $query
                            ->andWhere('p.ninDateNaissance = :date')
                            ->setParameter('date', $datenais);
                            }  

                            if($enseigne){
                            $query = $query
                            ->andWhere('UPPER(                 
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(              
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(             
                            REPLACE(            
                            REPLACE(           
                            REPLACE(           
                            REPLACE(           
                            REPLACE(           
                            REPLACE(          
                            REPLACE(         
                            REPLACE(         
                            REPLACE(         
                            REPLACE(        
                            REPLACE(        
                            REPLACE(        
                            REPLACE(        
                            REPLACE(       
                            REPLACE(p.ninEnseigne  
                            , \'é\' , \'e\')
                            , \'è\' , \'e\') 
                            , \'ê\', \'e\')
                            , \'ë\', \'e\')
                            , \'ÿ\', \'y\')
                            , \'ç\' , \'c\')  
                            , \'à\' , \'a\')
                            , \'ä\' , \'a\') 
                            , \'á\' , \'a\')
                            , \'ã\', \'a\')
                            , \'å\', \'a\')
                            , \'â\' , \'a\')   
                            , \'ù\' , \'u\')    
                            , \'â\' , \'a\')     
                            , \'ê\' , \'e\')      
                            , \'î\' , \'i\') 
                            , \'î\', \'i\')
                            , \'ï\', \'i\')
                            , \'ì\', \'i\')      
                            , \'ô\' , \'o\')
                            , \'ö\', \'o\')
                            , \'ò\', \'o\')
                            , \'ó\', \'o\')
                            , \'û\' , \'u\')
                            , \'ù\', \'u\')
                            , \'ü\', \'u\')
                            , \'ú\', \'u\')
                            , \'ñ\', \'n\') 
                            , \'À\', \'A\')
                            , \'Â\', \'A\')
                            , \'Ä\', \'A\')
                            , \'Á\', \'A\')
                            , \'Î\', \'I\')
                            , \'Ï\', \'I\')
                            , \'Ì\', \'I\')
                            , \'Í\', \'I\')
                            , \'É\', \'E\')
                            , \'È\', \'E\')
                            , \'Ê\', \'E\')
                            , \'Ë\', \'E\')        
                            )  LIKE  :enseigne')
                            ->setParameter('enseigne', '%'.$this->enleveacc($enseigne).'%');
                            }  


            $query = $query  
            ->orderBy('n.ninNinea', 'DESC')
            ->setMaxResults(80)
            ->getQuery()
            ->getResult();

            return $query;

    
        }
       

    }

        
        public function findByFieldRechercheNINEA($numNinea,$nineaMere, $raison,$datenais, $enseigne,$fj)
        {
          
            if($fj->getNiFormeunite()->getId()==11){
                    $query= $this->createQueryBuilder('n')
                    ->andWhere(' LENGTH(n.ninNinea ) < 13')
                    ->innerJoin('n.niPersonne', 'p')
                    ->innerJoin('n.formeJuridique', 'fj')
                    ->addSelect('fj')
                    ->innerJoin('n.niCoordonnees', 'c')
                    ->addSelect('p')
                    ->addSelect('c')
                    ->andWhere('fj.id  = 10 or fj.id  = 99')
                  
                    ;
                    

                    if($numNinea){
                    $query = $query
                    ->andWhere('n.ninNinea  LIKE :numero')
                    ->setParameter('numero', $numNinea.'%');
                    }

                    if($nineaMere){
                    $query = $query
                    ->andWhere('n.ninNineamere = :nineamere')
                    ->setParameter('nineamere', $nineaMere);
                    }

                    if($raison){
                    $query = $query
                    ->andWhere('UPPER(                 
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(            
                                    REPLACE(           
                                    REPLACE(           
                                    REPLACE(           
                                    REPLACE(           
                                    REPLACE(          
                                    REPLACE(         
                                    REPLACE(         
                                    REPLACE(         
                                    REPLACE(        
                                    REPLACE(        
                                    REPLACE(        
                                    REPLACE(        
                                    REPLACE(       
                                    REPLACE(p.ninRaison  
                                    , \'é\' , \'e\')
                                    , \'è\' , \'e\') 
                                    , \'ê\', \'e\')
                                    , \'ë\', \'e\')
                                    , \'ÿ\', \'y\')
                                    , \'ç\' , \'c\')  
                                    , \'à\' , \'a\')
                                    , \'ä\' , \'a\') 
                                    , \'á\' , \'a\')
                                    , \'ã\', \'a\')
                                    , \'å\', \'a\')
                                    , \'â\' , \'a\')   
                                    , \'ù\' , \'u\')    
                                    , \'â\' , \'a\')     
                                    , \'ê\' , \'e\')      
                                    , \'î\' , \'i\') 
                                    , \'î\', \'i\')
                                    , \'ï\', \'i\')
                                    , \'ì\', \'i\')      
                                    , \'ô\' , \'o\')
                                    , \'ö\', \'o\')
                                    , \'ò\', \'o\')
                                    , \'ó\', \'o\')
                                    , \'û\' , \'u\')
                                    , \'ù\', \'u\')
                                    , \'ü\', \'u\')
                                    , \'ú\', \'u\')
                                    , \'ñ\', \'n\') 
                                    , \'À\', \'A\')
                                    , \'Â\', \'A\')
                                    , \'Ä\', \'A\')
                                    , \'Á\', \'A\')
                                    , \'Î\', \'I\')
                                    , \'Ï\', \'I\')
                                    , \'Ì\', \'I\')
                                    , \'Í\', \'I\')
                                    , \'É\', \'E\')
                                    , \'È\', \'E\')
                                    , \'Ê\', \'E\')
                                    , \'Ë\', \'E\')


                                    ) LIKE :raison or UPPER(                 
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(            
                                    REPLACE(           
                                    REPLACE(           
                                    REPLACE(           
                                    REPLACE(           
                                    REPLACE(          
                                    REPLACE(         
                                    REPLACE(         
                                    REPLACE(         
                                    REPLACE(        
                                    REPLACE(        
                                    REPLACE(        
                                    REPLACE(        
                                    REPLACE(       
                                    REPLACE(p.ninPrenom  
                                    , \'é\' , \'e\')
                                    , \'è\' , \'e\') 
                                    , \'ê\', \'e\')
                                    , \'ë\', \'e\')
                                    , \'ÿ\', \'y\')
                                    , \'ç\' , \'c\')  
                                    , \'à\' , \'a\')
                                    , \'ä\' , \'a\') 
                                    , \'á\' , \'a\')
                                    , \'ã\', \'a\')
                                    , \'å\', \'a\')
                                    , \'â\' , \'a\')   
                                    , \'ù\' , \'u\')    
                                    , \'â\' , \'a\')     
                                    , \'ê\' , \'e\')      
                                    , \'î\' , \'i\') 
                                    , \'î\', \'i\')
                                    , \'ï\', \'i\')
                                    , \'ì\', \'i\')      
                                    , \'ô\' , \'o\')
                                    , \'ö\', \'o\')
                                    , \'ò\', \'o\')
                                    , \'ó\', \'o\')
                                    , \'û\' , \'u\')
                                    , \'ù\', \'u\')
                                    , \'ü\', \'u\')
                                    , \'ú\', \'u\')
                                    , \'ñ\', \'n\') 
                                    , \'À\', \'A\')
                                    , \'Â\', \'A\')
                                    , \'Ä\', \'A\')
                                    , \'Á\', \'A\')
                                    , \'Î\', \'I\')
                                    , \'Ï\', \'I\')
                                    , \'Ì\', \'I\')
                                    , \'Í\', \'I\')
                                    , \'É\', \'E\')
                                    , \'È\', \'E\')
                                    , \'Ê\', \'E\')
                                    , \'Ë\', \'E\')        
                                    )  LIKE :raison or UPPER(                 
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(            
                                    REPLACE(           
                                    REPLACE(           
                                    REPLACE(           
                                    REPLACE(           
                                    REPLACE(          
                                    REPLACE(         
                                    REPLACE(         
                                    REPLACE(         
                                    REPLACE(        
                                    REPLACE(        
                                    REPLACE(        
                                    REPLACE(        
                                    REPLACE(       
                                    REPLACE(p.ninNom  
                                    , \'é\' , \'e\')
                                    , \'è\' , \'e\') 
                                    , \'ê\', \'e\')
                                    , \'ë\', \'e\')
                                    , \'ÿ\', \'y\')
                                    , \'ç\' , \'c\')  
                                    , \'à\' , \'a\')
                                    , \'ä\' , \'a\') 
                                    , \'á\' , \'a\')
                                    , \'ã\', \'a\')
                                    , \'å\', \'a\')
                                    , \'â\' , \'a\')   
                                    , \'ù\' , \'u\')    
                                    , \'â\' , \'a\')     
                                    , \'ê\' , \'e\')      
                                    , \'î\' , \'i\') 
                                    , \'î\', \'i\')
                                    , \'ï\', \'i\')
                                    , \'ì\', \'i\')      
                                    , \'ô\' , \'o\')
                                    , \'ö\', \'o\')
                                    , \'ò\', \'o\')
                                    , \'ó\', \'o\')
                                    , \'û\' , \'u\')
                                    , \'ù\', \'u\')
                                    , \'ü\', \'u\')
                                    , \'ú\', \'u\')
                                    , \'ñ\', \'n\') 
                                    , \'À\', \'A\')
                                    , \'Â\', \'A\')
                                    , \'Ä\', \'A\')
                                    , \'Á\', \'A\')
                                    , \'Î\', \'I\')
                                    , \'Ï\', \'I\')
                                    , \'Ì\', \'I\')
                                    , \'Í\', \'I\')
                                    , \'É\', \'E\')
                                    , \'È\', \'E\')
                                    , \'Ê\', \'E\')
                                    , \'Ë\', \'E\')        
                                    )  LIKE :raison or CONCAT(UPPER(                 
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(            
                                    REPLACE(           
                                    REPLACE(           
                                    REPLACE(           
                                    REPLACE(           
                                    REPLACE(          
                                    REPLACE(         
                                    REPLACE(         
                                    REPLACE(         
                                    REPLACE(        
                                    REPLACE(        
                                    REPLACE(        
                                    REPLACE(        
                                    REPLACE(       
                                    REPLACE(p.ninPrenom  
                                    , \'é\' , \'e\')
                                    , \'è\' , \'e\') 
                                    , \'ê\', \'e\')
                                    , \'ë\', \'e\')
                                    , \'ÿ\', \'y\')
                                    , \'ç\' , \'c\')  
                                    , \'à\' , \'a\')
                                    , \'ä\' , \'a\') 
                                    , \'á\' , \'a\')
                                    , \'ã\', \'a\')
                                    , \'å\', \'a\')
                                    , \'â\' , \'a\')   
                                    , \'ù\' , \'u\')    
                                    , \'â\' , \'a\')     
                                    , \'ê\' , \'e\')      
                                    , \'î\' , \'i\') 
                                    , \'î\', \'i\')
                                    , \'ï\', \'i\')
                                    , \'ì\', \'i\')      
                                    , \'ô\' , \'o\')
                                    , \'ö\', \'o\')
                                    , \'ò\', \'o\')
                                    , \'ó\', \'o\')
                                    , \'û\' , \'u\')
                                    , \'ù\', \'u\')
                                    , \'ü\', \'u\')
                                    , \'ú\', \'u\')
                                    , \'ñ\', \'n\') 
                                    , \'À\', \'A\')
                                    , \'Â\', \'A\')
                                    , \'Ä\', \'A\')
                                    , \'Á\', \'A\')
                                    , \'Î\', \'I\')
                                    , \'Ï\', \'I\')
                                    , \'Ì\', \'I\')
                                    , \'Í\', \'I\')
                                    , \'É\', \'E\')
                                    , \'È\', \'E\')
                                    , \'Ê\', \'E\')
                                    , \'Ë\', \'E\')        
                                    )  ,\' \',UPPER(                 
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(            
                                    REPLACE(           
                                    REPLACE(           
                                    REPLACE(           
                                    REPLACE(           
                                    REPLACE(          
                                    REPLACE(         
                                    REPLACE(         
                                    REPLACE(         
                                    REPLACE(        
                                    REPLACE(        
                                    REPLACE(        
                                    REPLACE(        
                                    REPLACE(       
                                    REPLACE(p.ninNom  
                                    , \'é\' , \'e\')
                                    , \'è\' , \'e\') 
                                    , \'ê\', \'e\')
                                    , \'ë\', \'e\')
                                    , \'ÿ\', \'y\')
                                    , \'ç\' , \'c\')  
                                    , \'à\' , \'a\')
                                    , \'ä\' , \'a\') 
                                    , \'á\' , \'a\')
                                    , \'ã\', \'a\')
                                    , \'å\', \'a\')
                                    , \'â\' , \'a\')   
                                    , \'ù\' , \'u\')    
                                    , \'â\' , \'a\')     
                                    , \'ê\' , \'e\')      
                                    , \'î\' , \'i\') 
                                    , \'î\', \'i\')
                                    , \'ï\', \'i\')
                                    , \'ì\', \'i\')      
                                    , \'ô\' , \'o\')
                                    , \'ö\', \'o\')
                                    , \'ò\', \'o\')
                                    , \'ó\', \'o\')
                                    , \'û\' , \'u\')
                                    , \'ù\', \'u\')
                                    , \'ü\', \'u\')
                                    , \'ú\', \'u\')
                                    , \'ñ\', \'n\') 
                                    , \'À\', \'A\')
                                    , \'Â\', \'A\')
                                    , \'Ä\', \'A\')
                                    , \'Á\', \'A\')
                                    , \'Î\', \'I\')
                                    , \'Ï\', \'I\')
                                    , \'Ì\', \'I\')
                                    , \'Í\', \'I\')
                                    , \'É\', \'E\')
                                    , \'È\', \'E\')
                                    , \'Ê\', \'E\')
                                    , \'Ë\', \'E\')        
                                    )  ) LIKE :raison or CONCAT(UPPER(                 
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(            
                                    REPLACE(           
                                    REPLACE(           
                                    REPLACE(           
                                    REPLACE(           
                                    REPLACE(          
                                    REPLACE(         
                                    REPLACE(         
                                    REPLACE(         
                                    REPLACE(        
                                    REPLACE(        
                                    REPLACE(        
                                    REPLACE(        
                                    REPLACE(       
                                    REPLACE(p.ninNom  
                                    , \'é\' , \'e\')
                                    , \'è\' , \'e\') 
                                    , \'ê\', \'e\')
                                    , \'ë\', \'e\')
                                    , \'ÿ\', \'y\')
                                    , \'ç\' , \'c\')  
                                    , \'à\' , \'a\')
                                    , \'ä\' , \'a\') 
                                    , \'á\' , \'a\')
                                    , \'ã\', \'a\')
                                    , \'å\', \'a\')
                                    , \'â\' , \'a\')   
                                    , \'ù\' , \'u\')    
                                    , \'â\' , \'a\')     
                                    , \'ê\' , \'e\')      
                                    , \'î\' , \'i\') 
                                    , \'î\', \'i\')
                                    , \'ï\', \'i\')
                                    , \'ì\', \'i\')      
                                    , \'ô\' , \'o\')
                                    , \'ö\', \'o\')
                                    , \'ò\', \'o\')
                                    , \'ó\', \'o\')
                                    , \'û\' , \'u\')
                                    , \'ù\', \'u\')
                                    , \'ü\', \'u\')
                                    , \'ú\', \'u\')
                                    , \'ñ\', \'n\') 
                                    , \'À\', \'A\')
                                    , \'Â\', \'A\')
                                    , \'Ä\', \'A\')
                                    , \'Á\', \'A\')
                                    , \'Î\', \'I\')
                                    , \'Ï\', \'I\')
                                    , \'Ì\', \'I\')
                                    , \'Í\', \'I\')
                                    , \'É\', \'E\')
                                    , \'È\', \'E\')
                                    , \'Ê\', \'E\')
                                    , \'Ë\', \'E\')        
                                    )  ,\' \',UPPER(                 
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(            
                                    REPLACE(           
                                    REPLACE(           
                                    REPLACE(           
                                    REPLACE(           
                                    REPLACE(          
                                    REPLACE(         
                                    REPLACE(         
                                    REPLACE(         
                                    REPLACE(        
                                    REPLACE(        
                                    REPLACE(        
                                    REPLACE(        
                                    REPLACE(       
                                    REPLACE(p.ninNom  
                                    , \'é\' , \'e\')
                                    , \'è\' , \'e\') 
                                    , \'ê\', \'e\')
                                    , \'ë\', \'e\')
                                    , \'ÿ\', \'y\')
                                    , \'ç\' , \'c\')  
                                    , \'à\' , \'a\')
                                    , \'ä\' , \'a\') 
                                    , \'á\' , \'a\')
                                    , \'ã\', \'a\')
                                    , \'å\', \'a\')
                                    , \'â\' , \'a\')   
                                    , \'ù\' , \'u\')    
                                    , \'â\' , \'a\')     
                                    , \'ê\' , \'e\')      
                                    , \'î\' , \'i\') 
                                    , \'î\', \'i\')
                                    , \'ï\', \'i\')
                                    , \'ì\', \'i\')      
                                    , \'ô\' , \'o\')
                                    , \'ö\', \'o\')
                                    , \'ò\', \'o\')
                                    , \'ó\', \'o\')
                                    , \'û\' , \'u\')
                                    , \'ù\', \'u\')
                                    , \'ü\', \'u\')
                                    , \'ú\', \'u\')
                                    , \'ñ\', \'n\') 
                                    , \'À\', \'A\')
                                    , \'Â\', \'A\')
                                    , \'Ä\', \'A\')
                                    , \'Á\', \'A\')
                                    , \'Î\', \'I\')
                                    , \'Ï\', \'I\')
                                    , \'Ì\', \'I\')
                                    , \'Í\', \'I\')
                                    , \'É\', \'E\')
                                    , \'È\', \'E\')
                                    , \'Ê\', \'E\')
                                    , \'Ë\', \'E\')        
                                    ) ) LIKE :raison ')
                                    ->setParameter('raison',  '%'.$this->enleveacc($raison).'%');

                                    }  

                                    if($datenais){
                                    $query = $query
                                    ->andWhere('p.ninDateNaissance = :date')
                                    ->setParameter('date', $datenais);
                                    }  

                                    if($enseigne){
                                    $query = $query
                                    ->andWhere('UPPER(                 
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(              
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(             
                                    REPLACE(            
                                    REPLACE(           
                                    REPLACE(           
                                    REPLACE(           
                                    REPLACE(           
                                    REPLACE(          
                                    REPLACE(         
                                    REPLACE(         
                                    REPLACE(         
                                    REPLACE(        
                                    REPLACE(        
                                    REPLACE(        
                                    REPLACE(        
                                    REPLACE(       
                                    REPLACE(p.ninEnseigne  
                                    , \'é\' , \'e\')
                                    , \'è\' , \'e\') 
                                    , \'ê\', \'e\')
                                    , \'ë\', \'e\')
                                    , \'ÿ\', \'y\')
                                    , \'ç\' , \'c\')  
                                    , \'à\' , \'a\')
                                    , \'ä\' , \'a\') 
                                    , \'á\' , \'a\')
                                    , \'ã\', \'a\')
                                    , \'å\', \'a\')
                                    , \'â\' , \'a\')   
                                    , \'ù\' , \'u\')    
                                    , \'â\' , \'a\')     
                                    , \'ê\' , \'e\')      
                                    , \'î\' , \'i\') 
                                    , \'î\', \'i\')
                                    , \'ï\', \'i\')
                                    , \'ì\', \'i\')      
                                    , \'ô\' , \'o\')
                                    , \'ö\', \'o\')
                                    , \'ò\', \'o\')
                                    , \'ó\', \'o\')
                                    , \'û\' , \'u\')
                                    , \'ù\', \'u\')
                                    , \'ü\', \'u\')
                                    , \'ú\', \'u\')
                                    , \'ñ\', \'n\') 
                                    , \'À\', \'A\')
                                    , \'Â\', \'A\')
                                    , \'Ä\', \'A\')
                                    , \'Á\', \'A\')
                                    , \'Î\', \'I\')
                                    , \'Ï\', \'I\')
                                    , \'Ì\', \'I\')
                                    , \'Í\', \'I\')
                                    , \'É\', \'E\')
                                    , \'È\', \'E\')
                                    , \'Ê\', \'E\')
                                    , \'Ë\', \'E\')        
                                    )  LIKE  :enseigne')
                                    ->setParameter('enseigne', '%'.$this->enleveacc($enseigne).'%');
                                    }  


                    $query = $query  
                    ->orderBy('n.ninNinea', 'DESC')
                    ->setMaxResults(80)
                    ->getQuery()
                    ->getResult();

                    return $query;

            }

        }


    public function findValidationByUser($dateDebut, $dateFin)
    {
        $query= $this->createQueryBuilder('n')
        ->innerJoin('n.createdBy','u')
        ->addSelect('u')
        ->innerJoin('u.niAdministration','a')
        ->addSelect('a')
        ->select("count(n.id) as nombre, u.prenom as prenom, u.nom as nom")
        ;

      

        if($dateDebut){
            $dateDebut=new \DateTime( $dateDebut);
            $query= $query
                    ->andWhere('n.createdAt  >= :dateDebut')
                    ->setParameter('dateDebut', $dateDebut);
        }
        if($dateFin){
            $dateFin=new \DateTime( $dateFin);
            $query= $query
                    ->andWhere('n.createdAt  <= :dateFin')
                    ->setParameter('dateFin', $dateFin);
        }

        return $query= $query
                ->groupBy('u.id')
                ->groupBy('u.prenom', 'u.nom')
                ->getQuery()
                ->getResult()
    ;          
    }


    //requete pour recupérer le prenom , le nom et date de naissance de dans la table ninea
    public function findPersonneByField($prenom, $nom, $datenaissance     ) 
        {
            $query = $this->createQueryBuilder('n')
                ->innerJoin('n.niPersonne', 'p')
                ->addSelect('p')
                ->andWhere('p.ninNom LIKE :nom and p.ninPrenom LIKE :prenom and  p.ninDateNaissance LKE :dateNaissance ')
                ->setParameter(':nom', $nom)
                ->setParameter(':prenom', $prenom)
                ->setParameter(':dateNaissance', $datenaissance)
                ->orderBy('p.id', 'ASC')
                ->getQuery()
                ->getResult();

        return $query;
    }
  


    public function findValidationByUser2( $dateDebut, $dateFin)
    {
        $query = $this->createQueryBuilder('n')
            ->innerJoin('n.createdBy', 'u')
            ->addSelect('u')           
            ->select("count(n.id) as nombre, u.prenom as prenom, u.nom as nom");
       
        if ($dateDebut) {
            $dateDebut = new \DateTime($dateDebut);
            $query = $query
                ->andWhere('n.createdAt  >= :dateDebut')
                ->setParameter('dateDebut', $dateDebut);
        }
        if ($dateFin) {
            $dateFin = new \DateTime($dateFin);
            $query = $query
                ->andWhere('n.createdAt  <= :dateFin')
                ->setParameter('dateFin', $dateFin);
        }

        return $query = $query
            ->groupBy('u.id')
            ->groupBy('u.prenom', 'u.nom')
            ->getQuery()
            ->getResult();
    }

    public function findNineaParFormeUnite($user, $dateDebut, $dateFin)
    {
        $query = $this->createQueryBuilder('n')
            ->innerJoin('n.createdBy', 'u')
            ->addSelect('u')  
            ->innerJoin('n.formeJuridique', 'fj')
            ->addSelect('fj') 
            ->innerJoin('fj.niFormeunite', 'fu')
            ->addSelect('fu') 
            
            ->innerJoin('u.niAdministration', 'ad')
            ->addSelect('ad')           
            ->select("count(n.id) as nombre, fu.libelle as libelle");        
        if ($user) {
           
            $query = $query
                ->andWhere('ad.id  = : ad')
                ->setParameter('ad', $user);
        }
       
        if ($dateDebut) {
            $dateDebut = new \DateTime($dateDebut);
            $query = $query
                ->andWhere('n.createdAt  >= :dateDebut')
                ->setParameter('dateDebut', $dateDebut);
        }
        if ($dateFin) {
            $dateFin = new \DateTime($dateFin);
            $query = $query
                ->andWhere('n.createdAt  <= :dateFin')
                ->setParameter('dateFin', $dateFin);
        }

        return $query = $query
            ->groupBy('fu.id')
            ->groupBy('fu.libelle')
            ->getQuery()
            ->getResult();
    }




    public function findNineaParFormeJuridique($user, $dateDebut, $dateFin)
    {
        $query = $this->createQueryBuilder('n')
            ->innerJoin('n.createdBy', 'u')
            ->addSelect('u')  
            ->innerJoin('n.formeJuridique', 'fj')
            ->addSelect('fj') 
            ->innerJoin('u.niAdministration', 'ad')
            ->addSelect('ad')           
            ->select("count(n.id) as nombre, fj.fojLibelle as libelle");        
        if ($user) {
           
            $query = $query
                ->andWhere('ad.id  = : ad')
                ->setParameter('ad', $user);
        }
       
        if ($dateDebut) {
            $dateDebut = new \DateTime($dateDebut);
            $query = $query
                ->andWhere('n.createdAt  >= :dateDebut')
                ->setParameter('dateDebut', $dateDebut);
        }
        if ($dateFin) {
            $dateFin = new \DateTime($dateFin);
            $query = $query
                ->andWhere('n.createdAt  <= :dateFin')
                ->setParameter('dateFin', $dateFin);
        }

        return $query = $query
            ->groupBy('fj.id')
            ->groupBy('fj.fojLibelle')
            ->getQuery()
            ->getResult();
    }
    



    public function findNineaParCentre($user, $dateDebut, $dateFin)
    {
        $query = $this->createQueryBuilder('n')
            ->innerJoin('n.createdBy', 'u')
            ->addSelect('u')  
            ->innerJoin('n.formeJuridique', 'fj')
            ->addSelect('fj') 
            ->innerJoin('u.niAdministration', 'ad')
            ->addSelect('ad')           
            ->select("count(n.id) as nombre, ad.admlibelle as libelle");        
        if ($user) {
           
            $query = $query
                ->andWhere('ad.id  = : ad')
                ->setParameter('ad', $user);
        }
       
        if ($dateDebut) {
            $dateDebut = new \DateTime($dateDebut);
            $query = $query
                ->andWhere('n.createdAt  >= :dateDebut')
                ->setParameter('dateDebut', $dateDebut);
        }
        if ($dateFin) {
            $dateFin = new \DateTime($dateFin);
            $query = $query
                ->andWhere('n.createdAt  <= :dateFin')
                ->setParameter('dateFin', $dateFin);
        }

        return $query = $query
            ->groupBy('ad.admlibelle')
            
            ->getQuery()
            ->getResult();
    }


    public function findNineaParActivite($user, $dateDebut, $dateFin)
    {
        $query = $this->createQueryBuilder('n')
            ->innerJoin('n.createdBy', 'u')
            ->addSelect('u')  
            ->innerJoin('n.ninActivite', ' ninact')
            ->addSelect('ninact') 
            ->innerJoin('ninact.refNaema', ' refNa')
            ->addSelect('refNa')
            ->andWhere('ninact.statActivprincipale  = 1')
            ->innerJoin('n.formeJuridique', 'fj')
            ->addSelect('fj') 
            ->innerJoin('u.niAdministration', 'ad')
            ->addSelect('ad')           
            ->select("count(n.id) as nombre, refNa.libelle as libelle");        
        if ($user) {
           
            $query = $query
                ->andWhere('ad.id  = : ad')
                ->setParameter('ad', $user);
        }
       
        if ($dateDebut) {
            $dateDebut = new \DateTime($dateDebut);
            $query = $query
                ->andWhere('n.createdAt  >= :dateDebut')
                ->setParameter('dateDebut', $dateDebut);
        }
        if ($dateFin) {
            $dateFin = new \DateTime($dateFin);
            $query = $query
                ->andWhere('n.createdAt  <= :dateFin')
                ->setParameter('dateFin', $dateFin);
        }

        return $query = $query
            ->groupBy('refNa.libelle')
            
            ->getQuery()
            ->getResult();
    }



    public function findNineaParEtat($user, $dateDebut, $dateFin)
    {
        $query = $this->createQueryBuilder('n')
            ->innerJoin('n.createdBy', 'u')
            ->addSelect('u')  
            ->innerJoin('n.formeJuridique', 'fj')
            ->addSelect('fj') 
            ->innerJoin('u.niAdministration', 'ad')
            ->addSelect('ad')           
            ->select("count(n.id) as nombre, n.ninEtat as etat");        
        if ($user) {
           
            $query = $query
                ->andWhere('ad.id  = : ad')
                ->setParameter('ad', $user);
        }
       
        if ($dateDebut) {
            $dateDebut = new \DateTime($dateDebut);
            $query = $query
                ->andWhere('n.createdAt  >= :dateDebut')
                ->setParameter('dateDebut', $dateDebut);
        }
        if ($dateFin) {
            $dateFin = new \DateTime($dateFin);
            $query = $query
                ->andWhere('n.createdAt  <= :dateFin')
                ->setParameter('dateFin', $dateFin);
        }

        return $query = $query
            ->groupBy('n.ninEtat')
            
            ->getQuery()
            ->getResult();
    }



    
    public function findNineaParMois($user, $annee)
    {
        $query = $this->createQueryBuilder('n')
            ->innerJoin('n.createdBy', 'u')
            ->addSelect('u')  
            ->andWhere('YEAR(n.createdAt)  = :annee')
            ->setParameter('annee', $annee)
                     
            ->select("count(n.id) as nombre , MONTH(n.createdAt) as mois ");        
        if ($user) {
           
            $query = $query
                ->andWhere('ad.id  = : ad')
                ->setParameter('ad', $user);
        }
       
       

        return $query = $query
            ->groupBy("n.createdAt")
            ->getQuery()
            ->getResult();
    }


    public function findbyformeUnite()
    {
        $query = $this->createQueryBuilder('n')
            ->innerJoin('n.formeJuridique', 'fj')
            ->addSelect('fj') 
            ->innerJoin('fj.niFormeunite', 'fu')
            ->addSelect('fu')            
            ->select("count(n.id) as nombre, fu.libelle as libelle");
       

        return $query = $query
            ->groupBy('fu.id')
            ->groupBy('fu.libelle')
            
            ->getQuery()
            ->getResult();
    }

    public function findByCreatedAt($var , $var2 )
    {
        $query = $this->createQueryBuilder('ni');

        if ($var) {
            $var = new \DateTime($var);
            // $var = $var->format('Y-m-d');
            $query = $query->andWhere('ni.createdAt >= :var')
                        ->setParameter('var',$var);
        }
        if ($var2) {
            $var2 = new \DateTime($var2);
           //  $var2 = $var2->format('Y-m-d');

            $query = $query->andWhere('ni.createdAt <= :var2')
                        ->setParameter('var2',$var2);
        }

        $query = $query->andWhere("ni.ninEtat = :v")
                       ->setParameter('v',1);

        return $query = $query->getQuery()
                              ->getResult();
    }  
    



    /**
     * la methode utilistaire doctirne qui permet de recuperer les entreprises suspendues
     * les NINEAs avec le statut de cessation/suspension v 
     *
     * @param [type] $numNinea
     * @param [type] $nineaMere
     * @param [type] $raison
     * @param [type] $datenais
     * @param [type] $enseigne
     * @return void
     */
    public function findByFieldRechercheEtat($numNinea,$nineaMere, $raison,$datenais, $enseigne, $user)
    {
        $query= $this->createQueryBuilder('n')
        ->innerJoin('n.niCessations','sus')
        ->addSelect('sus')
        ->innerJoin('sus.createdBy','uzer')
        ->addSelect('uzer')
        ->innerJoin('uzer.niAdministration', 'ad')
        ->addSelect('ad')
        ->where('sus.etat = :v')
        ->andWhere('ad.id = :cUser')
        ->setParameter('v', 'v')
        ->setParameter('cUser', $user)
        ->innerJoin('n.formeJuridique', 'f')
        ->addSelect('f')
        ->innerJoin('f.niFormeunite', 'fo')
        ->addSelect('fo')       
        ->andWhere('fo.id = :var1 or fo.id = :var2 ')
        ->setParameter('var1', 11)
        ->setParameter('var2', 12)
        ->andWhere(' LENGTH(n.ninNinea ) < 13')
        ->innerJoin('n.niPersonne', 'p')
        ->innerJoin('n.niCoordonnees', 'c')
        ->addSelect('p')
        ->addSelect('c');

        if($numNinea){
        $query = $query
        ->andWhere('n.ninNinea  LIKE :numero')
        ->setParameter('numero', $numNinea.'%');
        }

        if($nineaMere){
        $query = $query
        ->andWhere('n.ninNineamere = :nineamere')
        ->setParameter('nineamere', $nineaMere);
        }

        if($raison){
            $query = $query
            ->andWhere('UPPER(                 
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(            
            REPLACE(           
            REPLACE(           
            REPLACE(           
            REPLACE(           
            REPLACE(          
            REPLACE(         
            REPLACE(         
            REPLACE(         
            REPLACE(        
            REPLACE(        
            REPLACE(        
            REPLACE(        
            REPLACE(       
            REPLACE(p.ninRaison  
            , \'é\' , \'e\')
            , \'è\' , \'e\') 
            , \'ê\', \'e\')
            , \'ë\', \'e\')
            , \'ÿ\', \'y\')
            , \'ç\' , \'c\')  
            , \'à\' , \'a\')
            , \'ä\' , \'a\') 
            , \'á\' , \'a\')
            , \'ã\', \'a\')
            , \'å\', \'a\')
            , \'â\' , \'a\')   
            , \'ù\' , \'u\')    
            , \'â\' , \'a\')     
            , \'ê\' , \'e\')      
            , \'î\' , \'i\') 
            , \'î\', \'i\')
            , \'ï\', \'i\')
            , \'ì\', \'i\')      
            , \'ô\' , \'o\')
            , \'ö\', \'o\')
            , \'ò\', \'o\')
            , \'ó\', \'o\')
            , \'û\' , \'u\')
            , \'ù\', \'u\')
            , \'ü\', \'u\')
            , \'ú\', \'u\')
            , \'ñ\', \'n\') 
            , \'À\', \'A\')
            , \'Â\', \'A\')
            , \'Ä\', \'A\')
            , \'Á\', \'A\')
            , \'Î\', \'I\')
            , \'Ï\', \'I\')
            , \'Ì\', \'I\')
            , \'Í\', \'I\')
            , \'É\', \'E\')
            , \'È\', \'E\')
            , \'Ê\', \'E\')
            , \'Ë\', \'E\')


            ) LIKE :raison or UPPER(                 
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(            
            REPLACE(           
            REPLACE(           
            REPLACE(           
            REPLACE(           
            REPLACE(          
            REPLACE(         
            REPLACE(         
            REPLACE(         
            REPLACE(        
            REPLACE(        
            REPLACE(        
            REPLACE(        
            REPLACE(       
            REPLACE(p.ninPrenom  
            , \'é\' , \'e\')
            , \'è\' , \'e\') 
            , \'ê\', \'e\')
            , \'ë\', \'e\')
            , \'ÿ\', \'y\')
            , \'ç\' , \'c\')  
            , \'à\' , \'a\')
            , \'ä\' , \'a\') 
            , \'á\' , \'a\')
            , \'ã\', \'a\')
            , \'å\', \'a\')
            , \'â\' , \'a\')   
            , \'ù\' , \'u\')    
            , \'â\' , \'a\')     
            , \'ê\' , \'e\')      
            , \'î\' , \'i\') 
            , \'î\', \'i\')
            , \'ï\', \'i\')
            , \'ì\', \'i\')      
            , \'ô\' , \'o\')
            , \'ö\', \'o\')
            , \'ò\', \'o\')
            , \'ó\', \'o\')
            , \'û\' , \'u\')
            , \'ù\', \'u\')
            , \'ü\', \'u\')
            , \'ú\', \'u\')
            , \'ñ\', \'n\') 
            , \'À\', \'A\')
            , \'Â\', \'A\')
            , \'Ä\', \'A\')
            , \'Á\', \'A\')
            , \'Î\', \'I\')
            , \'Ï\', \'I\')
            , \'Ì\', \'I\')
            , \'Í\', \'I\')
            , \'É\', \'E\')
            , \'È\', \'E\')
            , \'Ê\', \'E\')
            , \'Ë\', \'E\')        
            )  LIKE :raison or UPPER(                 
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(            
            REPLACE(           
            REPLACE(           
            REPLACE(           
            REPLACE(           
            REPLACE(          
            REPLACE(         
            REPLACE(         
            REPLACE(         
            REPLACE(        
            REPLACE(        
            REPLACE(        
            REPLACE(        
            REPLACE(       
            REPLACE(p.ninNom  
            , \'é\' , \'e\')
            , \'è\' , \'e\') 
            , \'ê\', \'e\')
            , \'ë\', \'e\')
            , \'ÿ\', \'y\')
            , \'ç\' , \'c\')  
            , \'à\' , \'a\')
            , \'ä\' , \'a\') 
            , \'á\' , \'a\')
            , \'ã\', \'a\')
            , \'å\', \'a\')
            , \'â\' , \'a\')   
            , \'ù\' , \'u\')    
            , \'â\' , \'a\')     
            , \'ê\' , \'e\')      
            , \'î\' , \'i\') 
            , \'î\', \'i\')
            , \'ï\', \'i\')
            , \'ì\', \'i\')      
            , \'ô\' , \'o\')
            , \'ö\', \'o\')
            , \'ò\', \'o\')
            , \'ó\', \'o\')
            , \'û\' , \'u\')
            , \'ù\', \'u\')
            , \'ü\', \'u\')
            , \'ú\', \'u\')
            , \'ñ\', \'n\') 
            , \'À\', \'A\')
            , \'Â\', \'A\')
            , \'Ä\', \'A\')
            , \'Á\', \'A\')
            , \'Î\', \'I\')
            , \'Ï\', \'I\')
            , \'Ì\', \'I\')
            , \'Í\', \'I\')
            , \'É\', \'E\')
            , \'È\', \'E\')
            , \'Ê\', \'E\')
            , \'Ë\', \'E\')        
            )  LIKE :raison or CONCAT(UPPER(                 
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(            
            REPLACE(           
            REPLACE(           
            REPLACE(           
            REPLACE(           
            REPLACE(          
            REPLACE(         
            REPLACE(         
            REPLACE(         
            REPLACE(        
            REPLACE(        
            REPLACE(        
            REPLACE(        
            REPLACE(       
            REPLACE(p.ninPrenom  
            , \'é\' , \'e\')
            , \'è\' , \'e\') 
            , \'ê\', \'e\')
            , \'ë\', \'e\')
            , \'ÿ\', \'y\')
            , \'ç\' , \'c\')  
            , \'à\' , \'a\')
            , \'ä\' , \'a\') 
            , \'á\' , \'a\')
            , \'ã\', \'a\')
            , \'å\', \'a\')
            , \'â\' , \'a\')   
            , \'ù\' , \'u\')    
            , \'â\' , \'a\')     
            , \'ê\' , \'e\')      
            , \'î\' , \'i\') 
            , \'î\', \'i\')
            , \'ï\', \'i\')
            , \'ì\', \'i\')      
            , \'ô\' , \'o\')
            , \'ö\', \'o\')
            , \'ò\', \'o\')
            , \'ó\', \'o\')
            , \'û\' , \'u\')
            , \'ù\', \'u\')
            , \'ü\', \'u\')
            , \'ú\', \'u\')
            , \'ñ\', \'n\') 
            , \'À\', \'A\')
            , \'Â\', \'A\')
            , \'Ä\', \'A\')
            , \'Á\', \'A\')
            , \'Î\', \'I\')
            , \'Ï\', \'I\')
            , \'Ì\', \'I\')
            , \'Í\', \'I\')
            , \'É\', \'E\')
            , \'È\', \'E\')
            , \'Ê\', \'E\')
            , \'Ë\', \'E\')        
            )  ,\' \',UPPER(                 
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(            
            REPLACE(           
            REPLACE(           
            REPLACE(           
            REPLACE(           
            REPLACE(          
            REPLACE(         
            REPLACE(         
            REPLACE(         
            REPLACE(        
            REPLACE(        
            REPLACE(        
            REPLACE(        
            REPLACE(       
            REPLACE(p.ninNom  
            , \'é\' , \'e\')
            , \'è\' , \'e\') 
            , \'ê\', \'e\')
            , \'ë\', \'e\')
            , \'ÿ\', \'y\')
            , \'ç\' , \'c\')  
            , \'à\' , \'a\')
            , \'ä\' , \'a\') 
            , \'á\' , \'a\')
            , \'ã\', \'a\')
            , \'å\', \'a\')
            , \'â\' , \'a\')   
            , \'ù\' , \'u\')    
            , \'â\' , \'a\')     
            , \'ê\' , \'e\')      
            , \'î\' , \'i\') 
            , \'î\', \'i\')
            , \'ï\', \'i\')
            , \'ì\', \'i\')      
            , \'ô\' , \'o\')
            , \'ö\', \'o\')
            , \'ò\', \'o\')
            , \'ó\', \'o\')
            , \'û\' , \'u\')
            , \'ù\', \'u\')
            , \'ü\', \'u\')
            , \'ú\', \'u\')
            , \'ñ\', \'n\') 
            , \'À\', \'A\')
            , \'Â\', \'A\')
            , \'Ä\', \'A\')
            , \'Á\', \'A\')
            , \'Î\', \'I\')
            , \'Ï\', \'I\')
            , \'Ì\', \'I\')
            , \'Í\', \'I\')
            , \'É\', \'E\')
            , \'È\', \'E\')
            , \'Ê\', \'E\')
            , \'Ë\', \'E\')        
            )  ) LIKE :raison or CONCAT(UPPER(                 
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(            
            REPLACE(           
            REPLACE(           
            REPLACE(           
            REPLACE(           
            REPLACE(          
            REPLACE(         
            REPLACE(         
            REPLACE(         
            REPLACE(        
            REPLACE(        
            REPLACE(        
            REPLACE(        
            REPLACE(       
            REPLACE(p.ninNom  
            , \'é\' , \'e\')
            , \'è\' , \'e\') 
            , \'ê\', \'e\')
            , \'ë\', \'e\')
            , \'ÿ\', \'y\')
            , \'ç\' , \'c\')  
            , \'à\' , \'a\')
            , \'ä\' , \'a\') 
            , \'á\' , \'a\')
            , \'ã\', \'a\')
            , \'å\', \'a\')
            , \'â\' , \'a\')   
            , \'ù\' , \'u\')    
            , \'â\' , \'a\')     
            , \'ê\' , \'e\')      
            , \'î\' , \'i\') 
            , \'î\', \'i\')
            , \'ï\', \'i\')
            , \'ì\', \'i\')      
            , \'ô\' , \'o\')
            , \'ö\', \'o\')
            , \'ò\', \'o\')
            , \'ó\', \'o\')
            , \'û\' , \'u\')
            , \'ù\', \'u\')
            , \'ü\', \'u\')
            , \'ú\', \'u\')
            , \'ñ\', \'n\') 
            , \'À\', \'A\')
            , \'Â\', \'A\')
            , \'Ä\', \'A\')
            , \'Á\', \'A\')
            , \'Î\', \'I\')
            , \'Ï\', \'I\')
            , \'Ì\', \'I\')
            , \'Í\', \'I\')
            , \'É\', \'E\')
            , \'È\', \'E\')
            , \'Ê\', \'E\')
            , \'Ë\', \'E\')        
            )  ,\' \',UPPER(                 
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(            
            REPLACE(           
            REPLACE(           
            REPLACE(           
            REPLACE(           
            REPLACE(          
            REPLACE(         
            REPLACE(         
            REPLACE(         
            REPLACE(        
            REPLACE(        
            REPLACE(        
            REPLACE(        
            REPLACE(       
            REPLACE(p.ninNom  
            , \'é\' , \'e\')
            , \'è\' , \'e\') 
            , \'ê\', \'e\')
            , \'ë\', \'e\')
            , \'ÿ\', \'y\')
            , \'ç\' , \'c\')  
            , \'à\' , \'a\')
            , \'ä\' , \'a\') 
            , \'á\' , \'a\')
            , \'ã\', \'a\')
            , \'å\', \'a\')
            , \'â\' , \'a\')   
            , \'ù\' , \'u\')    
            , \'â\' , \'a\')     
            , \'ê\' , \'e\')      
            , \'î\' , \'i\') 
            , \'î\', \'i\')
            , \'ï\', \'i\')
            , \'ì\', \'i\')      
            , \'ô\' , \'o\')
            , \'ö\', \'o\')
            , \'ò\', \'o\')
            , \'ó\', \'o\')
            , \'û\' , \'u\')
            , \'ù\', \'u\')
            , \'ü\', \'u\')
            , \'ú\', \'u\')
            , \'ñ\', \'n\') 
            , \'À\', \'A\')
            , \'Â\', \'A\')
            , \'Ä\', \'A\')
            , \'Á\', \'A\')
            , \'Î\', \'I\')
            , \'Ï\', \'I\')
            , \'Ì\', \'I\')
            , \'Í\', \'I\')
            , \'É\', \'E\')
            , \'È\', \'E\')
            , \'Ê\', \'E\')
            , \'Ë\', \'E\')        
            ) ) LIKE :raison ')
            ->setParameter('raison',  '%'.$this->enleveacc($raison).'%');

        }  

        if($datenais){
            $query = $query
            ->andWhere('p.ninDateNaissance = :date')
            ->setParameter('date', $datenais);
        }  

        if($enseigne){
            $query = $query
            ->andWhere('UPPER(                 
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(              
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(             
            REPLACE(            
            REPLACE(           
            REPLACE(           
            REPLACE(           
            REPLACE(           
            REPLACE(          
            REPLACE(         
            REPLACE(         
            REPLACE(         
            REPLACE(        
            REPLACE(        
            REPLACE(        
            REPLACE(        
            REPLACE(       
            REPLACE(p.ninEnseigne  
            , \'é\' , \'e\')
            , \'è\' , \'e\') 
            , \'ê\', \'e\')
            , \'ë\', \'e\')
            , \'ÿ\', \'y\')
            , \'ç\' , \'c\')  
            , \'à\' , \'a\')
            , \'ä\' , \'a\') 
            , \'á\' , \'a\')
            , \'ã\', \'a\')
            , \'å\', \'a\')
            , \'â\' , \'a\')   
            , \'ù\' , \'u\')    
            , \'â\' , \'a\')     
            , \'ê\' , \'e\')      
            , \'î\' , \'i\') 
            , \'î\', \'i\')
            , \'ï\', \'i\')
            , \'ì\', \'i\')      
            , \'ô\' , \'o\')
            , \'ö\', \'o\')
            , \'ò\', \'o\')
            , \'ó\', \'o\')
            , \'û\' , \'u\')
            , \'ù\', \'u\')
            , \'ü\', \'u\')
            , \'ú\', \'u\')
            , \'ñ\', \'n\') 
            , \'À\', \'A\')
            , \'Â\', \'A\')
            , \'Ä\', \'A\')
            , \'Á\', \'A\')
            , \'Î\', \'I\')
            , \'Ï\', \'I\')
            , \'Ì\', \'I\')
            , \'Í\', \'I\')
            , \'É\', \'E\')
            , \'È\', \'E\')
            , \'Ê\', \'E\')
            , \'Ë\', \'E\')        
            )  LIKE  :enseigne')
            ->setParameter('enseigne', '%'.$this->enleveacc($enseigne).'%');
        }  


        $query = $query  
        ->orderBy('n.ninNinea', 'DESC')
        ->setMaxResults(80)
        ->getQuery()
        ->getResult();

        return $query;

    }
    
    
    /*
    public function findOneBySomeField($value): ?NINinea
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}