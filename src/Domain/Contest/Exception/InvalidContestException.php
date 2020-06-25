<?php

declare(strict_types=1);

namespace App\Domain\Contest\Exception;

final class InvalidContestException extends \RuntimeException
{
    public function __construct(?\Throwable $previous = null)
    {
        parent::__construct('Contest has an invalid state ', 0, $previous);
    }
}
