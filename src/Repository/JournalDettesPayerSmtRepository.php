<?php

namespace App\Repository;

use App\Entity\JournalDettesPayerSmt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<JournalDettesPayerSmt>
 *
 * @method JournalDettesPayerSmt|null find($id, $lockMode = null, $lockVersion = null)
 * @method JournalDettesPayerSmt|null findOneBy(array $criteria, array $orderBy = null)
 * @method JournalDettesPayerSmt[]    findAll()
 * @method JournalDettesPayerSmt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JournalDettesPayerSmtRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JournalDettesPayerSmt::class);
    }

    public function add(JournalDettesPayerSmt $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(JournalDettesPayerSmt $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return JournalDettesPayerSmt[] Returns an array of JournalDettesPayerSmt objects
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

//    public function findOneBySomeField($value): ?JournalDettesPayerSmt
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
