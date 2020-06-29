<?php

declare(strict_types=1);

namespace App\Tests\Domain\Judge\Service;

use App\Domain\Contest\ContestInterface;
use App\Domain\Judge\JudgeType;
use App\Domain\Judge\Service\JudgeContestantRound;
use App\Domain\RoundContestant\RoundContestant;
use Speicher210\FunctionalTestBundle\Test\WebTestCase;

class JudgeContestantRoundTest extends WebTestCase
{
    public function testJudgeContestantRound(): void
    {
        $contestMock = $this->createMock(ContestInterface::class);
        $contestMock->expects(self::once())->method('judges')->willReturn($this->getJudges());

        $roundContestantMock = $this->createMock(RoundContestant::class);
        $roundContestantMock->expects(self::atLeast(2))->method('score')->willReturn(12.1);
        $roundContestantMock->expects(self::atLeastOnce())->method('isSick')->willReturn(false);
        $roundContestantMock->expects(self::once())->method('setFinalScore')->with(12);

        $judgeContestantRound = new JudgeContestantRound();
        $judgeContestantRound->execute($contestMock, $roundContestantMock);
    }

    private function getJudges(): array
    {
        $judgesType = JudgeType::getValues();

        $judges = [];

        for ($i = 0; $i < ContestInterface::MAX_NUMBER_JUDGES; $i++) {
            $judges[] = $judgesType[$i];
        }

        return $judges;
    }
}
