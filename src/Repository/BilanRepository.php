<?php

namespace App\Repository;

use App\Entity\Bilan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bilan|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bilan|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bilan[]    findAll()
 * @method Bilan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BilanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bilan::class);
    }

    // /**
    //  * @return Bilan[] Returns an array of Bilan objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function findInterTableau($annee,$type)
    {
        $query= $this->createQueryBuilder('b')
            ->innerJoin('b.repertoire','r')
            
            ->addSelect('r')
            ->innerJoin('b.createdBy','c')
            ->addSelect('c')
            ->innerJoin('b.modifiedBy','m')
    
            ->addSelect('m')
           
            ->andWhere('b.type  = :type')
                    ->setParameter('type', $type)
            ->select(' distinct r.id , b.submit,CONCAT(c.prenom,c.nom) as nom,CONCAT(m.prenom,m.nom) as nommodifier,b.createdAt,b.updatedAt') 
            ;
        
        if($annee){
          
            $query= $query
                    ->andWhere('b.anneeFinanciere  = :annee')
                    ->setParameter('annee', $annee);
        }
       
        return  $query= $query
                
                ->getQuery()
                ->getResult()
            ;
    }

    public function findByCodeCuci($codeCuci,$annee,$type)
    {
        return $this->createQueryBuilder('b')

            ->innerJoin('b.repertoire','r')
            ->addSelect('r')
            ->andWhere('b.anneeFinanciere = :annee')
            ->andWhere('b.type = :type')
            ->andWhere('r.codeCuci = :codeCuci')
            ->setParameter('annee', $annee)
            ->setParameter('type', $type)
            ->setParameter('codeCuci', $codeCuci)
            
            ->getQuery()
            ->getResult()
        ;
    }


    public function findByAnneeFinanciere($debutPeriode, $finPeriode)
    {
        
        //return $this->createQueryBuilder('b')
        
            //->andWhere('b.anneeFinanciere <= :finPeriode')
            //->andwhere('b.anneeFinanciere >= :debutPeriode')
            //->setParameter('debutPeriode', $debutPeriode)
            //->setParameter('finPeriode', $finPeriode)       
            //
            //->getQuery()
            //->getResult()
        //;


        return $this->createQueryBuilder('b')
                    ->select('b')
                    ->andWhere('b.anneeFinanciere BETWEEN :debutPeriode AND :finPeriode ')
                    ->setParameter('debutPeriode', $debutPeriode)
                    ->setParameter('finPeriode', $finPeriode)
                    ->getQuery()
                    ->setMaxResults(1000)
                    ->getResult();

    }

    
    public function findOneByRepertoire($codeCuci,$annee,$type)
    {
        return $this->createQueryBuilder('b')

            ->innerJoin('b.repertoire','r')
            ->addSelect('r')
            ->andWhere('b.anneeFinanciere = :annee')
            ->andWhere('b.type = :type')
            ->andWhere('r.codeCuci = :codeCuci')
            ->setParameter('annee', $annee)
            ->setParameter('type', $type)
            ->setParameter('codeCuci', $codeCuci)
            
            ->getQuery()
            ->getResult()
        ;
    }


    public function findNombreBilan($dateFin, $type)
    {
        $query= $this->createQueryBuilder('b')
            ->innerJoin('b.repertoire','r')
            ->addSelect('r')
            ->select("count(distinct r.id)")
            ->andWhere('b.anneeFinanciere = :anneeFinanciere')
            ->andWhere('b.type = :type')
            ->setParameter('anneeFinanciere', $dateFin)
            ->setParameter('type', $type);
        return  $query= $query
                 ->getQuery()->getSingleScalarResult()
                ;
    }


    public function countBilanByUser($user)
    {
        
        return $this->createQueryBuilder('u')
                ->select('count(u.id)')
                ->andWhere('u.createdBy = :createdBy')
                ->setParameter('createdBy', $user)
                ->getQuery()
                ->getSingleScalarResult();

    }



    

    /*
    public function findOneBySomeField($value): ?Bilan
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
