<?php

declare(strict_types=1);

namespace App\Tests\Domain\Contest\Service;

use App\Domain\Contest\Repository\ContestRepositoryInterface;
use App\Domain\Contest\Service\FinishContest;
use App\Domain\Contestant\ContestantInterface;
use App\Domain\Contestant\Repository\ContestantRepositoryInterface;
use App\FixtureBuilder\Loaders\UuidLoader;
use Speicher210\FunctionalTestBundle\Test\WebTestCase;

final class FinishContestTest extends WebTestCase
{
    public function testFinishContest(): void
    {
        $contestRepository = $this->getContainerService(ContestRepositoryInterface::class);
        $contest           = $contestRepository->find(UuidLoader::forIdentifier(2));

        $contestantRepository = $this->getContainerService(ContestantRepositoryInterface::class);
        $contestant           = $contestantRepository->find(UuidLoader::forIdentifier(1));
        \assert($contestant instanceof ContestantInterface);

        self::assertFalse($contestant->isWinner());
        $finishContest = new FinishContest($contestRepository, $contestantRepository);
        $finishContest->execute($contest);

        self::assertFalse($contest->active());
        self::assertTrue($contestant->isWinner());
    }
}
