<?php

declare(strict_types=1);

namespace App\Tests\UI\Http\Contest;

use App\Domain\Contest\Repository\ContestRepositoryInterface;
use Speicher210\FunctionalTestBundle\Test\RestControllerWebTestCase;

final class ContestControllerTest extends RestControllerWebTestCase
{
    public function testCreateAction(): void
    {
        $repository = $this->getContainerService(ContestRepositoryInterface::class);
        self::assertEmpty($repository->findAll());

        $client = static::createClient();

        $client->request('GET', '/contest');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        self::assertCount(1, $repository->findAll());
    }

    public function testThrowExceptionWHenTryingToCreateContestButHasOneActive(): void
    {
        $repository = $this->getContainerService(ContestRepositoryInterface::class);
        self::assertCount(1, $repository->findAll());

        $client = static::createClient();

        $client->request('GET', '/contest');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        self::assertCount(1, $repository->findAll());
    }
}
