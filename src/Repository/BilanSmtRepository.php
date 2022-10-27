<?php

namespace App\Repository;

use App\Entity\BilanSmt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BilanSmt>
 *
 * @method BilanSmt|null find($id, $lockMode = null, $lockVersion = null)
 * @method BilanSmt|null findOneBy(array $criteria, array $orderBy = null)
 * @method BilanSmt[]    findAll()
 * @method BilanSmt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BilanSmtRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BilanSmt::class);
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

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(BilanSmt $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(BilanSmt $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return BilanSmt[] Returns an array of BilanSmt objects
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

    /*
    public function findOneBySomeField($value): ?BilanSmt
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
