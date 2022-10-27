<?php

namespace App\Repository;

use App\Entity\HistoryDocumentCreation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HistoryDocumentCreation>
 *
 * @method HistoryDocumentCreation|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistoryDocumentCreation|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistoryDocumentCreation[]    findAll()
 * @method HistoryDocumentCreation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoryDocumentCreationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistoryDocumentCreation::class);
    }

    public function add(HistoryDocumentCreation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(HistoryDocumentCreation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return HistoryDocumentCreation[] Returns an array of HistoryDocumentCreation objects
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

//    public function findOneBySomeField($value): ?HistoryDocumentCreation
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
