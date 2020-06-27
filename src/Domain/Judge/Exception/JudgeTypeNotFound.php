<?php

declare(strict_types=1);

namespace App\Domain\Judge\Exception;

final class JudgeTypeNotFound extends \RuntimeException
{
    public function __construct(?\Throwable $previous = null)
    {
        parent::__construct('Judge type not found', 0, $previous);
    }
}
