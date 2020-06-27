<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Contest\Validator;

use App\Domain\Contest\Repository\ContestRepositoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class HasActiveContestValidator extends ConstraintValidator
{
    private ContestRepositoryInterface $contestRepository;

    public function __construct(ContestRepositoryInterface $contestRepository)
    {
        $this->contestRepository = $contestRepository;
    }

    public function validate($value, Constraint $constraint) : void
    {
        if (! $constraint instanceof HasActiveContest) {
            throw new UnexpectedTypeException($constraint, HasActiveContest::class);
        }

        if ($value === null || $value === '') {
            return;
        }

        $hasActiveContest = $this->contestRepository->hasActive();

        if (! $hasActiveContest) {
            return;
        }

        $this->context->buildViolation($constraint->message)->addViolation();
    }
}
