<?php

declare(strict_types=1);

namespace App\Tests\Domain\Contest\Service;

use App\Domain\Contest\ContestInterface;
use App\Domain\Contest\Exception\RunningContestException;
use App\Domain\Contest\Repository\ContestRepositoryInterface;
use App\Domain\Contest\Service\CreateNewContest;
use App\Domain\Contestant\Service\ContestantGenerator;
use App\Domain\Judge\Service\JudgeGenerator;
use App\Domain\Round\Service\RoundGenerator;
use Speicher210\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CreateNewContestTest extends WebTestCase
{
    public function testThrowExceptionWhenThereIsAnActiveContest(): void
    {
        $validatorMock       = $this->createMock(ValidatorInterface::class);
        $repositoryMock      = $this->createMock(ContestRepositoryInterface::class);
        $judgeGenerator      = new JudgeGenerator();
        $roundGenerator      = new RoundGenerator();
        $contestantGenerator = new ContestantGenerator();

        $createNewContest = new CreateNewContest(
            $validatorMock,
            $repositoryMock,
            $contestantGenerator,
            $judgeGenerator,
            $roundGenerator
        );

        $mockConstraintViolation = $this->createMock(ConstraintViolation::class);

        $validatorMock
            ->expects(self::once())
            ->method('validate')
            ->willReturn(new ConstraintViolationList([$mockConstraintViolation]));

        $this->expectException(RunningContestException::class);
        $this->expectExceptionMessage('There is already another contest running.');
        $createNewContest->execute();
    }

    public function testCreateNewContest(): void
    {
        $validatorMock       = $this->createMock(ValidatorInterface::class);
        $repositoryMock      = $this->getContainerService(ContestRepositoryInterface::class);
        $judgeGenerator      = new JudgeGenerator();
        $roundGenerator      = new RoundGenerator();
        $contestantGenerator = new ContestantGenerator();

        $createNewContest = new CreateNewContest(
            $validatorMock,
            $repositoryMock,
            $contestantGenerator,
            $judgeGenerator,
            $roundGenerator
        );

        $validatorMock
            ->expects(self::once())
            ->method('validate')
            ->willReturn(new ConstraintViolationList());

        self::assertCount(0, $repositoryMock->findAll());

        $contest = $createNewContest->execute();

        self::assertTrue($contest->active());
        self::assertCount(1, $repositoryMock->findAll());
        self::assertCount(ContestInterface::MAX_NUMBER_JUDGES, $contest->judges());
        self::assertCount(ContestInterface::MAX_NUMBER_ROUNDS, $contest->rounds());
        self::assertCount(ContestInterface::MAX_NUMBER_CONTESTANTS, $contest->contestants());
    }
}
