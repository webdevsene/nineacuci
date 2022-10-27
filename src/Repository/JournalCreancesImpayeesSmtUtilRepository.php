<?php

namespace App\Repository;

use App\Entity\JournalCreancesImpayeesSmtUtil;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<JournalCreancesImpayeesSmtUtil>
 *
 * @method JournalCreancesImpayeesSmtUtil|null find($id, $lockMode = null, $lockVersion = null)
 * @method JournalCreancesImpayeesSmtUtil|null findOneBy(array $criteria, array $orderBy = null)
 * @method JournalCreancesImpayeesSmtUtil[]    findAll()
 * @method JournalCreancesImpayeesSmtUtil[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JournalCreancesImpayeesSmtUtilRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JournalCreancesImpayeesSmtUtil::class);
    }

    public function add(JournalCreancesImpayeesSmtUtil $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(JournalCreancesImpayeesSmtUtil $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return JournalCreancesImpayeesSmtUtil[] Returns an array of JournalCreancesImpayeesSmtUtil objects
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

//    public function findOneBySomeField($value): ?JournalCreancesImpayeesSmtUtil
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
