<?php

declare(strict_types=1);

namespace App\Domain\Contestant\Exception;

final class NotFoundContestantGenreStrength extends \RuntimeException
{
    public function __construct(?\Throwable $previous = null)
    {
        parent::__construct('Contestant genre strength not found', 0, $previous);
    }
}
