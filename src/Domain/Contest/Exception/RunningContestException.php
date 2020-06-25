<?php

declare(strict_types=1);

namespace App\Domain\Contest\Exception;

final class RunningContestException extends \RuntimeException
{
    public function __construct(?\Throwable $previous = null)
    {
        parent::__construct('There is already another contest running ', 0, $previous);
    }
}
