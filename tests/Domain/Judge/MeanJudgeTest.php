<?php

declare(strict_types=1);

namespace App\Tests\Domain\Judge;

use App\Domain\Judge\MeanJudge;
use App\Domain\RoundContestant\RoundContestantInterface;
use Speicher210\FunctionalTestBundle\Test\WebTestCase;

final class MeanJudgeTest extends WebTestCase
{
    public function testCalculateScoreWhenLessThan90(): void
    {
        $roundContestant = $this->createMock(RoundContestantInterface::class);
        $roundContestant->expects(self::once())->method('score')->willReturn(80.0);

        $judge = new MeanJudge();

        $finalScore = $judge->calculateScore($roundContestant);

        self::assertEquals(2, $finalScore);
    }

    public function testCalculateScoreWhenBiggerThan90(): void
    {
        $roundContestant = $this->createMock(RoundContestantInterface::class);
        $roundContestant->expects(self::once())->method('score')->willReturn(95.0);

        $judge = new MeanJudge();

        $finalScore = $judge->calculateScore($roundContestant);

        self::assertEquals(10, $finalScore);
    }
}
