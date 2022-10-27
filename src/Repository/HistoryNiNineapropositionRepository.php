<?php

namespace App\Repository;

use App\Entity\HistoryNiNineaproposition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HistoryNiNineaproposition>
 *
 * @method HistoryNiNineaproposition|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistoryNiNineaproposition|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistoryNiNineaproposition[]    findAll()
 * @method HistoryNiNineaproposition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoryNiNineapropositionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistoryNiNineaproposition::class);
    }

    public function add(HistoryNiNineaproposition $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(HistoryNiNineaproposition $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return HistoryNiNineaproposition[] Returns an array of HistoryNiNineaproposition objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?HistoryNiNineaproposition
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
