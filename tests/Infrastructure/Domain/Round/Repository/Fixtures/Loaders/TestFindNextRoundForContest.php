<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure\Domain\Round\Repository\Fixtures\Loaders;

use App\FixtureBuilder\ContestBuilder;
use App\FixtureBuilder\Loaders\UuidLoader;
use App\FixtureBuilder\RoundBuilder;
use Speicher210\FunctionalTestBundle\Test\Loader\AbstractLoader;

final class TestFindNextRoundForContest extends AbstractLoader
{
    public function doLoad(): void
    {
        $contest = ContestBuilder::buildForIdentifier(1);

        $round_1 = RoundBuilder::createForContest($contest)
            ->withId(UuidLoader::forIdentifier(1))
            ->build();

        $round_1->finish();

        $round_2 = RoundBuilder::createForContest($contest)
            ->withId(UuidLoader::forIdentifier(2))
            ->withNumber(2)
            ->build();

        $this->persist($round_1);
        $this->persist($round_2);
        $this->persist($contest);
    }
}
