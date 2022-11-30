<?php

namespace App\Repository;

use App\Entity\NiCessation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NiCessation|null find($id, $lockMode = null, $lockVersion = null)
 * @method NiCessation|null findOneBy(array $criteria, array $orderBy = null)
 * @method NiCessation[]    findAll()
 * @method NiCessation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NiCessationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NiCessation::class);
    }


    public function findByFieldRechercheEtat($numNinea,$nineaMere, $raison,$datenais, $enseigne)
    {
        $query= $this->createQueryBuilder('sus')
        ->where('sus.etat = :v')
        ->setParameter('v', 'v')
        ->innerJoin('sus.ninea','n')
        ->addSelect('n')
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

    // /**
    //  * @return NiCessation[] Returns an array of NiCessation objects
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

    /*
    public function findOneBySomeField($value): ?NiCessation
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
