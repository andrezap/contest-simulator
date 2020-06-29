<?php

declare(strict_types=1);

namespace App\Tests\Domain\Round\service;

use App\Domain\Contest\ContestInterface;
use App\Domain\Round\Service\RoundGenerator;
use Speicher210\FunctionalTestBundle\Test\WebTestCase;

final class RoundGeneratorTest extends WebTestCase
{
    public function testRoundGenerator(): void
    {
        $contest = $this->createMock(ContestInterface::class);
        $contest->expects(self::exactly(ContestInterface::MAX_NUMBER_ROUNDS))->method('addRound');

        $roundGenerator = new RoundGenerator();
        $roundGenerator->generateForContest($contest);
    }
}
