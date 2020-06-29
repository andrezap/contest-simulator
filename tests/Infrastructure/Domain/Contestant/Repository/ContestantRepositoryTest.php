<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure\Domain\Contestant\Repository;

use App\Domain\Contest\Repository\ContestRepositoryInterface;
use App\Domain\Contestant\Repository\ContestantRepositoryInterface;
use App\FixtureBuilder\Loaders\UuidLoader;
use Speicher210\FunctionalTestBundle\Test\WebTestCase;

class ContestantRepositoryTest extends WebTestCase
{
    public function testFindHighestScoreForContest(): void
    {
        $contestRepository = $this->getContainerService(ContestRepositoryInterface::class);
        $contest           = $contestRepository->find(UuidLoader::forIdentifier(1));

        $repository = $this->getContainerService(ContestantRepositoryInterface::class);
        \assert($repository instanceof ContestantRepositoryInterface);

        $contestant = $repository->findHighestScoreForContest($contest);

        self::assertSame(UuidLoader::forIdentifier(1), (string) $contestant->id());
    }

    public function testReturnsNullWhenTryingToFindHighestScoreButNoContestExist(): void
    {
        $repository = $this->getContainerService(ContestantRepositoryInterface::class);
        \assert($repository instanceof ContestantRepositoryInterface);

        $contestant = $repository->findHighestScoreForAllContests();

        self::assertNull($contestant);
    }

    public function testReturnsLastFiveWinners(): void
    {
        $repository = $this->getContainerService(ContestantRepositoryInterface::class);
        \assert($repository instanceof ContestantRepositoryInterface);

        $winners = $repository->findLastFiveWinners();

        self::assertCount(5, $winners);
        self::assertEquals(UuidLoader::forIdentifier(7), (string) $winners[0]['id']);
        self::assertEquals(UuidLoader::forIdentifier(3), (string) $winners[4]['id']);
    }

    public function testFindHighestScoreForAllContests(): void
    {
        $repository = $this->getContainerService(ContestantRepositoryInterface::class);
        \assert($repository instanceof ContestantRepositoryInterface);

        $contestant = $repository->findHighestScoreForAllContests();

        self::assertSame(UuidLoader::forIdentifier(7), (string) $contestant['id']);
    }
}
