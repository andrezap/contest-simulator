<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure\Domain\Contest\Repository\Fixtures\Loaders;

use App\FixtureBuilder\ContestBuilder;
use Speicher210\FunctionalTestBundle\Test\Loader\AbstractLoader;

final class TestHasActiveContestReturnsFalse extends AbstractLoader
{
    public function doLoad(): void
    {
        $contest = ContestBuilder::create()->build();

        $this->persist($contest);
    }
}
