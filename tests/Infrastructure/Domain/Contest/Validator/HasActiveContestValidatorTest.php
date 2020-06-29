<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure\Domain\Contest\Validator;

use App\Domain\Contest\Repository\ContestRepositoryInterface;
use App\FixtureBuilder\ContestBuilder;
use App\Infrastructure\Domain\Contest\Validator\HasActiveContest;
use App\Infrastructure\Domain\Contest\Validator\HasActiveContestValidator;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

final class HasActiveContestValidatorTest extends ConstraintValidatorTestCase
{
    /** @var  ContestRepositoryInterface|MockObject */
    private $repositoryMock;

    public function testExceptionIsThrownIfConstraintsIsNotCorrectInstance(): void
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage(
            \sprintf(
                'Expected argument of type "%s", "%s" given',
                HasActiveContest::class,
                StubConstraint::class
            )
        );
        $this->validator->validate(null, new StubConstraint());
    }

    public function testNoViolationIfValueIsNull(): void
    {
        $constraint = new HasActiveContest();

        $this->validator->validate(null, $constraint);
        $this->assertNoViolation();
    }

    public function testExceptionIsThrownIfHasAnActiveContest(): void
    {
        $constraint = new HasActiveContest();
        $contest    = ContestBuilder::create()->build();

        $this->repositoryMock->expects(self::once())->method('hasActive')->willReturn(true);
        $this->validator->validate($contest, $constraint);

        $this
            ->buildViolation($constraint->message)
            ->assertRaised();
    }

    protected function createValidator(): HasActiveContestValidator
    {
        $this->repositoryMock = $this->createMock(ContestRepositoryInterface::class);

        return new HasActiveContestValidator($this->repositoryMock);
    }
}
