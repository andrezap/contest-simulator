<?php

declare(strict_types=1);

namespace App\Domain\Judge;

use MabeEnum\Enum;

class JudgeType extends Enum
{
    public const FRIENDLY = 'FRIENDLY';
    public const HONEST   = 'HONEST';
    public const MEAN     = 'MEAN';
    public const RANDOM   = 'RANDOM';
    public const ROCK     = 'ROCK';
}