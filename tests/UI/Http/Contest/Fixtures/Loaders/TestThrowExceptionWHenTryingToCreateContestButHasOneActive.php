<?php

declare(strict_types=1);

namespace App\Tests\UI\Http\Contest\Fixtures\Loaders;

use App\FixtureBuilder\ContestBuilder;
use Speicher210\FunctionalTestBundle\Test\Loader\AbstractLoader;

final class TestThrowExceptionWHenTryingToCreateContestButHasOneActive extends AbstractLoader
{
    public function doLoad(): void
    {
        $contest = ContestBuilder::buildForIdentifier(1);
        $contest->start();

        $this->persist($contest);
    }
}
