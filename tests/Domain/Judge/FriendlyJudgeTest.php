<?php

declare(strict_types=1);

namespace App\Tests\Domain\Judge;

use App\Domain\Judge\FriendlyJudge;
use App\Domain\RoundContestant\RoundContestantInterface;
use Speicher210\FunctionalTestBundle\Test\WebTestCase;

final class FriendlyJudgeTest extends WebTestCase
{
    /**
     * @return mixed[]
     */
    public function dataProviderCalculateScoreWhenContestantIsSick(): array
    {
        return [
            [2, 8],
            [3, 8],
            [4, 9],
        ];
    }

    /**
     * @dataProvider dataProviderCalculateScoreWhenContestantIsSick
     */
    public function testCalculateScoreWhenContestantIsSick(float $score, int $expected): void
    {
        $roundContestant = $this->createMock(RoundContestantInterface::class);
        $roundContestant->expects(self::once())->method('score')->willReturn($score);
        $roundContestant->expects(self::once())->method('isSick')->willReturn(true);

        $judge      = new FriendlyJudge();
        $finalScore = $judge->calculateScore($roundContestant);

        self::assertEquals($expected, $finalScore);
    }

    /**
     * @return mixed[]
     */
    public function dataProviderCalculateScoreWhenContestantIsNotSick(): array
    {
        return [
            [2, 7],
            [3, 7],
            [4, 8],
        ];
    }

    /**
     * @dataProvider dataProviderCalculateScoreWhenContestantIsNotSick
     */
    public function testCalculateScoreWhenContestantIsNotSick(float $score, int $expected): void
    {
        $roundContestant = $this->createMock(RoundContestantInterface::class);
        $roundContestant->expects(self::once())->method('score')->willReturn($score);
        $roundContestant->expects(self::once())->method('isSick')->willReturn(false);

        $judge      = new FriendlyJudge();
        $finalScore = $judge->calculateScore($roundContestant);

        self::assertEquals($expected, $finalScore);
    }
}
