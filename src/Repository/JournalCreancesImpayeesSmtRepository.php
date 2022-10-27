<?php

namespace App\Repository;

use App\Entity\JournalCreancesImpayeesSmt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<JournalCreancesImpayeesSmt>
 *
 * @method JournalCreancesImpayeesSmt|null find($id, $lockMode = null, $lockVersion = null)
 * @method JournalCreancesImpayeesSmt|null findOneBy(array $criteria, array $orderBy = null)
 * @method JournalCreancesImpayeesSmt[]    findAll()
 * @method JournalCreancesImpayeesSmt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JournalCreancesImpayeesSmtRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JournalCreancesImpayeesSmt::class);
    }

    public function add(JournalCreancesImpayeesSmt $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(JournalCreancesImpayeesSmt $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return JournalCreancesImpayeesSmt[] Returns an array of JournalCreancesImpayeesSmt objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('j.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?JournalCreancesImpayeesSmt
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
