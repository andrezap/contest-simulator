<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Round\Repository;

use App\Domain\Contest\ContestInterface;
use App\Domain\Round\Repository\RoundRepositoryInterface;
use App\Domain\Round\Round;
use App\Domain\Round\RoundInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class RoundRepository extends ServiceEntityRepository implements RoundRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Round::class);
    }

    public function nextRoundForContest(ContestInterface $contest): ?RoundInterface
    {
        $nextRound = $this->createQueryBuilder('round')
            ->where('round.finished = false')
            ->andWhere('round.contest = :contest')
            ->setParameter('contest', $contest)
            ->setMaxResults(1)
            ->orderBy('round.number', 'ASC');

        return $nextRound->getQuery()->getOneOrNullResult();
    }

    public function store(RoundInterface $round): void
    {
        $this->getEntityManager()->persist($round);
        $this->getEntityManager()->flush();
    }
}
