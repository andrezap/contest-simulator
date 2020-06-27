<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Contestant\Repository;

use App\Domain\Contest\ContestInterface;
use App\Domain\Contestant\Contestant;
use App\Domain\Contestant\ContestantInterface;
use App\Domain\Contestant\Repository\ContestantRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ManagerRegistry;

final class ContestantRepository extends ServiceEntityRepository implements ContestantRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contestant::class);
    }

    public function findHighestScoreForContest(ContestInterface $contest) : ContestantInterface
    {
        return $this->createQueryBuilder('contestant')
            ->innerJoin('contestant.roundsContestant', 'rc')
            ->where('contestant.contest = :contest')
            ->setParameter('contest', $contest)
            ->groupBy('contestant.id')
            ->orderBy('SUM(rc.finalScore)', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult();
    }

    public function store(ContestantInterface $contestant) : void
    {
        $this->getEntityManager()->persist($contestant);
        $this->getEntityManager()->flush();
    }

    public function findLastFiveWinners() : array
    {
        return $this->createQueryBuilder('contestant')
            ->innerJoin('contestant.contest', 'contest')
            ->where('contestant.winner = true')
            ->orderBy('contest.createdAt')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    public function findHighestScoreForAllContests() : array
    {
        return $this->createQueryBuilder('contestant')
            ->innerJoin('contestant.roundsContestant', 'rc')
            ->innerJoin('contestant.contest', 'contest')
            ->where('contest = :contest')
            ->where('contest.active = false')
            ->groupBy('contestant.id')
            ->select('SUM(rc.finalScore) as fs, contestant')
            ->orderBy('fs', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult();
    }
}