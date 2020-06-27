<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Contest\Repository;

use App\Domain\Contest\Contest;
use App\Domain\Contest\ContestInterface;
use App\Domain\Contest\Repository\ContestRepositoryInterface;
use App\Domain\Contestant\ContestantInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

final class ContestRepository extends ServiceEntityRepository implements ContestRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contest::class);
    }

    public function store(ContestInterface $contest) : void
    {
        $this->getEntityManager()->persist($contest);
        $this->getEntityManager()->flush();
    }

    public function hasActive() : bool
    {
        $contest = $this->createQueryBuilder('contest')
            ->where('contest.active = true')
            ->select('count(contest.id) as active_contests')
            ->getQuery()
            ->getOneOrNullResult();

        return $contest['active_contests'] > 0;
    }

    public function findWinner(ContestInterface $contest) : ContestantInterface
    {
        return $this->createQueryBuilder('contest')
            ->innerJoin('contest.contestants', 'contestants')
            ->where('contest = :contest')
            ->andWhere('contestants.winner = true')
            ->getQuery()
            ->getSingleResult();
    }
}
