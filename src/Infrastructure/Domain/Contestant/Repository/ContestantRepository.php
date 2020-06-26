<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Contestant\Repository;

use App\Domain\Contest\ContestInterface;
use App\Domain\Contestant\Contestant;
use App\Domain\Contestant\Repository\ContestantRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

final class ContestantRepository extends ServiceEntityRepository implements ContestantRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contestant::class);
    }

    public function findWinner(ContestInterface $contest)
    {
        return $this->createQueryBuilder('contestant')
            ->innerJoin('contestant.roundsContestant', 'rc')
            ->where('contestant.contest = :contest')
            ->setParameter('contest', $contest)
            ->select('SUM(rc.finalScore) as final_score, contestant')
            ->groupBy('contestant.id')
            ->orderBy('final_score', 'DESC')
            ->getQuery()
            ->setMaxResults(1)
            ->getSingleResult();
    }
}