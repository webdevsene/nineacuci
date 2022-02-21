<?php

namespace App\Repository;

use App\Entity\CompteDeResultats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompteDeResultats|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompteDeResultats|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompteDeResultats[]    findAll()
 * @method CompteDeResultats[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompteDeResultatsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompteDeResultats::class);
    }

    
    public function findByCodeCuci($codeCuci,$annee)
    {
        return $this->createQueryBuilder('b')

            // ->innerJoin('b.repertoire','r')
            ->innerJoin('b.cuci_rep_code','r')
            ->addSelect('r')
            // ->andWhere('b.anneeFinanciere = :annee')
            ->andWhere('b.annee_financiere = :annee')
            ->andWhere('r.codeCuci = :codeCuci')
            ->setParameter('annee', $annee)
            ->setParameter('codeCuci', $codeCuci)
            
            ->getQuery()
            ->getResult()
        ;
    }

    
    public function findByCodeCuciAnneeCategory($codeCuci,$annee,$category)
    {
        return $this->createQueryBuilder('b')

            ->innerJoin('b.repertoire','r')
            ->addSelect('r')
            ->andWhere('b.anneeFinanciere = :annee')
            ->andWhere('b.category = :category')
            ->andWhere('r.codeCuci = :codeCuci')
            ->setParameter('annee', $annee)
            ->setParameter('category', $category)
            ->setParameter('codeCuci', $codeCuci)
            
            ->getQuery()
            ->getResult()
        ;
    }
    

    public function findByType($codeCuci,$annee,$type, $refCode)
    {
        return $this->createQueryBuilder('b')

            ->innerJoin('b.repertoire','r')
            ->addSelect('r')
            ->andWhere('b.anneeFinanciere = :annee')
            ->andWhere('b.type = :type')
            ->andWhere('b.refCode = :refCode')
            ->andWhere('r.codeCuci = :codeCuci')
            ->setParameter('annee', $annee)
            ->setParameter('type', $type)
            ->setParameter('codeCuci', $codeCuci)
            ->setParameter('refCode', $refCode)
            
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return CompteDeResultats[] Returns an array of CompteDeResultats objects
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
    public function findOneBySomeField($value): ?CompteDeResultats
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
