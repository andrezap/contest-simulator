<?php

declare(strict_types=1);

namespace App\Domain\Judge;

use MabeEnum\Enum;

class JudgeType extends Enum
{
    public const FRIENDLY = 'Friendly';
    public const HONEST   = 'Honest';
    public const MEAN     = 'Mean';
    public const RANDOM   = 'Random';
    public const ROCK     = 'Rock';

    public function value(): string
    {
        /** @var mixed $value */
        $value = $this->getValue();

        return (string) $value;
    }
}