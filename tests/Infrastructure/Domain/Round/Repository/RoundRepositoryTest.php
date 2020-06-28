<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure\Domain\Round\Repository;

use App\Domain\Contest\Repository\ContestRepositoryInterface;
use App\Domain\Round\Repository\RoundRepositoryInterface;
use App\FixtureBuilder\Loaders\UuidLoader;
use Speicher210\FunctionalTestBundle\Test\WebTestCase;

final class RoundRepositoryTest extends WebTestCase
{
    public function testFindNextRoundForContest(): void
    {
        $contestRepository = $this->getContainerService(ContestRepositoryInterface::class);
        $contest           = $contestRepository->find(UuidLoader::forIdentifier(1));

        $repository = $this->getContainerService(RoundRepositoryInterface::class);
        \assert($repository instanceof RoundRepositoryInterface);

        $round = $repository->nextRoundForContest($contest);

        self::assertEquals(UuidLoader::forIdentifier(2), $round->id()->toString());
    }
}
