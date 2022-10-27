<?php

namespace App\Repository;

use App\Entity\DettesCreancesSmt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DettesCreancesSmt>
 *
 * @method DettesCreancesSmt|null find($id, $lockMode = null, $lockVersion = null)
 * @method DettesCreancesSmt|null findOneBy(array $criteria, array $orderBy = null)
 * @method DettesCreancesSmt[]    findAll()
 * @method DettesCreancesSmt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DettesCreancesSmtRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DettesCreancesSmt::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(DettesCreancesSmt $entity, bool $flush = true): void
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
    public function remove(DettesCreancesSmt $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return DettesCreancesSmt[] Returns an array of DettesCreancesSmt objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DettesCreancesSmt
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
