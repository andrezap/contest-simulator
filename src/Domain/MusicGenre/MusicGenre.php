<?php

declare(strict_types=1);

namespace App\Domain\MusicGenre;

use MabeEnum\Enum;

class MusicGenre extends Enum
{
    public const ROCK    = 'ROCK';
    public const COUNTRY = 'COUNTRY';
    public const POP     = 'POP';
    public const DISCO   = 'DISCO';
    public const JAZZ    = 'JAZZ';
    public const BLUE    = 'THE BLUES';

    public function value(): string
    {
        /** @var mixed $value */
        $value = $this->getValue();

        return (string) $value;
    }
}
