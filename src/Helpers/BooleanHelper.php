<?php

namespace InovantiBank\Toolkit\Helpers;

class BooleanHelper
{
    public static function toText(bool $value, string $trueText = 'Sim', string $falseText = 'Não'): string
    {
        return $value ? $trueText : $falseText;
    }

    public static function toInteger(bool $value): int
    {
        return (int) $value;
    }
}
