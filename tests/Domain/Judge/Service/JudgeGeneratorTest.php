<?php

declare(strict_types=1);

namespace App\Tests\Domain\Judge\Service;

use App\Domain\Contest\ContestInterface;
use App\Domain\Judge\Service\JudgeGenerator;
use App\FixtureBuilder\ContestBuilder;
use Speicher210\FunctionalTestBundle\Test\WebTestCase;

final class JudgeGeneratorTest extends WebTestCase
{
    public function testJudgeGenerator(): void
    {
        $contest = ContestBuilder::create()->build();
        self::assertCount(0, $contest->judges());

        $judgeGenerator = new JudgeGenerator();
        $judgeGenerator->generateForContest($contest);

        self::assertCount(ContestInterface::MAX_NUMBER_JUDGES, $contest->judges());
    }
}
