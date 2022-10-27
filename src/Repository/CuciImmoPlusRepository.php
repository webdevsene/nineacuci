<?php

namespace App\Repository;

use App\Entity\CuciImmoPlus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CuciImmoPlus|null find($id, $lockMode = null, $lockVersion = null)
 * @method CuciImmoPlus|null findOneBy(array $criteria, array $orderBy = null)
 * @method CuciImmoPlus[]    findAll()
 * @method CuciImmoPlus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CuciImmoPlusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CuciImmoPlus::class);
    }

    // /**
    //  * @return CuciImmoPlus[] Returns an array of CuciImmoPlus objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CuciImmoPlus
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
   

    public function findNombreBilan($annee)
    {
        $query= $this->createQueryBuilder('b')
            ->innerJoin('b.repertoire','r')
            ->addSelect('r')
            ->select("count(distinct r.id)")
            ->andWhere('b.anneeFinanciere = :anneeFinanciere')
          
            ->setParameter('anneeFinanciere', $annee);
          
        return  $query= $query
                 ->getQuery()->getSingleScalarResult()
                ;
    }

    public function findInterTableau($annee)
    {
        $query= $this->createQueryBuilder('i')
            ->leftJoin('i.repertoire','r')
            ->addSelect('r')
            ->select(' distinct r.id , i.submit') 
            ;
        
        if($annee){
          
            $query= $query
                    ->andWhere('i.anneeFinanciere  = :annee')
                    ->setParameter('annee', $annee);
        }
       
        return  $query= $query
                
                ->getQuery()
                ->getResult()
            ;
    }

    public function findByCodeCuci($codeCuci,$annee)
    {
        return $this->createQueryBuilder('i')

            ->innerJoin('i.repertoire','r')
            ->addSelect('r')
            ->andWhere('i.anneeFinanciere = :annee')
            ->andWhere('r.codeCuci = :codeCuci')
            ->setParameter('annee', $annee)
            ->setParameter('codeCuci', $codeCuci)  
            ->getQuery()
            ->getResult()
        ;
    }
}
