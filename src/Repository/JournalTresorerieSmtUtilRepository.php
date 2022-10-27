<?php

namespace App\Repository;

use App\Entity\JournalTresorerieSmtUtil;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<JournalTresorerieSmtUtil>
 *
 * @method JournalTresorerieSmtUtil|null find($id, $lockMode = null, $lockVersion = null)
 * @method JournalTresorerieSmtUtil|null findOneBy(array $criteria, array $orderBy = null)
 * @method JournalTresorerieSmtUtil[]    findAll()
 * @method JournalTresorerieSmtUtil[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JournalTresorerieSmtUtilRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JournalTresorerieSmtUtil::class);
    }

    public function add(JournalTresorerieSmtUtil $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(JournalTresorerieSmtUtil $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return JournalTresorerieSmtUtil[] Returns an array of JournalTresorerieSmtUtil objects
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

//    public function findOneBySomeField($value): ?JournalTresorerieSmtUtil
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
