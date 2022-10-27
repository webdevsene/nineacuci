<?php

namespace App\Repository;

use App\Entity\HistoryNiPersonne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HistoryNiPersonne>
 *
 * @method HistoryNiPersonne|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistoryNiPersonne|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistoryNiPersonne[]    findAll()
 * @method HistoryNiPersonne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoryNiPersonneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistoryNiPersonne::class);
    }

    public function add(HistoryNiPersonne $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(HistoryNiPersonne $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return HistoryNiPersonne[] Returns an array of HistoryNiPersonne objects
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

//    public function findOneBySomeField($value): ?HistoryNiPersonne
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
