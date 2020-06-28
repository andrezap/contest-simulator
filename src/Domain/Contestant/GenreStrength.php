<?php

declare(strict_types=1);

namespace App\Domain\Contestant;

use App\Domain\MusicGenre\MusicGenre;

final class GenreStrength
{
    private const MIN_STRENGTH = 1;
    private const MAX_STRENGTH = 10;

    private string $musicGenre;

    private int $score;

    public function __construct(MusicGenre $musicGenre)
    {
        $score            = \random_int(self::MIN_STRENGTH, self::MAX_STRENGTH);
        $this->musicGenre = $musicGenre->value();
        $this->score      = $score;
    }

    /**
     * @return mixed[]
     */
    public function asArray(): array
    {
        return [
            $this->musicGenre => $this->score,
        ];
    }
}
