<?php

declare(strict_types=1);

namespace App\Tests\Domain\Contest\Service\Fixtures\Loaders;

use App\FixtureBuilder\ContestantBuilder;
use App\FixtureBuilder\ContestBuilder;
use App\FixtureBuilder\Loaders\RoundContestantBuilder;
use App\FixtureBuilder\RoundBuilder;
use Speicher210\FunctionalTestBundle\Test\Loader\AbstractLoader;

final class TestFinishContest extends AbstractLoader
{
    public function doLoad(): void
    {
        $contestant_1 = ContestantBuilder::create()->build();
        $contestant_2 = ContestantBuilder::forIdentifier(1)->build();

        $contest = ContestBuilder::forIdentifier(2)
            ->withContestant($contestant_1)
            ->withContestant($contestant_2)
            ->build();

        $round = RoundBuilder::createForContest($contest)->build();

        $roundContestant_1 = RoundContestantBuilder::create($round, $contestant_1)->withFinalScore(10)->build();
        $roundContestant_2 = RoundContestantBuilder::create($round, $contestant_2)->withFinalScore(20)->build();

        $this->persist($round);
        $this->persist($roundContestant_1);
        $this->persist($roundContestant_2);
        $this->persist($contest);
    }
}
