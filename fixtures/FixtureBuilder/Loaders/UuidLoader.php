<?php

declare(strict_types=1);

namespace App\FixtureBuilder\Loaders;

use Ramsey\Uuid\Uuid;

final class UuidLoader
{
    private const PATTERN = '00000000-0000-4000-a000-%012d';

    public static function NIL() : string
    {
        return Uuid::NIL;
    }

    public static function forIdentifier(int $identifier) : string
    {
        return \sprintf(self::PATTERN, $identifier);
    }
}
