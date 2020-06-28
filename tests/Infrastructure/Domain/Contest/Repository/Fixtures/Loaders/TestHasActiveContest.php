<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure\Domain\Contest\Repository\Fixtures\Loaders;

use App\FixtureBuilder\ContestBuilder;
use Speicher210\FunctionalTestBundle\Test\Loader\AbstractLoader;

final class TestHasActiveContest extends AbstractLoader
{
    public function doLoad(): void
    {
        $contest = ContestBuilder::create()->build();

        $contest->start();

        $this->persist($contest);
    }
}
