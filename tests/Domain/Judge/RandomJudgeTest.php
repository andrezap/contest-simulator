<?php

declare(strict_types=1);

namespace App\Tests\Domain\Judge;

use App\Domain\Judge\RandomJudge;
use App\Domain\RoundContestant\RoundContestantInterface;
use Speicher210\FunctionalTestBundle\Test\WebTestCase;

final class RandomJudgeTest extends WebTestCase
{
    public function testCalculateScore(): void
    {
        $roundContestant = $this->createMock(RoundContestantInterface::class);
        $roundContestant->expects(self::never())->method('score');

        $judge = new RandomJudge();

        $finalScore = $judge->calculateScore($roundContestant);

        self::assertLessThanOrEqual(10, $finalScore);
    }
}
