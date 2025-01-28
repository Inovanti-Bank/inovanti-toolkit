<?php

namespace InovantiBank\Toolkit\Helpers;

class ArrayHelper
{
    public function removeDuplicates(array $array): array
    {
        return array_values(array_unique($array));
    }

    public function isAssociative(array $array): bool
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }

    public function toQueryString(array $data): string
    {
        return http_build_query($data);
    }
}
