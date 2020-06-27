<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Contestant\Repository;

use App\Domain\Contest\ContestInterface;
use App\Domain\Contestant\Contestant;
use App\Domain\Contestant\ContestantInterface;
use App\Domain\Contestant\Repository\ContestantRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

final class ContestantRepository extends ServiceEntityRepository implements ContestantRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contestant::class);
    }

    public function findHighestScoreForContest(ContestInterface $contest): ContestantInterface
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

    public function store(ContestantInterface $contestant): void
    {
        $this->getEntityManager()->persist($contestant);
        $this->getEntityManager()->flush();
    }

    public function findLastFiveWinners(): array
    {
        return $this->createQueryBuilder('contestant')
            ->select('SUM(rc.finalScore), contestant')
            ->innerJoin('contestant.roundsContestant', 'rc')
            ->innerJoin('contestant.contest', 'contest')
            ->where('contest.active = false')
            ->andWhere('contestant.winner = true')
            ->groupBy('contestant.id, contest.createdAt')
            ->orderBy('contest.createdAt', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getArrayResult();
    }

    public function findHighestScoreForAllContests(): ?array
    {
        return $this->createQueryBuilder('contestant')
            ->select('SUM(rc.finalScore) as fs, contestant')
            ->innerJoin('contestant.roundsContestant', 'rc')
            ->innerJoin('contestant.contest', 'contest')
            ->where('contest.active = false')
            ->groupBy('contestant.id')
            ->orderBy('fs', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
