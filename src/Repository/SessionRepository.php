<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Session>
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    //    /**
    //     * @return Session[] Returns an array of Session objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Session
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function filter(array $criteria = []): array
    {
        $qb = $this->createQueryBuilder('s');

        if (isset($criteria['type']) && $criteria['type']) {
            $qb->andWhere('s.type = :type')
                ->setParameter('type', $criteria['type']);
        }

        $qb->andWhere('s.isAvailable = :isAvailable')
            ->setParameter('isAvailable', true);

        $qb->orderBy('s.time', 'ASC');

        return $qb->getQuery()->getResult();
    }

    public function findByIds(array $ids): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.id IN (:ids)')
            ->setParameter('ids', $ids)
            ->getQuery()
            ->getResult();
    }
}
