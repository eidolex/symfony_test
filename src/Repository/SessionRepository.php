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

    /**
     * @param array<int,mixed> $criteria
     */
    public function filter(array $criteria = []): array
    {
        $qb = $this->createQueryBuilder("s");

        if (isset($criteria["type"]) && $criteria["type"]) {
            $qb->andWhere("s.type = :type")->setParameter(
                "type",
                $criteria["type"]
            );
        }

        $qb->andWhere("s.isAvailable = :isAvailable")->setParameter(
            "isAvailable",
            true
        );

        $qb->orderBy("s.time", "ASC");

        return $qb->getQuery()->getResult();
    }

    /**
     * @param array<int, int> $ids
     */
    public function findByIds(array $ids): array
    {
        return $this->createQueryBuilder("s")
            ->andWhere("s.id IN (:ids)")
            ->setParameter("ids", $ids)
            ->getQuery()
            ->getResult();
    }
}
