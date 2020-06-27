<?php

declare(strict_types=1);

namespace App\Domain\Judge;

use App\Domain\Judge\Exception\JudgeTypeNotFound;

final class JudgeFactory
{
    private const PATH = 'App\Domain\Judge\\';

    public static function build(JudgeType $type): JudgeInterface
    {
        $className = \sprintf('%sJudge', self::PATH . \ucfirst($type->value()));

        if (\class_exists($className)) {
            return new $className();
        }

        throw new JudgeTypeNotFound();
    }
}
