<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure\Domain\Contest\Repository;

use App\Domain\Contest\Repository\ContestRepositoryInterface;
use Speicher210\FunctionalTestBundle\Test\WebTestCase;

final class ContestRepositoryTest extends WebTestCase
{
    public function testHasActiveContest(): void
    {
        $repository = $this->getContainerService(ContestRepositoryInterface::class);
        \assert($repository instanceof ContestRepositoryInterface);

        self::assertTrue($repository->hasActive());
    }

    public function testHasActiveContestReturnsFalse(): void
    {
        $repository = $this->getContainerService(ContestRepositoryInterface::class);
        \assert($repository instanceof ContestRepositoryInterface);

        self::assertFalse($repository->hasActive());
    }
}
