<?php

declare(strict_types=1);

namespace App\Util;

final class SearchMultidimensionalArray
{
    /**
     * @param mixed[] $array
     *
     * @return mixed[]
     */
    public static function searchKey(array $array, string $search): array
    {
        foreach ($array as $item) {
            if (\key($item) === $search) {
                return [\key($item) => $item[\key($item)]];
            }
        }

        return [];
    }
}
