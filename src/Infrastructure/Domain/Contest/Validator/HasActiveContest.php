<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Contest\Validator;

use Symfony\Component\Validator\Constraint;

class HasActiveContest extends Constraint
{
    public string $message = 'There is another contest running';

    /**
     * {@inheritDoc}
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
